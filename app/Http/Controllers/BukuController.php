<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; 


class BukuController extends Controller
{
    public function index () {
        $data_buku = Buku::all();
        $total_buku = Buku::count();
        $total_harga = Buku::sum('harga');
        return view('index', compact('data_buku', 'total_buku', 'total_harga'));
    }
    
    public function show($id) {
        $buku = Buku::findOrFail($id);
        $formattedDate = Carbon::parse($buku->tgl_terbit)->translatedFormat('d F Y');

        return view('detail', compact('buku', 'formattedDate'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'tgl_terbit' => 'required|date',
            'harga' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Simpan file gambar
        $gambar = $request->file('gambar');
        $namaGambar = time() . '_' . $gambar->getClientOriginalName();
        $gambar->move(public_path('image'), $namaGambar);

        // Tambah buku ke database
        Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'tgl_terbit' => $request->tgl_terbit,
            'harga' => $request->harga,
            'gambar' => $namaGambar
        ]);

        // Redirect ke halaman utama dengan flash message
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function destroy($id) {
        try {
            $buku = Buku::findOrFail($id);
            $buku->delete();
            return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('buku.index')->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
        }
    }

    public function edit($id)
{

    $buku = Buku::findOrFail($id);
    return view('edit', compact('buku'));
}

    public function update(Request $request, $id)
{
    $buku = Buku::findOrFail($id);
    $request->validate([
        'judul' => 'required|string|max:255',
        'penulis' => 'required|string|max:255',
        'harga' => 'required|numeric',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $buku->judul = $request->judul;
    $buku->penulis = $request->penulis;
    $buku->harga = $request->harga;

    // Cek apakah ada gambar baru
    if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($buku->gambar) {
            Storage::delete($buku->gambar);
        }
        $buku->gambar = $request->file('gambar')->store('images'); // Simpan gambar baru
    }

    $buku->save();

    return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
}


    
}
