<?php

namespace App\Exports;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class PengaduanExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{
    private $filterData;

    public function __construct(Request $filterData)
    {
        $this->filterData = $filterData;
    }

    public function registerEvents(): array
    {
        $countData = Pengaduan::query()->with(['Kategoris', 'Tiket' => ['Mahasiswa' => ['Jurusan']]])->latest()->search($this->filterData)->get()->count() + 1;

        return [
            AfterSheet::class => function (AfterSheet $event) use ($countData) {
                $event->sheet->getStyle("A1:G$countData")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],

                ]);
                $event->sheet->getStyle("A1:G1")->applyFromArray([
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
        return Pengaduan::query()->with(['Kategoris', 'Tiket' => ['Mahasiswa' => ['Jurusan']]])->latest()->search($this->filterData);
    }

    public function map($pengaduan): array
    {
        return [
            $pengaduan->Tiket->Mahasiswa->name,
            $pengaduan->Tiket->Mahasiswa->Jurusan->name,
            $pengaduan->title,
            $pengaduan->deskripsi,
            $pengaduan->Kategoris->pluck('name')->implode(', '),
            $pengaduan->status,
            $pengaduan->created_at
        ];
    }

    public function headings(): array
    {
        return [
            'Author',
            'Jurusan',
            'Title',
            'Deskripsi',
            'Kategori',
            'Status',
            'Pengaduan Create',
        ];
    }
}
