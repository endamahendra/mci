<!-- Modal untuk inputan Purchase Order -->
<div class="modal fade" id="purchaseOrderFormModal" tabindex="-1" role="dialog" aria-labelledby="purchaseOrderFormModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="purchaseOrderFormModalLabel">Form Tambah Purchase Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="purchaseOrderForm">
                    @csrf
                    <input type="hidden" id="id">
                    <div class="col-md-12">
                        <input type="text" id="no_po" class="form-control" placeholder="Nomor PO">
                    </div>
                    <div class="col-md-12">
                        <input type="date" id="tanggal" class="form-control" placeholder="Tanggal">
                    </div>
                    <div class="col-md-12">
                        <select id="supplier_id" class="form-control">
                            <option value="">Pilih Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->nama_pemasok }}</option>
                            @endforeach
                        </select> 
                    </div>
                    <div class="col-md-12">
                        <select id="product_id" class="form-control">
                            <option value="">Pilih Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->harga }}">{{ $product->nama_product }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <input type="text" id="harga" class="form-control" placeholder="Harga" readonly>
                    </div>
                    <div class="col-md-12">
                        <input type="number" id="qty" class="form-control" placeholder="Kuantitas">
                    </div>
                    <div class="col-md-12">
                        <input type="number" id="total" class="form-control" placeholder="Total" readonly>
                    </div>
                    <div class="col-md-12">
                        <textarea id="keterangan" class="form-control" placeholder="Keterangan"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="button" onclick="savePurchaseOrder()" id="simpanPurchaseOrder" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal untuk menampilkan detail Purchase Order by id-->
<div class="modal fade" id="purchaseOrderDetailModal" tabindex="-1" role="dialog" aria-labelledby="purchaseOrderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="purchaseOrderDetailModalLabel">Detail Purchase Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="detail_no_po" class="form-label">Nomor PO</label>
                        <input type="text" id="detail_no_po" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="detail_tanggal" class="form-label">Tanggal</label>
                        <input type="date" id="detail_tanggal" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="detail_supplier" class="form-label">Supplier</label>
                        <input type="text" id="detail_supplier" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="detail_product" class="form-label">Product</label>
                        <input type="text" id="detail_product" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="detail_qty" class="form-label">Kuantitas</label>
                        <input type="number" id="detail_qty" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="detail_total" class="form-label">Total</label>
                        <input type="number" id="detail_total" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="detail_keterangan" class="form-label">Keterangan</label>
                        <textarea id="detail_keterangan" class="form-control" readonly></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>




<script>
    $(document).ready(function() {
        $('#product_id').change(function() {
            var productId = $(this).val();
            var productPrice = $(this).find(':selected').data('price');
            $('#harga').val(productPrice);
        });

        $('#qty').on('input', function() {
            var qty = parseFloat($(this).val());
            var price = parseFloat($('#product_id option:selected').data('price'));
            if (!isNaN(qty) && !isNaN(price)) {
                $('#total').val((qty * price).toFixed(2));
            } else {
                $('#total').val('');
            }
        });
     });
</script>
