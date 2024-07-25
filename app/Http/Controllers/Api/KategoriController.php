<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Validator;

class KategoriController extends Controller
{
    public function index(){
        $kategori = Kategori::latest()->get();
        $response = [
            'success' => true,
            'message' => 'Data kategori',
            'data' => $kategori,
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request){
        // validate
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|unique:kategoris',
        ], [
            'nama_kategori.required' => 'Masukkan kategori',
            'nama_kategori.unique' => 'Kategori sudah digunakan!',
        ]);
        
        if($validator->fails()){
            return response()->json([
                'succes' => false,
                'message' => 'Silahkan isi dengan benar!',
                'data' => $validator->errors(),
            ], 400);
        }else {
            $kategori = new Kategori;
            $kategori->nama_kategori = $request->nama_kategori;
            $kategori->save();
        }
        if($kategori){
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil di simpan!',
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data gagal di simpan!',
            ], 400);
        }
    }

    public function show($id){
        $kategori = Kategori::find($id);

        if($kategori){
            return response()->json([
                'success' => true,
                'message' => 'Detail kategori',
                'data' => $kategori,
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak di temukan',
            ], 404);
        }
    }
    public function update(Request $request, $id){
        // validate
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|unique:kategoris',
        ], [
            'nama_kategori.required' => 'Masukkan kategori',
        ]);
        
        if($validator->fails()){
            return response()->json([
                'succes' => false,
                'message' => 'Silahkan isi dengan benar!',
                'data' => $validator->errors(),
            ], 400);
        }else {
            $kategori = Kategori::find($id);
            $kategori->nama_kategori = $request->nama_kategori;
            $kategori->save();
        }
        if($kategori){
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil di edit!',
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data gagal di edit!',
            ], 400);
        }
    }

    public function destroy($id){
        $kategori = Kategori::find($id);
        if($kategori){
            $kategori->delete();
            return response()->json([
                'success' => true,
                'message' => 'data' . $kategori->nama_kategori . 'Berhasil di hapus',
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'data tidak di temukan',
            ], 404);
        }
       
    }

}
