<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tabel</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>

    @if(Session::has('success'))
        <div class="alert alert-success">{{Session::get('success') }}</div>

    @elseif(Session::has('success2'))
        <div class="alert alert-info">{{ Session::get('success2') }}</div>

    @elseif(Session::has('deleted'))
        <div class="alert alert-danger">{{ Session::get('deleted') }}</div>

    @endif


    <form action="{{ route('buku.search') }}" method="GET">
   
        <input type="text" name="keyword" class="form-control" placeholder="Cari..." style="width: 30%; display:inline; margin-top:10px 0; float:right;">
        <button type="submit" class="btn btn-dark" style="float: right">Cari</button>
    </form>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Harga</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        @yield('content')

        <tbody>
            
            @foreach ($data_buku as $index => $buku)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><a class="decor" href="{{ route('buku.show', $buku->id) }}">{{ $buku->judul }}</a></td>
                <td>{{ $buku->penulis }}</td>
                <td>{{ "Rp. ".number_format($buku->harga, 2, ',', '.') }}</td>
                <td>
                    <!-- Tombol Edit -->
                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning">Edit</a>
                </td>
                
                <td>
                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin mau dihapus?')" type="submit" class="btn btn-danger">DELETE</button>
                    </form>
                </td>
            </tr>
            @endforeach
            <tr style="text-align: center">
                <th colspan="2">Total Buku</th>
                <th colspan="2" style="background-color: rgb(74, 74, 74); color:white;">{{ $total_buku }}</th>
            </tr>
            <tr style="text-align:center">
                <th colspan="2">Total Harga</th>
                <th colspan="2" style="background-color: goldenrod; color:white;">{{ "Rp. ".number_format($total_harga, 2, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>

    <div>{{ $data_buku->links() }}</div>


    <!-- Form Tambah Buku -->
    <div class="container mt-5">

        @if(count($errors) > 0 )
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <h2>Tambah Buku</h2>
        <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
            @csrf
            <div class="col-md-6">
                <label for="judul" class="form-label">Judul Buku:</label>
                <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" required>
                @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="penulis" class="form-label">Penulis:</label>
                <input type="text" name="penulis" id="penulis" class="form-control @error('penulis') is-invalid @enderror" value="{{ old('penulis') }}" required>
                @error('penulis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="tgl_terbit" class="form-label">Tanggal Terbit:</label>
                <input type="date" name="tgl_terbit" id="tgl_terbit" class="form-control @error('tgl_terbit') is-invalid @enderror" value="{{ old('tgl_terbit') }}" required>
                @error('tgl_terbit')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="harga" class="form-label">Harga:</label>
                <input type="number" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}" required>
                @error('harga')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="gambar" class="form-label">Gambar Buku:</label>
                <input type="file" name="gambar" id="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*" required>
                @error('gambar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Tambahkan Buku</button>
            </div>
        </form>
    </div>



</body>
</html>
