<?php

namespace App\Exports;

use App\Models\topProject;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class statPaymentExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
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
                        // Cek apakah $relatedData null atau '#'
                        if (is_null($relatedData) || $relatedData === '#') {
                            $relatedData = null; // Set $relatedData menjadi null dan keluar dari loop
                            break;
                        }
                        $relatedData = $relatedData->{$relatedColumn};
                    }

                    // Atur nilai pada $rowData[$heading] sesuai kondisi null atau tidaknya
                    if (is_null($relatedData)) {
                        $rowData[$heading] = ''; // Atau bisa diatur menjadi nilai default lainnya
                    } else {
                        $rowData[$heading] = $relatedData;
                    }
                } else {
                    // Cek apakah kolom adalah tanggal
                    $isDateColumn = false; // Tambahkan variabel untuk menandai kolom tanggal
                    // Misal, jika kolom memiliki format 'YYYY-MM-DD'
                    if ($column === 'payDate') {
                        $isDateColumn = true;
                    }

                    if ($isDateColumn) {
                        // Ubah format tanggal sesuai kebutuhan (misal: 'd-m-Y')
                        $rowData[$heading] = \Carbon\Carbon::parse($item->{$column})->format('d-M-Y');
                    } else {
                        $rowData[$heading] = $item->{$column};
                    }
                }
            }
            return $rowData;
        });
    }



    public function headings(): array
    {
        return [
            'project.customer.company' => 'Customer',
            'project.projectName' => 'Project Name',
            'project.noContract' => 'No Contract',
            'termsName' => 'Terms Name',
            'termsValuePPN' => 'Terms Value',
            'payDate' => 'Payment Date',

        ];
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
