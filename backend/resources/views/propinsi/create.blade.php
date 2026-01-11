@extends('layouts.app') 
 
@section('content') 
<h4>Propinsi Baru</h4> 
<form action="{{ route('propinsi.store') }}" method="post"> 
    {{csrf_field()}} 
    <div class="form-group {{ $errors->has('propinsi') ?  
        'has-error' : '' }}"> 
        <label for="propinsi" class="control-label">Propinsi</label> 
        <input type="text" class="form-control" name="nama_propinsi"  
             placeholder="Propinsi"> 
        @if ($errors->has('propinsi')) 
            <span class="help-block">{{ $errors->first('propinsi') }} 
            </span> 
        @endif 
    </div> 
    <div class="form-group">
     <button type="submit" class="btn btn-info">Simpan</button> 
     <a href="{{ route('propinsi.index') }}"  
           class="btn btn-default">Kembali</a> 
    </div> 
</form> 
@endsection     