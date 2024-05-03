<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Product;
use Validator; 
use DataTables;
class PurchaseOrderController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        $products = Product::all();

        return view('purchase_orders.index', compact('suppliers', 'products'));
    }

    public function getdata()
    {
        $purchaseOrders = PurchaseOrder::with(['supplier', 'product'])->get();
        return DataTables::of($purchaseOrders)->addColumn('action', function ($purchaseOrder) {
            return '<button class="btn btn-sm btn-warning" onclick="editPurchaseOrder(' . $purchaseOrder->id . ')">Edit</button>' .
                '<button class="btn btn-sm btn-success" onclick="viewPurchaseOrder(' . $purchaseOrder->id . ')">View</button>' .
                '<button class="btn btn-sm btn-danger" onclick="deletePurchaseOrder(' . $purchaseOrder->id . ')">Delete</button>';
        })->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_po' => 'required|unique:purchase_orders',
            'tanggal' => 'required',
            'supplier_id' => 'required',
            'product_id' => 'required',
            'qty' => 'required',
            'total' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $purchaseOrder = PurchaseOrder::create([
            'no_po' => $request->input('no_po'),
            'tanggal' => $request->input('tanggal'),
            'supplier_id' => $request->input('supplier_id'),
            'product_id' => $request->input('product_id'),
            'total' => $request->input('total'),
            'qty' => $request->input('qty'),
            'keterangan' => $request->input('keterangan'),
        ]);

        return response()->json(['purchaseOrder' => $purchaseOrder]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'no_po' => 'required|unique:purchase_orders,no_po,' . $id,
            'tanggal' => 'required',
            'supplier_id' => 'required',
            'product_id' => 'required',
            'qty' => 'required',
            'total' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $purchaseOrder = PurchaseOrder::find($id);
        if (!$purchaseOrder) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $purchaseOrder->update([
            'no_po' => $request->input('no_po'),
            'tanggal' => $request->input('tanggal'),
            'supplier_id' => $request->input('supplier_id'),
            'product_id' => $request->input('product_id'),
            'qty' => $request->input('qty'),
            'total' => $request->input('total'),
            'keterangan' => $request->input('keterangan'),
        ]);

        return response()->json(['purchaseOrder' => $purchaseOrder]);
    }

    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::with(['supplier', 'customer', 'product'])->find($id);

        if (!$purchaseOrder) {
            return view('errors.404');
        }

        return response()->json(['purchaseOrder' => $purchaseOrder]);
    }

    public function destroy($id)
    {
        PurchaseOrder::destroy($id);
        return response()->json([], 204);
    }
}
