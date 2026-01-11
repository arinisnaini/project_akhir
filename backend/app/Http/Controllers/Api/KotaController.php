<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kota;
class KotaController extends Controller
{
public function index()
{
$kota = DB::table('kota')
->join('propinsi', 'kota.propinsi_id', '=', 'propinsi.id')
->select('kota.id', 'kota.nama_kota', 'kota.propinsi_id', 'propinsi.nama_propinsi')
->orderBy('propinsi.nama_propinsi')
->get();
return response()->json($kota);
}
 //tambah rekaman
public function store(Request $request)
{
$request->validate([
            'nama_kota' => 'required',
            'propinsi_id' => 'required|numeric'
        ]);

        try {
            $id = DB::table("kota")->insertGetId([
                'propinsi_id' => $request->propinsi_id,
                'nama_kota'   => $request->nama_kota,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Data kota berhasil disimpan',
                'data' => [
                    'id' => $id,
                    'nama_kota' => $request->nama_kota,
                    'propinsi_id' => $request->propinsi_id
                ]
            ], 200);
}
catch (\Illuminate\Database\QueryException $e) {
            // 3. Tangkap Error SQL dan kirim ke Frontend
            // Ini akan memberitahu Anda APA yang salah (misal: Column not found)
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan ke database',
                'error_detail' => $e->getMessage() 
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }
 //mengubah rekaman///
public function update(Request $request, $id)
{
    // Validasi
    $request->validate([
        'propinsi_id' => 'required|numeric',
        'nama_kota'   => 'required|string|max:100',
    ]);

    try {
        // Menggunakan Eloquent
        $kota = Kota::findOrFail($id); // Akan otomatis throw error jika ID tidak ada
        
        $kota->update([
            'propinsi_id' => $request->propinsi_id,
            'nama_kota'   => $request->nama_kota,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data kota berhasil diupdate',
            'data'    => $kota
        ], 200);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Gagal update: ' . $e->getMessage()], 500);
    }
}
// GET /api/kota/{id}
public function show($id)
{
$kota = Kota::with('propinsi')->findOrFail($id);
return response()->json([
'success' => true,
'data' => $kota
]);
}
// DELETE /api/kota/{id}
public function destroy($id)
    {
        try {
            $kota = Kota::findOrFail($id);
            $kota->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data kota berhasil dihapus'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal hapus: ' . $e->getMessage()], 500);
        }
    }
}