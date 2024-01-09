<?php

namespace App\Exports;

use App\Models\topProject;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class planInvhByCustExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
    public function collection()
    {
        // Menyiapkan array untuk heading
        $headings = ['Customer', 'Member Project'];

        // Menambahkan nilai "Month" ke dalam array headings
        $allMonths = collect($this->data)->flatMap(function ($item) {
            return collect($item['top'])->pluck('month');
        })->unique()->all();

        $headings = array_merge($headings, $allMonths);

        // Memproses data agar sesuai dengan format yang diinginkan
        $formattedData = collect($this->data)->map(function ($item) use ($headings, $allMonths) {
            $customer = $item['customer'];
            $countProject = $item['countProject'];
            $top = $item['top'];

            // Menyiapkan array untuk values, dimulai dengan heading yang sudah ditentukan
            $values = [$customer, $countProject];

            // Menambahkan nilai "month" dan "totalValue" ke dalam array
            $monthTotalValues = collect($top)->pluck('totalValue', 'month')->all();

            foreach ($allMonths as $month) {
                // Jika heading adalah "month", tambahkan totalValue atau 0 jika tidak ada
                $values[] = $monthTotalValues[$month] ?? 0;
            }

            return $values;
        });

        return $formattedData;
    }

    public function headings(): array
    {
        // Menyiapkan array untuk heading
        $headings = ['Customer', 'Jumlah Project'];

        // Menambahkan nilai "Month" ke dalam array headings
        $allMonths = collect($this->data)->flatMap(function ($item) {
            return collect($item['top'])->pluck('month');
        })->unique()->all();

        $headings = array_merge($headings, $allMonths);

        return $headings;
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
