<?php

namespace App\Exports;

use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiExport
{
    public static function rows(array $filters = []): array
    {
        $request = new Request($filters);

        return Absensi::with(['siswa.kelas', 'sesi.ekstrakurikuler'])
            ->when($request->tanggal, fn ($q) => $q->whereHas('sesi', fn ($s) => $s->whereDate('tanggal', $request->tanggal)))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    optional($item->sesi)->tanggal,
                    optional($item->siswa)->nama,
                    optional(optional($item->siswa)->kelas)->nama_kelas,
                    optional(optional($item->sesi)->ekstrakurikuler)->nama,
                    $item->waktu_masuk ? $item->waktu_masuk->format('H:i:s') : '-',
                    $item->waktu_keluar ? $item->waktu_keluar->format('H:i:s') : '-',
                    $item->status,
                ];
            })
            ->toArray();
    }
}
