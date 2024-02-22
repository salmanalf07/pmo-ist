<?php

namespace App\Http\Controllers;

use App\Models\decisionMom;
use App\Models\discussionMom;
use App\Models\followupMom;
use App\Models\mom;
use App\Models\partMom;
use App\Models\Project;
use DOMDocument;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class momController extends Controller
{
    public function json($id)
    {
        $data = mom::where('projectId', $id)->orderBy('created_at', 'DESC');

        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                $editButton = auth()->user()->canany(['bisa-ubah', 'mom-editor']) ?
                    '<a href="/editMom/' . $data->id . '" class="btn btn-ghost btn-icon btn-sm rounded-circle" data-bs-toggle="tooltip" data-placement="top" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>' : '';

                $pdfButton = auth()->user()->canany(['bisa-ubah', 'mom-editor']) ?
                    '<a href="/exportPdf/' . $data->id . '" target="_blank" class="btn btn-ghost btn-icon btn-sm rounded-circle" data-bs-toggle="tooltip" data-placement="top" title="Export PDF">
                    <i class="bi bi-filetype-pdf"></i>
                </a>' : '';

                $deleteButton = auth()->user()->canany(['bisa-hapus', 'mom-editor']) ?
                    '<button id="delete" data-id="' . $data->id . '" class="btn btn-ghost btn-icon btn-sm rounded-circle" data-bs-toggle="tooltip" data-placement="top" title="Delete">
                    <i class="bi bi-trash"></i>
                </button>' : '';

                return $pdfButton . $editButton . $deleteButton;
            })
            ->addColumn('agendaRender', function ($data) {
                // Mengganti tag <p> dengan string kosong
                $agendaWithoutP = str_replace('<p>', '', $data->agenda);
                $agendaWithoutP = str_replace('</p>', '', $agendaWithoutP);

                return $agendaWithoutP;
            })
            ->rawColumns(['aksi', 'agendaRender'])
            ->toJson();
    }

    function edit(Request $request, $id)
    {
        $get = mom::with('discussions', 'decisions')->find($id);
        if ($request->segment(1) == "editMom") {
            $aksi = 'EditData';

            $project = Project::with('customer')->find($get->projectId);
            $referensi = $get->projectId;
            $partCust = partMom::where([
                ['momId', $get->id],
                ['typeParticipant', "customer"],
            ])->get();

            $partMii = partMom::where([
                ['momId', $get->id],
                ['typeParticipant', "MII"],
            ])->get();

            $discussion = discussionMom::where('momId', $get->id)->first();
            $decisions = decisionMom::where('momId', $get->id)->first();
            $meetingFu = followupMom::where([
                ['momId', $get->id],
            ])->get();
        } else {
            $aksi = 'Add';

            $project = Project::with('customer')->find($id);
            $referensi = $id;
            $partCust = "#";

            $partMii = "#";

            $discussion = discussionMom::where('momId', $id)->first();
            $decisions = decisionMom::where('momId', $id)->first();
            $meetingFu = "#";
        }


        return view('project/formMoms', ['id' => $referensi, 'aksi' => $aksi, 'data' => $get, 'project' => $project, 'partCust' => $partCust, 'partMii' => $partMii, 'discussion' => $discussion, 'decisions' => $decisions, 'meetingFu' => $meetingFu]);
    }

    function store_quill(Request $request)
    {
        try {
            if ($request->key == "discussion") {
                if ($request->uid != "#") {
                    $post = discussionMom::find($request->uid);
                } else {
                    $post = new discussionMom();
                }
                $post->discussion = $request->konten;
                $post->momId = $request->momId;

                $post->save();
            }

            return response()->json(['message' => 'Content saved successfully', 'post' => $post->id, 'key' => $request->key]);
        } catch (QueryException $e) {
            // Handle any database-related exceptions
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Catch any other exceptions
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    function meeting_information(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // Validasi data
            $validator = Validator::make($request->all(), [
                'date' => 'required|string|max:255',
                'time' => 'required|string|max:255',
                'venue' => 'required|string|max:255',
                'agendaContent' => 'required|string|max:255',
                'chaired' => 'required|string|max:255',
                'pmCust' => 'required|string|max:255',
                // ... tambahkan aturan validasi lainnya
            ]);

            if ($validator->fails()) {
                throw new \Exception('Data tidak valid'); // Melempar exception jika validasi gagal
            }


            $post = mom::findOrNew($request->momId);
            $post->projectId = $id;
            $post->dateMom = date("Y-m-d", strtotime(str_replace('-', '-', $request->date)));
            $post->timeMom = $request->time;
            $post->venue = $request->venue;
            $post->agenda = $request->agendaContent;
            $post->chairedBy = $request->chaired;
            $post->pmCust = $request->pmCust;
            $post->save();

            $idCustomer = $request->idCustomer;
            $customer = collect($request->customer)->filter()->all();
            $mailCustomer = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->mailCustomer);

            for ($count = 0; $count < count($customer); $count++) {
                if ($customer[$count] != null) {
                    $postCustomer = partMom::findOrNew($idCustomer[$count]);
                    $postCustomer->momId = $post->id;
                    $postCustomer->typeParticipant = "customer";
                    $postCustomer->name = $customer[$count];
                    $postCustomer->email = $mailCustomer[$count];
                    $postCustomer->save();
                }
            }

            $idMii = $request->idMii;
            $mii = collect($request->mii)->filter()->all();
            $mailMii = array_map(function ($value) {
                return $value !== null ? $value : null;
            }, $request->mailMii);

            for ($countt = 0; $countt < count($mii); $countt++) {
                if ($mii[$countt] != null) {
                    $postMii = partMom::findOrNew($idMii[$countt]);
                    $postMii->momId = $post->id;
                    $postMii->typeParticipant = "MII";
                    $postMii->name = $mii[$countt];
                    $postMii->email = $mailMii[$countt];
                    $postMii->save();
                }
            }


            DB::commit(); // Commit transaksi jika berhasil

            // Berikan respons bahwa operasi berhasil
            return response()->json(['message' => 'Operasi berhasil', 'id' => $id, 'idMom' => $post->id], 200);
        } catch (\Exception  $e) {
            DB::rollback(); // Batalkan transaksi jika terjadi kesalahan
            // Handle kesalahan atau tindakan lain yang perlu dilakukan jika terjadi kesalahan validasi atau operasi database
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    function meeting_fu(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $idFu = $request->idFu;
            $actionFu = collect($request->actionFu)->filter()->all();
            $picFu = array_map(function ($value) {
                return $value !== null ? $value : "";
            }, $request->picFu);;
            $targetFu = collect($request->targetFu)->filter()->all();
            $notesFu = array_map(function ($value) {
                return $value !== null ? $value : "";
            }, $request->notesFu);

            for ($count = 0; $count < count($actionFu); $count++) {
                if ($actionFu[$count] != null) {
                    $fuBase = followupMom::findOrNew($idFu[$count]);
                    $fuBase->momId = $id;
                    $fuBase->action = $actionFu[$count];
                    $fuBase->pic = $picFu[$count];
                    $fuBase->targetDate = date("Y-m-d", strtotime(str_replace('-', '-', $targetFu[$count])));
                    $fuBase->notes = $notesFu[$count];
                    $fuBase->save();
                }
            }
            $data = followupMom::where('momId', $id)->get();
            DB::commit(); // Commit transaksi jika berhasil

            // Berikan respons bahwa operasi berhasil
            return response()->json(['message' => 'Operasi berhasil', 'id' => $id, 'data' => $data], 200);
        } catch (\Exception  $e) {
            DB::rollback(); // Batalkan transaksi jika terjadi kesalahan
            // Handle kesalahan atau tindakan lain yang perlu dilakukan jika terjadi kesalahan validasi atau operasi database
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    function deleteParticipant(Request $request, $id)
    {
        $post = partMom::find($id);
        $post->delete();

        return response()->json($post, 200);
    }

    function deleteMom($id)
    {
        $post = mom::with('discussions', 'decisions', 'followup', 'participant')->find($id);
        $post->participant()->delete();
        $post->decisions()->delete();
        $post->followup()->delete();
        $post->participant()->delete();
        $post->delete();

        return response()->json($post, 200);
    }

    function exportMom($id)
    {
        $data = mom::with('discussions', 'decisions')->find($id);
        $project = Project::with('customer', 'pm')->find($data->projectId);

        $partCust = partMom::where([
            ['momId', $data->id],
            ['typeParticipant', "customer"],
        ])->get();

        $partMii = partMom::where([
            ['momId', $data->id],
            ['typeParticipant', "MII"],
        ])->get();

        $discussion = discussionMom::where('momId', $data->id)->first();
        $decisions = decisionMom::where('momId', $data->id)->first();
        $meetingFu = followupMom::where([
            ['momId', $data->id],
        ])->get();

        if (count($partCust) > count($partMii)) {
            $for = count($partCust);
        } else {
            $for = count($partMii);
        }


        //return view('pdf/exportMom', ['data' => $data, 'project' => $project, 'partCust' => $partCust, 'partMii' => $partMii, 'discussion' => $discussion, 'decisions' => $decisions, 'meetingFu' => $meetingFu, 'for' => $for]);
        $pdf = PDF::loadView('pdf.exportMom', compact('data', 'project', 'partCust', 'partMii', 'discussion', 'decisions', 'meetingFu', 'for'));
        // Mengubah orientasi menjadi lanskap
        $pdf->setPaper('a4');

        return $pdf->stream('MOM.pdf');
    }
}
