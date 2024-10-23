<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; 


class BukuController extends Controller
{
    public function index () {
        $batas = 5;
        $data_buku = Buku::orderBy('id', 'desc')->simplePaginate($batas);
        $total_buku = Buku::count();
        $total_harga = Buku::sum('harga');
        $no = $batas *($data_buku->currentPage()-1);
        return view('index', compact('data_buku', 'total_buku', 'total_harga', 'no'));
    }
    
    
    public function show($id) {
        $idBuku = Buku::findOrFail($id);
        $formattedDate = Carbon::parse($idBuku->tgl_terbit)->translatedFormat('d F Y');
        return view('detail', compact('idBuku', 'formattedDate'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string',
            'penulis' => 'required|string',
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


    // Menghapus data
    public function destroy($id) {
        $buku = Buku::findOrFail($id);
        $buku->delete();
        return redirect()->route('buku.index')->with('deleted', 'Buku berhasil dihapus');
    }   


    // Mengedit data
    public function edit($id){
        $buku = Buku::findOrFail($id);
        return view('edit', compact('buku'));}


    // Mengupdate data
    public function update(Request $request, $id) {
        $buku = Buku::findOrFail($id);
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Mengganti data lama dengan data baru
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

        $buku->save(); // perintah SQL
        return redirect()->route('buku.index')->with('success2', 'Buku berhasil diperbarui');}

    public function search(Request $request){
        $keyword = $request->input('keyword');
        $books = Buku::where('penulis', 'like', "%{$keyword}%")
                        ->orWhere('judul', 'like', "%{$keyword}%")
                        ->get();
        
        return view('search', compact('books', 'keyword'));}
        

}
