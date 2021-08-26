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
        $totalRow = $numOfRows + 4;

        $sheet->insertNewRowBefore(1);
        $sheet->insertNewRowBefore(2);

        $sheet->setCellValue("A1", "Gaji Mingguan Periode " . $this->col[0]['periode'])->mergeCells('A1:G1');
        $sheet->setCellValue("A2", "Periode : " . $this->col[0]['periode'])->mergeCells('A2:E2');

        $sheet->getStyle("A{$totalRow}:Q{$totalRow}")->getFont()->setBold(true);
        $sheet->setCellValue("C{$totalRow}", "TOTAL");

        return [
            1 => ['font' => ['bold' => true]],
            2 => ['font' => ['bold' => true]],
            3 => [
                    [
                        $sheet->setCellValue("D{$totalRow}", "=SUM(D4:D{$totalRow})"),
                        $sheet->setCellValue("D{$totalRow}", $sheet->getCell("D{$totalRow}")->getCalculatedValue()),
                        $sheet->getStyle("D4:D{$totalRow}")->getNumberFormat()->setFormatCode('#,##0')
                    ],
                    [
                        $sheet->setCellValue("E{$totalRow}", "=SUM(E4:E{$totalRow})"),
                        $sheet->setCellValue("E{$totalRow}", $sheet->getCell("E{$totalRow}")->getCalculatedValue()),
                        $sheet->getStyle("E4:E{$totalRow}")->getNumberFormat()->setFormatCode('#,##0')
                    ],
                    [
                        $sheet->setCellValue("F{$totalRow}", "=SUM(F4:F{$totalRow})"),
                        $sheet->setCellValue("F{$totalRow}", $sheet->getCell("F{$totalRow}")->getCalculatedValue()),
                        $sheet->getStyle("F4:F{$totalRow}")->getNumberFormat()->setFormatCode('#,##0')
                    ],
                    [
                        $sheet->setCellValue("G{$totalRow}", "=SUM(G4:G{$totalRow})"),
                        $sheet->setCellValue("G{$totalRow}", $sheet->getCell("G{$totalRow}")->getCalculatedValue()),
                        $sheet->getStyle("G4:G{$totalRow}")->getNumberFormat()->setFormatCode('#,##0')
                    ],
                    [
                        $sheet->setCellValue("H{$totalRow}", "=SUM(H4:H{$totalRow})"),
                        $sheet->setCellValue("H{$totalRow}", $sheet->getCell("H{$totalRow}")->getCalculatedValue()),
                        $sheet->getStyle("H4:H{$totalRow}")->getNumberFormat()->setFormatCode('#,##0')
                    ],
                    [
                        $sheet->setCellValue("I{$totalRow}", "=SUM(I4:I{$totalRow})"),
                        $sheet->setCellValue("I{$totalRow}", $sheet->getCell("I{$totalRow}")->getCalculatedValue()),
                        $sheet->getStyle("I4:I{$totalRow}")->getNumberFormat()->setFormatCode('#,##0')
                    ],
                    [
                        $sheet->setCellValue("J{$totalRow}", "=SUM(J4:J{$totalRow})"),
                        $sheet->setCellValue("J{$totalRow}", $sheet->getCell("J{$totalRow}")->getCalculatedValue()),
                        $sheet->getStyle("J4:J{$totalRow}")->getNumberFormat()->setFormatCode('#,##0')
                    ],
                    [
                        $sheet->setCellValue("K{$totalRow}", "=SUM(K4:K{$totalRow})"),
                        $sheet->setCellValue("K{$totalRow}", $sheet->getCell("K{$totalRow}")->getCalculatedValue()),
                        $sheet->getStyle("K4:K{$totalRow}")->getNumberFormat()->setFormatCode('#,##0')
                    ],
                    [
                        $sheet->setCellValue("L{$totalRow}", "=SUM(L4:L{$totalRow})"),
                        $sheet->setCellValue("L{$totalRow}", $sheet->getCell("L{$totalRow}")->getCalculatedValue()),
                        $sheet->getStyle("L4:L{$totalRow}")->getNumberFormat()->setFormatCode('#,##0')
                    ],
                    [
                        $sheet->setCellValue("M{$totalRow}", "=SUM(M4:M{$totalRow})"),
                        $sheet->setCellValue("M{$totalRow}", $sheet->getCell("M{$totalRow}")->getCalculatedValue()),
                        $sheet->getStyle("M4:M{$totalRow}")->getNumberFormat()->setFormatCode('#,##0')
                    ],
                    [
                        $sheet->setCellValue("N{$totalRow}", "=SUM(N4:N{$totalRow})"),
                        $sheet->setCellValue("N{$totalRow}", $sheet->getCell("N{$totalRow}")->getCalculatedValue()),
                        $sheet->getStyle("N4:N{$totalRow}")->getNumberFormat()->setFormatCode('#,##0')
                    ],
                    [
                        $sheet->setCellValue("O{$totalRow}", "=SUM(O4:O{$totalRow})"),
                        $sheet->setCellValue("O{$totalRow}", $sheet->getCell("O{$totalRow}")->getCalculatedValue()),
                        $sheet->getStyle("O4:O{$totalRow}")->getNumberFormat()->setFormatCode('#,##0')
                    ],
                    [
                        $sheet->setCellValue("P{$totalRow}", "=SUM(P4:P{$totalRow})"),
                        $sheet->setCellValue("P{$totalRow}", $sheet->getCell("P{$totalRow}")->getCalculatedValue()),
                        $sheet->getStyle("P4:P{$totalRow}")->getNumberFormat()->setFormatCode('#,##0')
                    ],
                    [
                        $sheet->setCellValue("Q{$totalRow}", "=SUM(Q4:Q{$totalRow})"),
                        $sheet->setCellValue("Q{$totalRow}", $sheet->getCell("Q{$totalRow}")->getCalculatedValue()),
                        $sheet->getStyle("Q4:Q{$totalRow}")->getNumberFormat()->setFormatCode('#,##0')
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
            "Sisa Gaji",
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
            $datamingguan['total_gaji'] - $datamingguan['total_potongan'],
        ];
    }

    public function collection()
    {
        return $this->col;
    }
}
