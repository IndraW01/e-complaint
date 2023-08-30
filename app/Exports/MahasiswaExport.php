<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MahasiswaExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{
    private $filterData;

    public function __construct(array $filterData)
    {
        $this->filterData = $filterData;
    }

    public function registerEvents(): array
    {
        $countData = Mahasiswa::query()->withWhereHas('jurusan', function ($query) {
            $query->where('id', $this->filterData['jurusan']);
        })->when($this->filterData['angkatan'], function ($query) {
            $query->where('angkatan', $this->filterData['angkatan']);
        })->get()->count() + 1;

        return [
            AfterSheet::class => function (AfterSheet $event) use ($countData) {
                $event->sheet->getStyle("A1:D$countData")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],

                ]);
                $event->sheet->getStyle("A1:D1")->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFA0A0A0',
                        ],
                        'endColor' => [
                            'argb' => 'FFFFFFFF',
                        ],
                    ],
                ]);
            },
        ];
    }

    public function query()
    {
        return Mahasiswa::query()->withWhereHas('jurusan', function ($query) {
            $query->where('id', $this->filterData['jurusan']);
        })->when($this->filterData['angkatan'], function ($query) {
            $query->where('angkatan', $this->filterData['angkatan']);
        });
    }

    public function map($mahasiswa): array
    {
        return [
            $mahasiswa->name,
            $mahasiswa->nim,
            $mahasiswa->Jurusan->name,
            $mahasiswa->angkatan
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Nim',
            'User',
            'Nim'
        ];
    }
}
