<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Buku;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BukuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function index()
    {
        $Buku = Buku::orderBy("id","DESC")->GET();

        return response()->json([
            'success' => true,
            'message' =>'List Semua Buku',
            'data'    => $Buku
        ], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gambar' => 'required',
            'judul'   => 'required',
            'harga' => 'required',
            'deskripsi' => 'required',
            'jumlah' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        } else {
            $time = Carbon::now();
            $avatar = Str::random(3);
            $imageName = $time->format('dmYHis')."_".$avatar."_".$request->file('gambar')->getClientOriginalName();
            $request->file('gambar')->move(storage_path('gambar'),$imageName);
            $Buku = Buku::create([
                'judul'     => $request->input('judul'),
                'harga'   => $request->input('harga'),
                'deskripsi'   => $request->input('deskripsi'),
                'jumlah'   => $request->input('jumlah'),
                'gambar'   => $imageName,
            ]);
            if ($Buku) {
                return response()->json([
                    'success' => true,
                    'message' => 'Buku Berhasil Disimpan!',
                    'data' => $Buku
                ], 201);
                // return redirect('http://localhost/tokobuku/admin.php?site=buku');
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku Gagal Disimpan!',
                ], 400);
            }
        }
    }
    public function show($id)
    {
        $Buku = Buku::find($id);
        if ($Buku) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Buku!',
                'data'      => $Buku
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Buku Tidak Ditemukan!',
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul'   => 'required',
            'harga' => 'required',
            'deskripsi' => 'required',
            'jumlah' => 'required',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $Buku = Buku::whereId($id)->update([
                'judul'     => $request->input('judul'),
                'harga'   => $request->input('harga'),
                'deskripsi'   => $request->input('deskripsi'),
                'jumlah'   => $request->input('jumlah'),
            ]);

            if ($Buku) {
                return response()->json([
                    'success' => true,
                    'message' => 'Buku Berhasil Diupdate!',
                    'data' => $Buku
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku Gagal Diupdate!',
                ], 400);
            }
        }
    }
    public function destroy($id)
    {
        $Buku = Buku::whereId($id)->first();      
        $Buku->delete();
    
        if ($Buku) {
            return response()->json([
                'success' => true,
                'message' => 'Buku Berhasil Dihapus!',
            ], 200);
        }
    
    }public function try(Request $req)
    {
        $gam = $req->file("gambar")->getClientOriginalName();
        $req->file('gambar')->move(storage_path('gambar'),$gam);
        return response()->json($gam);
    }
}
