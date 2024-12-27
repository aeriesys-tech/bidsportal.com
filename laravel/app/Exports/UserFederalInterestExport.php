<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class UserFederalInterestExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    protected $federalInterests;

    public function __construct($federalInterests)
    {
        $this->federalInterests = $federalInterests;
    }

    public function collection()
    {
        return $this->federalInterests->map(function ($federalInterest, $index) 
        {
            $user = $federalInterest->User;
            $userSetAsides = $user ? $user->UserSetAsides->pluck('SetAside.set_aside_name') : [];
    
            $formattedSetAsides = $userSetAsides->map(function ($setAside, $index) {
                return ($index + 1) . '. ' . $setAside;
            })->join("\n");
    
            return [
                'Sl No' => $index + 1,
                'company' => $user->company_name ?? '',
                'user' => $user->name ?? '',
                'position' => $user->position ?? '',
                'phone' => $user->phone ?? '',
                'email' => $user->email ?? '',
                'socioeconomic' => $formattedSetAsides,
            ];
        });
    }
    

    public function headings(): array
    {
        return [
            'Sl No',
            'Company',
            'User',
            'Position',
            'Phone',
            'Email',
            'Socioeconomic',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 7,
            'B' => 25,
            'C' => 20,
            'D' => 20,
            'E' => 16,
            'F' => 30,
            'G' => 200
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:G1')->getFill()->getStartColor()->setARGB('0000FF');
    
        $sheet->getStyle('G2:G' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
    }    
}

