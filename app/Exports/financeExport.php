<?php

namespace App\Exports;

use App\Models\topProject;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class financeExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $data;
    protected $segment;

    public function __construct($data, $segment)
    {
        $this->data = $data;
        $this->segment = $segment;
    }

    public function collection()
    {
        $columns = $this->headings(); // Simpan referensi ke method headings() dalam variabel $columns

        return $this->data->map(function ($item) use ($columns) {
            $rowData = [];
            foreach ($columns as $column => $heading) {
                if (strpos($column, '.') !== false) {
                    // Menghandle eager loading (with)
                    $relatedData = $item;
                    $relatedColumns = explode('.', $column);
                    foreach ($relatedColumns as $relatedColumn) {
                        $relatedData = $relatedData->{$relatedColumn};
                    }
                    $rowData[$heading] = $relatedData;
                } else {
                    $rowData[$heading] = $item->{$column};
                }
            }
            return $rowData;
        });
    }

    public function headings(): array
    {
        if ($this->segment == "financeExport") {

            return [
                'project.customer.company' => 'Customer',
                'project.projectName' => 'Project Name',
                'project.noContract' => 'No Contract',
                'termsName' => 'Terms Name',
                'termsValuePPN' => 'Terms of Payment',
                'bastDate' => 'Plan/BAST Date',
            ];
        }

        if ($this->segment == "financeByInvoiceExport") {

            return [
                'project.customer.company' => 'Customer',
                'project.projectName' => 'Project Name',
                'project.noContract' => 'No Contract',
                'termsName' => 'Terms Name',
                'termsValuePPN' => 'Terms of Payment',
                'invDate' => 'Invoice Date',
            ];
        }

        if ($this->segment == "financeByPaymentExport") {

            return [
                'project.customer.company' => 'Customer',
                'project.projectName' => 'Project Name',
                'project.noContract' => 'No Contract',
                'termsName' => 'Terms Name',
                'termsValuePPN' => 'Terms of Payment',
                'payDate' => 'Payment Date',
            ];
        }

        if ($this->segment == "financeTermsStatExport") {
            return [
                'project.customer.company' => 'Customer',
                'project.projectName' => 'Project Name',
                'project.noContract' => 'No Contract',
                'termsName' => 'Terms Name',
                'termsValuePPN' => 'Terms of Payment',
                'bastDate' => 'Plan/BAST Date',
                'invDate' => 'Invoice Date',
                'payDate' => 'Payment Date',
            ];
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:' . $event->sheet->getHighestColumn() . $event->sheet->getHighestRow())
                    ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $event->sheet->getStyle('A1:' . $event->sheet->getHighestColumn() . '1')->getFont()->setBold(true);

                $event->sheet->getStyle('A1:' . $event->sheet->getHighestColumn() . $event->sheet->getHighestRow())
                    ->getAlignment()->setWrapText(true);

                $event->sheet->getDefaultColumnDimension()->setWidth(20);
            },
        ];
    }
}
