<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $dosens = Dosen::query()
            ->when($request->search, fn($q) =>
                $q->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('nidn', 'like', "%{$request->search}%"))
            ->orderBy('nama')
            ->paginate(20)
            ->withQueryString();
        return view('admin.dosen.index', compact('dosens'));
    }

    public function create()
    {
        return view('admin.dosen.create');
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'nidn'     => 'required|string|max:20|unique:dosens,nidn',
            'nama'     => 'required|string|max:100',
            'username' => 'required|string|unique:dosens,username',
            'password' => 'nullable|string|min:6',
        ]);
        Dosen::create([...$v, 'password' => Hash::make($v['password'] ?? $v['nidn'])]);
        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil ditambahkan.');
    }

    public function edit(Dosen $dosen)
    {
        return view('admin.dosen.edit', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen)
    {
        $v = $request->validate([
            'nama'     => 'required|string|max:100',
            'username' => "required|string|unique:dosens,username,{$dosen->nidn},nidn",
            'password' => 'nullable|string|min:6',
        ]);
        $update = collect($v)->except('password')->toArray();
        if (! empty($v['password'])) $update['password'] = Hash::make($v['password']);
        $dosen->update($update);
        return redirect()->route('admin.dosen.index')->with('success', 'Data dosen diperbarui.');
    }

    public function destroy(Dosen $dosen)
    {
        $dosen->delete();
        return back()->with('success', 'Dosen dihapus.');
    }
}