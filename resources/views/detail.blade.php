<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Buku</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
   
    <div class="contain-center">
        <div class="contain-1">
            <h2>Detail Buku</h2>
            <p>{{ $idBuku->id }}</p>
        </div>
        
        <div class="contain-2">
            <div class="contain-left">
                <img src="{{ asset('image/'.$idBuku->gambar) }}" alt="Gambar Buku" style="width: 200px; height:300px;">
            </div>
            <div class="contain-right">
                <p><strong>Judul Buku:</strong> {{ $idBuku->judul }}</p>
                <p class="top"><strong>Penulis:</strong> {{ $idBuku->penulis }}</p>
                <p class="top"><strong>Tanggal Terbit:</strong> {{ $formattedDate }}</p>
                <div class="box-harga">
                    <p><strong>Harga:</strong> {{ 'Rp'.number_format($idBuku->harga) }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>