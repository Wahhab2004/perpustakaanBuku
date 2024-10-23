<h2>Hasil Pencarian</h2>

@if($books->isEmpty())
    <p>Tidak ada item yang cocok dengan pencarian "{{ $request('keyword') }}".</p>
@else

    <p>Seluruh pencarian untuk: {{ $keyword }}</p>
    <ul>
        @foreach($books as $book)
            <li>{{ $book->judul }} - {{ $book->penulis }}</li>
        @endforeach
    </ul>

    <a href="/buku" class="btn btn-warning">Kembali</a>
@endif
