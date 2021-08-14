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

class GajiMingguanExport implements FromCollection, WithMapping, WithStyles, WithHeadings, ShouldAutoSize
{
    public function __construct(Collection $col) {
        $this->col = $col;
    }

    public function styles(Worksheet $sheet)
    {
        $numOfRows = count($this->col);
        $totalRow = $numOfRows + 2;

        // $sheet->setCellValue("D{$totalRow}", '=SUM(D2:D9)');
        // $sheet->setCellValue('D11', '=SUM(D2:D9)');
        // $retVal = $sheet->getCell('D11')->getCalculatedValue();
        // dd($retVal);

        // $sheet->setCellValue("E{$totalRow}", "=SUM(E2:E{$numOfRows})"),
        // $sheet->setCellValue("F{$totalRow}", "=SUM(F2:F{$numOfRows})"),
        // $sheet->setCellValue("G{$totalRow}", "=SUM(G2:G{$numOfRows})"),
        // $sheet->setCellValue("H{$totalRow}", "=SUM(H2:H{$numOfRows})"),
        // $sheet->setCellValue("I{$totalRow}", "=SUM(I2:I{$numOfRows})"),
        // $sheet->setCellValue("J{$totalRow}", "=SUM(J2:J{$numOfRows})"),
        // $sheet->setCellValue("K{$totalRow}", "=SUM(K2:K{$numOfRows})"),
        // $sheet->setCellValue("L{$totalRow}", "=SUM(L2:L{$numOfRows})"),
        // $sheet->setCellValue("M{$totalRow}", "=SUM(M2:M{$numOfRows})"),
        // $sheet->setCellValue("N{$totalRow}", "=SUM(N2:N{$numOfRows})"),
        // $sheet->setCellValue("O{$totalRow}", "=SUM(O2:O{$numOfRows})")

        $sheet->getStyle("A{$totalRow}:O{$totalRow}")->getFont()->setBold(true);
        $sheet->setCellValue("C{$totalRow}", "TOTAL");

        return [
            1 => ['font' => ['bold' => true]],
            2 => [
                    [
                        $sheet->setCellValue("D{$totalRow}", "=SUM(D2:D{$numOfRows})"),
                        $sheet->setCellValue("D{$totalRow}", $sheet->getCell("D{$totalRow}")->getCalculatedValue())
                    ],
                    [
                        $sheet->setCellValue("E{$totalRow}", "=SUM(E2:E{$numOfRows})"),
                        $sheet->setCellValue("E{$totalRow}", $sheet->getCell("E{$totalRow}")->getCalculatedValue())
                    ],
                    [
                        $sheet->setCellValue("F{$totalRow}", "=SUM(F2:F{$numOfRows})"),
                        $sheet->setCellValue("F{$totalRow}", $sheet->getCell("F{$totalRow}")->getCalculatedValue())
                    ],
                    [
                        $sheet->setCellValue("G{$totalRow}", "=SUM(G2:G{$numOfRows})"),
                        $sheet->setCellValue("G{$totalRow}", $sheet->getCell("G{$totalRow}")->getCalculatedValue())
                    ],
                    [
                        $sheet->setCellValue("H{$totalRow}", "=SUM(H2:H{$numOfRows})"),
                        $sheet->setCellValue("H{$totalRow}", $sheet->getCell("H{$totalRow}")->getCalculatedValue())
                    ],
                    [
                        $sheet->setCellValue("I{$totalRow}", "=SUM(I2:I{$numOfRows})"),
                        $sheet->setCellValue("I{$totalRow}", $sheet->getCell("I{$totalRow}")->getCalculatedValue())
                    ],
                    [
                        $sheet->setCellValue("J{$totalRow}", "=SUM(J2:J{$numOfRows})"),
                        $sheet->setCellValue("J{$totalRow}", $sheet->getCell("J{$totalRow}")->getCalculatedValue())
                    ],
                    [
                        $sheet->setCellValue("K{$totalRow}", "=SUM(K2:K{$numOfRows})"),
                        $sheet->setCellValue("K{$totalRow}", $sheet->getCell("K{$totalRow}")->getCalculatedValue())
                    ],
                    [
                        $sheet->setCellValue("L{$totalRow}", "=SUM(L2:L{$numOfRows})"),
                        $sheet->setCellValue("L{$totalRow}", $sheet->getCell("L{$totalRow}")->getCalculatedValue())
                    ],
                    [
                        $sheet->setCellValue("M{$totalRow}", "=SUM(M2:M{$numOfRows})"),
                        $sheet->setCellValue("M{$totalRow}", $sheet->getCell("M{$totalRow}")->getCalculatedValue())
                    ],
                    [
                        $sheet->setCellValue("N{$totalRow}", "=SUM(N2:N{$numOfRows})"),
                        $sheet->setCellValue("N{$totalRow}", $sheet->getCell("N{$totalRow}")->getCalculatedValue())
                    ],
                    [
                        $sheet->setCellValue("O{$totalRow}", "=SUM(O2:O{$numOfRows})"),
                        $sheet->setCellValue("O{$totalRow}", $sheet->getCell("O{$totalRow}")->getCalculatedValue())
                    ],
                ],
        ];
    }

    public function headings(): array
    {
        return [
            "No",
            "NIK",
            "Nama",
            "Uph Pokok",
            "Tunj. Makan",
            "Tunj. Stkr",
            "Tunj. Prh",
            "Bonus Masuk",
            "Upah Lembur",
            "BPJS Kes",
            "BPJS Ket",
            "BPJS Ortu",
            "Iuran Wjb",
            "Ang. Kop",
            "Ang. Kntr",
            "T. Gaji",
            "T. Ptngn",
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
            $datamingguan['angsuran_kantor'],
            $datamingguan['total_gaji'],
            $datamingguan['total_potongan'],
        ];
    }

    public function collection()
    {
        return $this->col;
    }
}
