<?php

namespace App\Exports;

use App\Models\topProject;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;

class allProjectExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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
            'noProject' => 'No Project',
            'customerType' => 'Type Customer',
            'customerName' => 'Customer',
            'projectName' => 'Project Name',
            'noContract' => 'No Contract/SPK/PO/SO',
            'contractDate' => 'Date contract/SPK/PO/SO',
            'po' => 'PO',
            'noPo' => 'No Main contract',
            'datePo' => 'Date Main contract',
            'dateStPo' => 'Contract Start',
            'dateEdPo' => 'Contract End',
            'poValue' => 'PO Value',
            'projectValue' => 'Project Value',
            'overAllProg' => 'Progress',
            'projectType' => 'Type Project',
            'partnerCompany' => 'Partner',
            'saless' => 'Sales',
            'pm' => 'Project Manager',
            'co_pm' => 'Co PM',
            'sponsors' => 'Sponsor',
            'contractStart' => ' Start Date Contract',
            'contractEnd' => 'End Date Contract',
            'termsName' => 'Terms Name',
            'termsValue' => 'Terms of Payment',
            'bastDate' => 'Plan/BAST Date',
            'invDate' => 'Invoice Date',
            'payDate' => 'Payment Date',
            'remaks' => 'Remaks',

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
