<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\Category;
use App\Models\CategoryProduct;
use Validator;
use DataTables;

class ProductController extends Controller
{
    public function index(){
        $categorys = Category::all();
                return view('products.index', compact('categorys'));
    }

    public function getdata()
    {
        $products = Product::with('categories')->get();
        return DataTables::of($products)
            ->addColumn('action', function ($product) {
                return '<button class="btn btn-sm btn-warning" onclick="editProduct(' . $product->id . ')">Edit</button>' .
                    '<button class="btn btn-sm btn-danger" onclick="deleteProduct(' . $product->id . ')">Delete</button>';
            })
            ->make(true);
    }

public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'sku' => 'required|unique:products',
        'deskripsi' => 'required',
        'harga' => 'required',
        'stok' => 'required',
        'category_id' => 'required|array', // Ubah validasi untuk menerima array
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $product = Product::create([
        'sku' => $request->input('sku'),
        'deskripsi' => $request->input('deskripsi'),
        'harga' => $request->input('harga'),
        'stok' => $request->input('stok'),
    ]);

    // Simpan relasi produk dan kategori
    $product->categories()->attach($request->input('category_id'));

    return response()->json(['product' => $product]);
}

public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'sku' => 'required|unique:products,sku,'.$id,
        'deskripsi' => 'required',
        'harga' => 'required',
        'stok' => 'required',
        'category_id' => 'required|array', // Ubah validasi untuk menerima array
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $product = Product::find($id);
    if (!$product) {
        return response()->json(['error' => 'Data not found'], 404);
    }

    $product->sku = $request->input('sku');
    $product->deskripsi = $request->input('deskripsi');
    $product->harga = $request->input('harga');
    $product->stok = $request->input('stok');
    $product->save();

    // Sinkronisasi relasi produk dan kategori
    $product->categories()->sync($request->input('category_id'));

    return response()->json(['product' => $product]);
}


        public function show($id)
        {
            $product = Product::find($id);

            if (!$product) {
                return view('errors.404');
            }

            return response()->json(['product' => $product]);
        }
        public function destroy($id)
        {
            Product::destroy($id);
            return response()->json([], 204);
        }

}
