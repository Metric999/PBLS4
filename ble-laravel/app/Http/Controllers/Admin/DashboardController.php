<?php
// ══════════════════════════════════════════════════════════════════════
// app/Http/Controllers/Admin/DashboardController.php
// ══════════════════════════════════════════════════════════════════════
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Absensi;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalMahasiswa' => Mahasiswa::count(),
            'totalDosen'     => Dosen::count(),
            'totalJadwal'    => Jadwal::count(),
            'totalAbsensiHariIni' => Absensi::whereDate('tanggal', today())->count(),
        ]);
    }
}