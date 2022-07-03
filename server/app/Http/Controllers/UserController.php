<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Users;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        $User = Users::all();

        return response()->json([
            'success' => true,
            'message' =>'List Semua User',
            'data'    => $User
        ], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'   => 'required',
            'username' => 'required',
            'password' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        } else {
            $data = Users::where('username',$request->input('username'))->first();
            if ($data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Username sudah ada',
                    'data'   => $validator->errors()
                ],401);
            }
            if($request->input('status') != ""){
                $User = Users::create([
                    'nama'     => $request->input('nama'),
                    'username'   => $request->input('username'),
                    'password'   => md5($request->input('password')),
                    'status'   => $request->input('status'),
                    'email'   => $request->input('email'),
                ]);
            }else{
                $User = Users::create([
                    'nama'     => $request->input('nama'),
                    'username'   => $request->input('username'),
                    'password'   => md5($request->input('password')),
                    'status'   => 'member',
                    'email'   => $request->input('email'),
                ]);
            }
            

            if ($User) {
                return response()->json([
                    'success' => true,
                    'message' => 'User Berhasil Disimpan!',
                    'data' => $User
                ], 200);
                // return redirect('http://localhost/tokobuku/index.php?site=login');
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User Gagal Disimpan!',
                ], 401);
            }

        }
    }
    public function show($id)
    {
        $User = Users::find($id);
        if ($User) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail User!',
                'data'      => $User
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User Tidak Ditemukan!',
            ], 404);
        }
    }
    public function cektoken($token,$id)
    {
        $User = Users::where('token', $token)->where('id', $id)->first();
        if ($User) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail User!',
                'data'      => $User
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User Tidak Ditemukan!',
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama'   => 'required',
            'username' => 'required',
            'status' => 'required',
            'email' => 'required',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);

        } else {

            $User = Users::whereId($id)->update([
                'nama'     => $request->input('nama'),
                'username'   => $request->input('username'),
                'email'   => $request->input('email'),
                'status'   => $request->input('status'),
            ]);

            if ($User) {
                return response()->json([
                    'success' => true,
                    'message' => 'User Berhasil Diupdate!',
                    'data' => $User
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User Gagal Diupdate!',
                ], 400);
            }
        }
    }
    public function resetpass($id)
    {
        $User = Users::whereId($id)->update([
            'password'   => md5(12345678),
        ]);

        if ($User) {
            return response()->json([
                'success' => true,
                'message' => 'password Berhasil Diupdate!',
                'data' => $User
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'password Gagal Diupdate!',
            ], 400);
        }
        
    }
    public function destroy($id)
    {
        $User = Users::whereId($id)->first();      
        $User->delete();
    
        if ($User) {
            return response()->json([
                'success' => true,
                'message' => 'User Berhasil Dihapus!',
            ], 200);
        }
    
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib Diisi!',
                'data'   => $validator->errors()
            ],401);
            // return redirect('http://localhost/tokobuku/index.php?site=error&msg=input');
        } else {
            $username = $request->input('username');
            $password = md5($request->input('password'));
      
            $user = Users::where('username', $username)->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Username Tidak ditemukan!',
                    'data'   => $validator->errors()
                ],401);
                // return redirect('http://localhost/tokobuku/index.php?site=error&msg=user');
            }
      
            $isValidPassword = Hash::check($password, $user->password);
            if ($password != $user->password) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password Salah !',
                    'data'   => $validator->errors()
                ],401);
                // return redirect('http://localhost/tokobuku/index.php?site=error&msg=pass');
            }
            $generateToken = bin2hex(random_bytes(40));
            Users::where('username',$username)->update([
                'token' => $generateToken
            ]);
            $datasx['token'] = $generateToken;
            $datasx['id'] = $user->id;
            return response()->json([
                'success' => true,
                'message' => 'Login Berhasil!',
                'data' => $datasx
            ], 201);
            // return redirect('http://localhost/tokobuku/session.php?token='.$generateToken.'&id='.$user->id);
        }
    }
}
