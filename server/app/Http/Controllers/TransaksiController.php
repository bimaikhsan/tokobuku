<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaksi;
use App\Models\Buku;

class TransaksiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        $Transaksi = Transaksi::all();

        return response()->json([
            'success' => true,
            'message' =>'List Semua Transaksi',
            'data'    => $Transaksi
        ], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user'   => 'required',
            'buku' => 'required',
            'metode' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        } else {

            
            $data = json_decode($request->input('buku'));
            foreach ($data->data as $key => $value) {
                $Buku = Buku::find($key);
                $kurangbuku = $Buku->jumlah-$value->jumlah;
                Buku::whereId($key)->update([
                    'jumlah'   => $kurangbuku,
                ]);
                if ($kurangbuku < 0 || $Buku->jumlah < 0) {
                    // return redirect('http://localhost/tokobuku/index.php?site=error&msg=habis');
                    return response()->json([
                        'success' => false,
                        'message' => 'Transaksi Gagal Buku Habis!',
                    ], 400);
                }
            }
            $Transaksi = Transaksi::create([
                'id_user'     => $request->input('id_user'),
                'buku'   => $request->input('buku'),
                'metode'   => $request->input('metode'),
            ]);
            
            if ($Transaksi) {
                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi Berhasil Disimpan!',
                    'data' => $Transaksi,
                    'key' => $key,
                    'buku' => $Buku
                ], 201);
                // return redirect('http://localhost/tokobuku/index.php?site=keranjang');
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi Gagal Disimpan!',
                ], 400);
            }
            // return response()->json($data);
        }
    }
    public function show($id)
    {
        $Transaksi = Transaksi::find($id);
        if ($Transaksi) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Transaksi!',
                'data'      => $Transaksi
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi Tidak Ditemukan!',
            ], 404);
        }
    }
    public function lihat($id)
    {
        $Transaksi = Transaksi::where('id_user',$id)->orderBy('id',"DESC")->get();
        if ($Transaksi) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Transaksi!',
                'data'      => $Transaksi
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi Tidak Ditemukan!',
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_user'   => 'required',
            'buku' => 'required',
            'metode' => 'required',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $Transaksi = Transaksi::whereId($id)->update([
                'id_user'     => $request->input('id_user'),
                'buku'   => $request->input('buku'),
                'metode'   => $request->input('metode'),
            ]);

            if ($Transaksi) {
                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi Berhasil Diupdate!',
                    'data' => $Transaksi
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi Gagal Diupdate!',
                ], 400);
            }
        }
    }
    public function destroy($id)
    {
        $Transaksi = Transaksi::whereId($id)->first();      
        $Transaksi->delete();
    
        if ($Transaksi) {
            return response()->json([
                'success' => true,
                'message' => 'Transaksi Berhasil Dihapus!',
            ], 200);
        }
    
    }
}
