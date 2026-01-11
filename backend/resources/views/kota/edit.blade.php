@extends('layouts.app')
@section('content')
<div class="container">
    <h4>Ubah Kota: {{ $kota->nama_kota }}</h4>

    <form action="{{ route('kota.update', $kota->id) }}" method="POST">
        @csrf
        @method('PUT') <div class="form-group {{ $errors->has('propinsi_id') ? 'has-error': '' }}">
            <label for="propinsi_id" class="control-label">Propinsi</label>
            <select class="form-control" name="propinsi_id" id="propinsi_id">
                <option value="">-- Pilih Propinsi --</option>
                
                @foreach($propinsi as $id => $nama)
                    <option value="{{ $id }}" 
                        
                        {{ 
                            old('propinsi_id', $kota->propinsi_id) == $id ? 'selected' : '' 
                        }}>
                        
                        {{ $nama }}
                    </option>
                @endforeach
            </select>

            @if ($errors->has('propinsi_id'))
                <span class="help-block">{{ $errors->first('propinsi_id') }}</span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('nama_kota') ? 'has-error': '' }}">
            <label for="nama_kota" class="control-label">Nama Kota</label>
            <input type="text" class="form-control" name="nama_kota"
                placeholder="Nama Kota" 
                
                value="{{ old('nama_kota', $kota->nama_kota) }}">

            @if ($errors->has('nama_kota'))
                <span class="help-block">{{ $errors->first('nama_kota') }}</span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-info">Simpan</button>
            <a href="{{ route('kota.index') }}" class="btn btn-default">Kembali</a>
        </div>
    </form>
</div>
@endsection