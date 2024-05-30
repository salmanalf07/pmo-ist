<?php

namespace App\Exports;

use App\Models\topProject;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Events\AfterSheet;

class allProjectByDate implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return new Collection($this->data);
    }



    public function headings(): array
    {
        return [
            'noProject' => 'Project Id',
            'customer' => 'Customer',
            'saless' => 'Sales',
            'projectName' => 'Project Name',
            'noContract' => 'SPK',
            'contractStart' => 'Contract Start',
            'contractEnd' => 'Contract End',
            'sponsors' => 'Sponsor',
            'overAllProg' => 'Progress',

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
