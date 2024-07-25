<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\genre;

class GenreController extends Controller
{
    public function index(){
        $genre = Genre::latest()->get();
        $response = [
            'success'=> true,
            'message'=> 'Data Genre',
            'data'=> $genre,
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_genre' => 'required|unique:genres',
        ],[
            'nama_genre.required'=>'Masukan Genre',
            'nama_genre.unique' => 'Genre Sudah Di gunakan'
        ]);
        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'message'=> 'Silahkan Di isi Dengan Benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $genre = new Genre;
            $genre -> nama_genre = $request->nama_genre;
            $genre ->save();
        }
        if ($genre) {
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
        $genre = Genre::find($id);
        if ($genre) {
            return response()->json([
                'success' => true,
                'message' => 'Data Ditemukan',
                'data' => $genre
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak Ditemukan',
            ], 404);
        }
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nama_genre' => 'required|unique:genres',
        ],[
            'nama_genre.required'=>'Masukan Genre',
            'nama_genre.unique' => 'Genre Sudah Di gunakan'
        ]);
        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'message'=> 'Silahkan Di isi Dengan Benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $genre = Genre::find($id);
            $genre -> nama_genre = $request->nama_genre;
            $genre ->save();
        }
        if ($genre) {
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

    public function destroy($id)
    {
        $genre = Genre::find($id);
        if ($genre) {
            $genre->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Dihapus',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak Ditemukan',
            ], 404);
        }
    }

}
