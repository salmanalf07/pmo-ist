<?php

namespace App\Http\Controllers;

use App\Models\issuesProject;
use App\Models\Project;
use App\Models\riskProject;
use App\Models\topProject;
use App\Models\weeklyReport;
use App\Models\WReportMilestone;
use App\Models\WReportRiskIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class weeklyReportController extends Controller
{
    public function json($id)
    {
        $data = weeklyReport::where('projectId', $id)->orderBy('created_at', 'DESC');

        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                $editButton = auth()->user()->canany(['bisa-ubah', 'weekly-editor']) ?
                    '<a href="/editWeeklyReport/' . $data->id . '" class="btn btn-ghost btn-icon btn-sm rounded-circle" data-bs-toggle="tooltip" data-placement="top" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>' : '';

                $pdfButton = auth()->user()->canany(['bisa-ubah', 'weekly-editor']) ?
                    '<a href="/exportWeeklyReport/' . $data->id . '" target="_blank" class="btn btn-ghost btn-icon btn-sm rounded-circle" data-bs-toggle="tooltip" data-placement="top" title="Export PDF">
                    <i class="bi bi-filetype-pdf"></i>
                </a>' : '';

                $deleteButton = auth()->user()->canany(['bisa-hapus', 'weekly-editor']) ?
                    '<button id="delete" data-id="' . $data->id . '" class="btn btn-ghost btn-icon btn-sm rounded-circle" data-bs-toggle="tooltip" data-placement="top" title="Delete">
                    <i class="bi bi-trash"></i>
                </button>' : '';

                return $pdfButton . $editButton . $deleteButton;
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    function edit(Request $request, $id)
    {
        $get = weeklyReport::find($id);
        $getMilestone = WReportMilestone::where('wReportId', '=', $id)->get();
        $getRisk = WReportRiskIssue::where([
            ['wReportId', '=', $id],
            ['type', '=', "risk"]
        ])->get();
        $getIssue = WReportRiskIssue::where([
            ['wReportId', '=', $id],
            ['type', '=', "issue"]
        ])->get();
        if ($request->segment(1) == "editWeeklyReport") {
            $aksi = 'EditData';

            $project = Project::with('customer')->find($get->projectId);
            $top = topProject::where('projectId', $get->projectId)->orderByRaw('CONVERT(noRef, SIGNED) asc')->get();
            $milestone = topProject::with(['milestone' => function ($query) use ($id, $getMilestone) {
                if (count($getMilestone) > 0) {
                    $query->where('wReportId', $id);
                }
            }])
                ->where('projectId', $get->projectId)->orderByRaw('CONVERT(noRef, SIGNED) asc')->get();
            $risk = riskProject::with(['riskWeeklyReport' => function ($query) use ($id, $getRisk) {
                if (count($getRisk) > 0) {
                    $query->where('wReportId', $id);
                }
            }])->where('projectId', $get->projectId)->get();
            $issue = issuesProject::with(['issueWeeklyReport' => function ($query) use ($id, $getIssue) {
                if (count($getIssue) > 0) {
                    $query->where('wReportId', $id);
                }
            }])->where('projectId', $get->projectId)->get();

            $referensi = $get->projectId;
        } else {
            $aksi = 'Add';

            $referensi = $id;
            $top = topProject::where('projectId', $id)->orderByRaw('CONVERT(noRef, SIGNED) asc')->get();
            $milestone = topProject::with('milestone')

                ->where('projectId',  $id)->orderByRaw('CONVERT(noRef, SIGNED) asc')->get();
            $risk = riskProject::with('riskWeeklyReport')->where('projectId', $id)->get();
            $issue = issuesProject::with('issueWeeklyReport')->where('projectId', $id)->get();
            $project = Project::with('customer')->find($id);
        }


        // return $issue;
        return view('project/formWeeklyReport', ['id' => $referensi, 'aksi' => $aksi, 'data' => $get, 'project' => $project, 'risk' => $risk, 'issue' => $issue, 'milestone' => $milestone, 'top' => $top]);
    }

    function meeting_information(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // Validasi data
            $validator = Validator::make($request->all(), [
                'periode' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                throw new \Exception('Data tidak valid'); // Melempar exception jika validasi gagal
            }


            $post = weeklyReport::findOrNew($request->weeklyId);
            $post->projectId = $id;
            $post->periode = $request->periode;
            $post->currentStage = $request->currentStage;
            $post->traficLight = $request->traficLight;
            $post->PMCust = $request->PMCust;
            $post->issuedDate = date("Y-m-d", strtotime(str_replace('-', '-', $request->issuedDate)));
            $post->save();

            DB::commit(); // Commit transaksi jika berhasil

            // Berikan respons bahwa operasi berhasil
            return response()->json(['message' => 'Operasi berhasil', 'id' => $id, 'weeklyId' => $post->id], 200);
        } catch (\Exception  $e) {
            DB::rollback(); // Batalkan transaksi jika terjadi kesalahan
            // Handle kesalahan atau tindakan lain yang perlu dilakukan jika terjadi kesalahan validasi atau operasi database
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    function storeMilestone(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // Validasi data
            $idmilestone = $request->idmilestone;
            $idtop = $request->idtop;
            $finishDate = collect($request->endDate)->filter()->all();
            $status = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->status);
            $notes = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->notes);

            for ($count = 0; $count < count($idtop); $count++) {
                $postt = WReportMilestone::findOrNew($idmilestone[$count]);
                $postt->wReportId = $id;
                $postt->topId = $idtop[$count];
                if ($finishDate) {
                    $postt->finishDate = date("Y-m-d", strtotime(str_replace('-', '-', $finishDate[$count])));
                }
                $postt->status = $status[$count];
                $postt->notes = $notes[$count];

                $postt->save();
            }
            $data = WReportMilestone::where('wReportId', $id)->get();

            DB::commit(); // Commit transaksi jika berhasil

            // Berikan respons bahwa operasi berhasil
            return response()->json(['message' => 'Operasi berhasil', 'id' => $id, 'data' => $data], 200);
        } catch (\Exception  $e) {
            DB::rollback(); // Batalkan transaksi jika terjadi kesalahan
            // Handle kesalahan atau tindakan lain yang perlu dilakukan jika terjadi kesalahan validasi atau operasi database
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    function storeWeekRisk(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // Validasi data
            $idRisk = $request->idRisk;
            $riskIssueId = $request->idRiskRef;
            $responPlan = collect($request->responPlanRisk)->filter()->all();
            $codeId = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->idRiskID);
            $owner = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->ownerRisk);
            $severity = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->severityRisk);
            $status = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->statusRisk);
            $dueDate = collect($request->dueDateRisk)->filter()->all();

            for ($count = 0; $count < count($riskIssueId); $count++) {
                $postt = WReportRiskIssue::findOrNew($idRisk[$count]);
                $postt->wReportId = $id;
                $postt->riskIssueId = $riskIssueId[$count];
                $postt->codeId = $codeId[$count];
                if ($responPlan) {
                    $postt->responPlan = date("Y-m-d", strtotime(str_replace('-', '-', $responPlan[$count])));
                }
                $postt->type = "risk";
                $postt->owner = $owner[$count];
                $postt->severity = $severity[$count];
                $postt->status = $status[$count];
                if ($dueDate) {
                    $postt->dueDate = date("Y-m-d", strtotime(str_replace('-', '-', $dueDate[$count])));
                }

                $postt->save();
            }
            $data = WReportRiskIssue::where([
                ['wReportId', '=', $id],
                ['type', '=', "risk"]
            ])->get();

            DB::commit(); // Commit transaksi jika berhasil

            // Berikan respons bahwa operasi berhasil
            return response()->json(['message' => 'Operasi berhasil', 'id' => $id, 'data' => $data], 200);
        } catch (\Exception  $e) {
            DB::rollback(); // Batalkan transaksi jika terjadi kesalahan
            // Handle kesalahan atau tindakan lain yang perlu dilakukan jika terjadi kesalahan validasi atau operasi database
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
    function storeWeekIssue(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // Validasi data
            $idIssue = $request->idIssue;
            $riskIssueId = $request->idIssueRef;
            $responPlan = collect($request->responPlanIssue)->filter()->all();
            $codeId = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->idIssueID);
            $owner = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->ownerIssue);
            $severity = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->severityIssue);
            $status = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->statusIssue);
            $dueDate = collect($request->dueDateIssue)->filter()->all();

            for ($count = 0; $count < count($riskIssueId); $count++) {
                $postt = WReportRiskIssue::findOrNew($idIssue[$count]);
                $postt->wReportId = $id;
                $postt->riskIssueId = $riskIssueId[$count];
                $postt->codeId = $codeId[$count];
                if ($responPlan) {
                    $postt->responPlan = date("Y-m-d", strtotime(str_replace('-', '-', $responPlan[$count])));
                }
                $postt->type = "issue";
                $postt->owner = $owner[$count];
                $postt->severity = $severity[$count];
                $postt->status = $status[$count];
                if ($dueDate) {
                    $postt->dueDate = date("Y-m-d", strtotime(str_replace('-', '-', $dueDate[$count])));
                }

                $postt->save();
            }
            $data = WReportRiskIssue::where([
                ['wReportId', '=', $id],
                ['type', '=', "issue"]
            ])->get();

            DB::commit(); // Commit transaksi jika berhasil

            // Berikan respons bahwa operasi berhasil
            return response()->json(['message' => 'Operasi berhasil', 'id' => $id, 'data' => $data], 200);
        } catch (\Exception  $e) {
            DB::rollback(); // Batalkan transaksi jika terjadi kesalahan
            // Handle kesalahan atau tindakan lain yang perlu dilakukan jika terjadi kesalahan validasi atau operasi database
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $post = weeklyReport::with('riskIssue', 'milestone')->find($id);
        $post->riskIssue()->delete();
        $post->milestone()->delete();
        $post->delete();
    }
}
