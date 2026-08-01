<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $items = $this->query($request)->paginate(20)->withQueryString();

        return view('laporan.index', compact('items'));
    }

    private function query(Request $request)
    {
        return Absensi::with(['siswa.kelas', 'sesi.ekstrakurikuler'])
            ->when($request->tanggal, fn ($q) => $q->whereHas('sesi', fn ($s) => $s->whereDate('tanggal', $request->tanggal)))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest();
    }

    public function excel(Request $request)
    {
        $items = $this->query($request)->get();
        $filename = 'laporan-absensi.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return Response::stream(function () use ($items) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($handle, ['Tanggal', 'Siswa', 'Kelas', 'Ekstrakurikuler', 'Masuk', 'Keluar', 'Status']);

            foreach ($items as $item) {
                fputcsv($handle, [
                    optional($item->sesi)->tanggal,
                    optional($item->siswa)->nama,
                    optional(optional($item->siswa)->kelas)->nama_kelas,
                    optional(optional($item->sesi)->ekstrakurikuler)->nama,
                    $item->waktu_masuk ? $item->waktu_masuk->format('H:i:s') : '-',
                    $item->waktu_keluar ? $item->waktu_keluar->format('H:i:s') : '-',
                    $item->status,
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function pdf(Request $request)
    {
        $items = $this->query($request)->get();

        return Pdf::loadView('laporan.pdf', compact('items'))->download('laporan-absensi.pdf');
    }
}
