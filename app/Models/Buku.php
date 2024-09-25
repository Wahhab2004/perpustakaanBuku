<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{


    use HasFactory;
    protected $table = 'books';

    use HasFactory;

    // Izinkan mass assignment untuk atribut-atribut ini
    protected $fillable = [
        'judul', 
        'penulis', 
        'tgl_terbit', 
        'harga', 
        'gambar'
    ];


    
}