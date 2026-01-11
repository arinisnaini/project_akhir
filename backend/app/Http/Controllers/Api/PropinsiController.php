<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\models\Propinsi;
use App\Http\Controllers\Controller;

class PropinsiController extends Controller
{
    
     /** 
     * Display a listing of the resource. 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function index()
    {
        $propinsi = Propinsi::all(); 
        return response()->json($propinsi, 200);
    }
    /** 
     * Show the form for creating a new resource. 
     *
     * @return \Illuminate\Http\Response 
     */ 
    public function create() 
    { 
        return view('propinsi.create'); 
    } 
 
    /** 
     * Store a newly created resource in storage. 
     * 
     * @param  \Illuminate\Http\Request  $request 
     * @return \Illuminate\Http\Response 
     */ 
    public function store(Request $request) 
    { 
        //$this->validate($request, [ 
        $request->validate([
            'nama_propinsi' => 'required', 
             
        ]); 
 
        $propinsi = Propinsi::create($request->all()); 
 
        return redirect()->route('propinsi.index') 
        ->with('message',  
                        'Propinsi baru berhasil ditambahkan!'); 
    } 
      /** 
     * Show the form for editing the specified resource. 
     * 
     * @param  int  $id 
     * @return \Illuminate\Http\Response 
     */ 
    public function edit($id) 
    { 
      $propinsi = Propinsi::findOrFail($id); 
      return view('propinsi.edit', compact('propinsi')); 
    } 
 
    /** 
     * Update the specified resource in storage. 
     * 
     * @param  \Illuminate\Http\Request  $request 
     * @param  int  $id 
     * @return \Illuminate\Http\Response 
     */ 
    public function update(Request $request, $id) 
    { 
       $this->validate($request, [ 
            'propinsi' => 'required', 
             
        ]); 
 
       $propinsi = Propinsi::findOrFail($id) 
                 ->update($request->all()); 
     
 
        return redirect()->route('propinsi.index') 
        ->with('message', 'Propinsi baru berhasil diubah!'); 
    } 
    public function show($id) 
    { 
       $propinsi = Propinsi::findOrFail($id); 
        return view('propinsi.show', compact('propinsi')); 
    }
}