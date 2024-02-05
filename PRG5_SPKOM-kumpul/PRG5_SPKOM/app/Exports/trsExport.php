<?php

namespace App\Exports;

use App\Models\trs_performance;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class trsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $filterType;
    protected $filterValue;

    // Konstruktor untuk menerima tipe filter dan nilai filter sebagai parameter
    public function __construct($filterType, $filterValue)
    {
        $this->filterType = $filterType;
        $this->filterValue = $filterValue;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return trs_performance::select(
            'fk_nomor_induk_dinilai',
            'tanggal',
            'total_integritas',
            'total_handal',
            'total_tangguh',
            'total_kolaborasi',
            'total_inovasi',
            'fk_nomor_induk_penilai',
        )
        ->with(['penilai' => function ($query) {
            $query->select('nomor_induk', 'nama_lengkap');
        }])
        ->with(['dinilai' => function ($query) {
            $query->select('nomor_induk', 'nama_lengkap');
        }])
        ->where($this->filterType, $this->filterValue)
        ->get()
        ->map(function ($item) {
            // Menambahkan kolom 'nama_lengkap_dinilai' setelah 'fk_nomor_induk_dinilai'
            return [
                'fk_nomor_induk_dinilai' => $item->fk_nomor_induk_dinilai,
                'nama_lengkap_dinilai' => $item->dinilai->nama_lengkap,
                'tanggal' => $item->tanggal,
                'total_integritas' => $item->total_integritas,
                'total_handal' => $item->total_handal,
                'total_tangguh' => $item->total_tangguh,
                'total_kolaborasi' => $item->total_kolaborasi,
                'total_inovasi' => $item->total_inovasi,
                'fk_nomor_induk_penilai' => $item->fk_nomor_induk_penilai,
            ];
        });
    }


    public function headings(): array
    {
        return [
            "Nomor Induk Dinilai",
            "Nama Lengkap",
            "Tanggal Menilai",
            "Integritas",
            "Handal",
            "Tangguh",
            "Kolaborasi",
            "Inovasi",
            "Nomor Induk Penilai",
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Contoh pengaturan warna latar belakang dan warna teks pada header
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFF00'],
            ],
        ]);

        // Contoh pengaturan warna latar belakang pada sel data
        $sheet->getStyle('A2:I' . ($sheet->getHighestRow()))->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'CCFFCC'],
            ],
        ]);
    }
}
