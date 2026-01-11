@extends('layouts.app')
@section('content')
<h4>Menajemen Tabel Kota</h4>

<a href="{{ route('kota.create') }}"
   class="btn btn-info btn-sm">Kota Baru</a>

@if (Session::get('message'))
<div class="alert alert-success martop-sm">
    <p>{{ Session::get('message') }}</p>
</div>
@endif

<table class="table table-responsive martop-sm">
    <thead>
        <th>ID</th>
        <th>Propinsi</th>
        <th>Nama Kota</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach ($kota as $k)
        <tr>
            <td>{{ $k->id }}</td>
            
            <td>
                {{ $k->propinsi->nama_propinsi ?? 'N/A' }} 
            </td>
            
            <td>
                <a href="{{ route('kota.show', $k->id) }}">
                    {{ $k->nama_kota }}
                </a>
            </td>

            <td>
                <form action="{{ route('kota.destroy', $k->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    
                    <a href="{{ route('kota.edit', $k->id) }}"
                       class="btn btn-warning btn-sm">Ubah</a>
                       
                    <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus kota: {{ $k->nama_kota }}?')">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $kota->links('pagination::bootstrap-5') }}

@endsection