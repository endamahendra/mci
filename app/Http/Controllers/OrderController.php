<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Validator;
use DataTables;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.index');
    }
   public function getdata()
{
    $orders = Order::with('products', 'user')->get();
            return DataTables::of($orders)
        ->make(true);
}

    public function store(Request $request)
    {
    // Validasi input
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'products' => 'required|array',
        'products.*.id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
    ]);

    // Buat order baru
    $order = Order::create([
        'user_id' => $request->user_id,
    ]);

    // Attach products ke order dengan jumlah tertentu
    foreach ($request->products as $product) {
        $quantity = $product['quantity'];

        // Hitung total harga
        $productModel = Product::findOrFail($product['id']);
        $total_harga = $productModel->harga * $quantity;

        // Simpan ke tabel order_product
        $order->products()->attach($product['id'], ['quantity' => $quantity, 'total_harga' => $total_harga]);
    }

    // Response berhasil
    return response()->json(['message' => 'Order created successfully'], 201);
}

}
