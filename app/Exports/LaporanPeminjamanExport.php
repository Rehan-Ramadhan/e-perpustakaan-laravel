<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class LaporanPeminjamanExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    use Exportable;

    protected $dateFrom;
    protected $dateTo;

    public function __construct(string $dateFrom, string $dateTo)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function query()
    {
        return Peminjaman::query()
            ->with(['user', 'pengembalian'])
            ->whereDate('tanggal_pinjam', '>=', $this->dateFrom)
            ->whereDate('tanggal_pinjam', '<=', $this->dateTo)
            ->orderBy('tanggal_pinjam', 'asc');
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Nama Peminjam',
            'Tanggal Pinjam',
            'Batas Kembali',
            'Total Denda (Rp)',
            'Status'
        ];
    }

    public function map($peminjaman): array
    {
        return [
            $peminjaman->nomor_peminjaman,
            $peminjaman->user->nama ?? '-',
            Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y'),
            Carbon::parse($peminjaman->tgl_harus_kembali)->format('d/m/Y'),
            $peminjaman->pengembalian->denda ?? 0,
            ucfirst($peminjaman->status),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}