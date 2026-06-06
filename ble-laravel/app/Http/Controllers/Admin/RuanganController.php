<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = Ruangan::orderBy('id_ruangan')->paginate(20);
        return view('admin.ruangan.index', compact('ruangans'));
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'id_ruangan'  => 'required|string|max:20|unique:ruangans',
            'nama_ruangan'=> 'required|string|max:100',
            'beacon_uuid' => 'required|string|unique:ruangans,beacon_uuid',
            'beacon_name' => 'nullable|string|max:50',
        ]);
        Ruangan::create($v);
        return back()->with('success', 'Ruangan ditambahkan.');
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $v = $request->validate([
            'nama_ruangan'=> 'required|string|max:100',
            'beacon_uuid' => "required|string|unique:ruangans,beacon_uuid,{$ruangan->id_ruangan},id_ruangan",
            'beacon_name' => 'nullable|string|max:50',
        ]);
        $ruangan->update($v);
        return back()->with('success', 'Ruangan diperbarui.');
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();
        return back()->with('success', 'Ruangan dihapus.');
    }
}