<?php

namespace App\Models\Excel;

use App\Models\BaseModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GajiMingguanExport implements FromCollection, WithMapping, WithStyles,WithHeadings, ShouldAutoSize
{
    public Collection $col;

    public function __construct(Collection $col) {
        $this->col = $col;
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function headings(): array
    {
        return [
            "No",
            "NIK Karyawan",
            "Nama Lengkap",
            "Upah Pokok",
            "Tunjangan Makan",
            "Tunjangan Stkr",
            "Tunjangan Prh",
            "Bonus Masuk",
            "Upah Lembur",
            "BPJS Kesehatan",
            "BPJS Tenagakerja",
            "BPJS Orangtua",
            "Iuran Wajib",
            "Angsuran Koperasi",
            "Angsuran Kantor"
        ];
    }
    public function map($datamingguan): array
    {
        return [
            $datamingguan['no'],
            $datamingguan['nik_karyawan'],
            $datamingguan['nama_lengkap'],
            $datamingguan['upah_pokok'],
            $datamingguan['tunjangan_makan'],
            $datamingguan['tunjangan_stkr'],
            $datamingguan['tunjangan_prh'],
            $datamingguan['bonus_masuk'],
            $datamingguan['upah_lembur'],
            $datamingguan['bpjs_kesehatan'],
            $datamingguan['bpjs_tenagakerja'],
            $datamingguan['bpjs_orangtua'],
            $datamingguan['iuran_wajib'],
            $datamingguan['angsuran_koperasi'],
            $datamingguan['angsuran_kantor']
        ];
    }

    public function collection()
    {
        return $this->col;
    }
}
