<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Validator;
use DataTables;

class CategoryController extends Controller
{
    public function index(){
        return view('categorys.index');
    }

        public function getdata()
        {
            $categorys = Category::all();

            return DataTables::of($categorys)
                    ->addColumn('action', function($category) {
                        return '<button class="btn btn-sm btn-warning" onclick="editCategory(' . $category->id . ')">Edit</button>' .
                            '<button class="btn btn-sm btn-danger" onclick="deleteCategory(' . $category->id . ')">Delete</button>';
                    })
                    ->make(true);
        }


        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'nama_kategori' => 'required',
                'deskripsi' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $category = Category::create([
                'nama_kategori' => $request->input('nama_kategori'),
                'deskripsi' => $request->input('deskripsi'),
            ]);

            return response()->json(['category' => $category]);
        }

        public function update(Request $request, $id)
        {
            $validator = Validator::make($request->all(), [
                'nama_kategori' => 'required',
                'deskripsi' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $category = Category::find($id);
            if (!$category) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            $category->nama_kategori = $request->input('nama_kategori');
            $category->deskripsi = $request->input('deskripsi');
            $category->save();

            return response()->json(['category' => $category]);
        }


        public function show($id)
        {
            $category = Category::find($id);

            if (!$category) {
                return view('errors.404');
            }

            return response()->json(['category' => $category]);
        }
        public function destroy($id)
        {
            Category::destroy($id);
            return response()->json([], 204);
        }

}
