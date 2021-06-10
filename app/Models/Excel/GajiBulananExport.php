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

class GajiBulananExport implements FromCollection, WithMapping, WithStyles,WithHeadings, ShouldAutoSize
{
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
            "Angsuran Kantor",
            "Potongan Absen",
        ];
    }
    public function map($data): array
    {
        return [
            $data['no'],
            $data['nik_karyawan'],
            $data['nama_lengkap'],
            $data['upah_pokok'],
            $data['tunjangan_makan'],
            $data['tunjangan_stkr'],
            $data['tunjangan_prh'],
            $data['bonus_masuk'],
            $data['upah_lembur'],
            $data['bpjs_kesehatan'],
            $data['bpjs_tenagakerja'],
            $data['bpjs_orangtua'],
            $data['iuran_wajib'],
            $data['angsuran_koperasi'],
            $data['angsuran_kantor'],
            $data['potongan_absen']
        ];
    }

    public function collection()
    {
        return $this->col;
    }
}
