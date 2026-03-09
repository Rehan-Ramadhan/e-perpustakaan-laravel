<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

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

    /**
     * Query data peminjaman berdasarkan filter tanggal
     */
    public function query()
    {
        return Peminjaman::query()
            ->with(['pengguna', 'pengembalian'])
            ->whereDate('tgl_pinjam', '>=', $this->dateFrom)
            ->whereDate('tgl_pinjam', '<=', $this->dateTo)
            ->orderBy('tgl_pinjam', 'asc');
    }

    /**
     * Header tabel di Excel
     */
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

    /**
     * Mapping data ke kolom Excel
     */
    public function map($peminjaman): array
    {
        return [
            $peminjaman->kode_transaksi,
            $peminjaman->pengguna->nama,
            \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d/m/Y'),
            \Carbon\Carbon::parse($peminjaman->tgl_harus_kembali)->format('d/m/Y'),
            $peminjaman->pengembalian->denda ?? 0,
            ucfirst($peminjaman->status),
        ];
    }

    /**
     * Styling: Membuat baris pertama (Header) menjadi BOLD
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}