<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropinsiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    DB::table('propinsi')->insert([ 
     ['nama_propinsi' =>'DIY'], 
     ['nama_propinsi' =>'Jawa Tengah'],
     ['nama_propinsi' =>'Jawa Timur'],
     ['nama_propinsi' =>'Jawa Barat'],
     ['nama_propinsi' =>'DKI']

    ]);
}
}