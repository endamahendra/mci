<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;
use Validator;
use DataTables;

class PendudukController extends Controller
{
    public function index(){
        return view('penduduks.index');
    }

    public function getdata(){
        $penduduks = Penduduk::all();
        return DataTables::of($penduduks)->addColumn('action', function($penduduks){
                return '<button class="btn btn-sm btn-warning" onclick="editPenduduk(' . $penduduks->ID_Penduduk . ')">Edit</button>' .
                        '<button class="btn btn-sm btn-danger" onclick="deletePenduduk(' . $penduduks->ID_Penduduk . ')">Delete</button>';
            })
            ->make(true);
    }

        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'nik' => 'required|unique:penduduks',
                'nama' => 'required',
                'usia' => 'required',
                'alamat' => 'required',
                'pekerjaan' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
    
            $penduduk = Penduduk::create([
                'nik' => $request->input('nik'),
                'nama' => $request->input('nama'),
                'usia' => $request->input('usia'),
                'alamat' => $request->input('alamat'),
                'pekerjaan' => $request->input('pekerjaan'),
            ]);
    
            return response()->json(['penduduk' => $penduduk]);
        }

        public function update(Request $request, $id)
        {
            $validator = Validator::make($request->all(), [
                'nik' => 'required|unique:penduduks,nik,'.$id,
                'nama' => 'required',
                'usia' => 'required',
                'alamat' => 'required',
                'pekerjaan' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
    
            $penduduk = Penduduk::find($id);
            if (!$penduduk) {
                return response()->json(['error' => 'Data not found'], 404);
            }
    
            $penduduk->nik = $request->input('nik');
            $penduduk->nama = $request->input('nama');
            $penduduk->usia = $request->input('usia');
            $penduduk->alamat = $request->input('alamat');
            $penduduk->pekerjaan = $request->input('pekerjaan');
            $penduduk->save();
    
            return response()->json(['penduduk' => $penduduk]);
        }


        public function show($id)
        {
            $penduduk = Penduduk::find($id);

            if (!$penduduk) {
                return view('errors.404');
            }

            return response()->json(['penduduk' => $penduduk]);
        }
        public function destroy($id)
        {
            Penduduk::destroy($id);
            return response()->json([], 204);
        }
    
}