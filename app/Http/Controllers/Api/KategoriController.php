<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(){
        $kategori = Kategori::latest()->get();
        $response = [
            'success'=> true,
            'message'=> 'Data Kategori',
            'data'=> $kategori,
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|unique:kategoris',
        ],[
            'nama_kategori.required'=>'Masukan Kategori',
            'nama_kategori.unique' => 'Kategori Sudah Di gunakan'
        ]);
        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'message'=> 'Silahkan Di isi Dengan Benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $kategori = new Kategori;
            $kategori -> nama_kategori = $request->nama_kategori;
            $kategori ->save();
        }
        if ($kategori) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Disimpan',
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Gagal Disimpan',
            ], 400);
        }
    }
    public function show($id)
    {
        $kategori = Kategori::find($id);
        if ($kategori) {
            return response()->json([
                'success' => true,
                'message' => 'Data Ditemukan',
                'data' => $kategori
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak Ditemukan'
            ], 404);
        }
    }
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
        ],[
            'nama_kategori.required'=>'Masukan Kategori',

        ]);
        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'message'=> 'Silahkan Di isi Dengan Benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $kategori = Kategori::find($id);
            $kategori -> nama_kategori = $request->nama_kategori;
            $kategori ->save();
        }
        if ($kategori) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diperbarui',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Gagal Disimpan',
            ], 400);
        }
    }
    public function destroy($id){
        $kategori = Kategori::find($id);
        if ($kategori) {
            $kategori->delete();
            return response()->json([
            'success' => true,
            'message' => 'Data '. $kategori->nama_kategori . ' Berhasil Dihapus',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak Ditemukan',
            ], 404);
        }


    }
}
