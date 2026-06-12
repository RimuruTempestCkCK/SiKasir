@extends('layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Sales Transaction</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/kasir') }}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Transaction</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Select Products</h4>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <input type="text" id="searchProduct" class="form-control" placeholder="Search product by name...">
                        </div>
                    </div>
                    <div class="row" id="productList">
                        @foreach($products as $product)
                        <div class="col-md-4 mb-3 product-item" data-name="{{ strtolower($product->name) }}">
                            <div class="card border shadow-sm h-100">
                                @if($product->photo)
                                    <img src="{{ asset('storage/' . $product->photo) }}" class="card-img-top p-2" alt="Product" style="height: 120px; object-fit: contain;">
                                @else
                                    <img src="{{ asset('assets/images/big/icon.png') }}" class="card-img-top p-2" alt="Product" style="height: 120px; object-fit: contain;">
                                @endif
                                <div class="card-body p-2 text-center">
                                    <h6 class="card-title mb-1">{{ $product->name }}</h6>
                                    <p class="text-primary font-weight-bold mb-2">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                                    <p class="small text-muted mb-2">Stock: {{ $product->stock }}</p>
                                    <button class="btn btn-sm btn-primary btn-block btn-rounded add-to-cart"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-price="{{ $product->selling_price }}"
                                        data-stock="{{ $product->stock }}">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-danger"><i class="fas fa-shopping-cart"></i> Cart</h4>
                    <div class="table-responsive" style="max-height: 400px;">
                        <table class="table table-sm" id="cartTable">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Cart items will be here -->
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between h4">
                        <span>Total:</span>
                        <span id="cartTotal">Rp 0</span>
                    </div>
                    <button class="btn btn-success btn-lg btn-block mt-3 btn-rounded shadow" id="btnCheckout" disabled>
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div id="paymentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-success">
                    <h4 class="modal-title" id="paymentModalLabel">Process Payment</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form id="transactionForm" action="{{ route('kasir.transaction.store') }}" method="POST">
                    @csrf
                    <div id="hiddenInputs"></div>
                    <div class="modal-body text-center">
                        <h2 class="mb-4">Total: <span id="modalTotalText">Rp 0</span></h2>
                        <input type="hidden" id="modalTotalInput" name="total_price">
                        <div class="form-group mb-3 text-start">
                            <label class="form-label">Transaction Date (Optional - fill if late)</label>
                            <input type="date" name="transaction_date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Amount Paid</label>
                            <input type="number" name="amount_paid" id="amountPaid" class="form-control form-control-lg text-center" placeholder="0" required autofocus>
                        </div>
                        <div class="h3 text-muted" id="changeText">Change: Rp 0</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success btn-lg">Finish Transaction</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let cart = [];
    const productList = document.querySelectorAll('.product-item');
    const searchInput = document.getElementById('searchProduct');
    const cartTableBody = document.querySelector('#cartTable tbody');
    const cartTotalLabel = document.getElementById('cartTotal');
    const btnCheckout = document.getElementById('btnCheckout');
    const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
    const modalTotalText = document.getElementById('modalTotalText');
    const amountPaidInput = document.getElementById('amountPaid');
    const changeText = document.getElementById('changeText');
    const hiddenInputs = document.getElementById('hiddenInputs');

    // Search
    searchInput.addEventListener('keyup', function() {
        const query = this.value.toLowerCase();
        productList.forEach(item => {
            if (item.getAttribute('data-name').includes(query)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Add to Cart
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const price = parseInt(this.getAttribute('data-price'));
            const stock = parseInt(this.getAttribute('data-stock'));

            const existing = cart.find(item => item.id === id);
            if (existing) {
                if (existing.quantity < stock) {
                    existing.quantity++;
                } else {
                    alert('Stock reached');
                }
            } else {
                cart.push({ id, name, price, quantity: 1, stock });
            }
            renderCart();
        });
    });

    function renderCart() {
        cartTableBody.innerHTML = '';
        let total = 0;
        cart.forEach((item, index) => {
            const rowTotal = item.price * item.quantity;
            total += rowTotal;
            cartTableBody.innerHTML += `
                <tr>
                    <td>${item.name}</td>
                    <td>
                        <div class="input-group input-group-sm" style="width: 80px;">
                            <input type="number" class="form-control text-center cart-qty" data-index="${index}" value="${item.quantity}" min="1" max="${item.stock}">
                        </div>
                    </td>
                    <td>${new Intl.NumberFormat('id-ID').format(rowTotal)}</td>
                    <td><button class="btn btn-sm btn-danger remove-item" data-index="${index}"><i class="fas fa-times"></i></button></td>
                </tr>
            `;
        });
        cartTotalLabel.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        btnCheckout.disabled = cart.length === 0;

        // Qty change
        document.querySelectorAll('.cart-qty').forEach(input => {
            input.addEventListener('change', function() {
                const index = this.getAttribute('data-index');
                const val = parseInt(this.value);
                if (val > cart[index].stock) {
                    alert('Stock only ' + cart[index].stock);
                    this.value = cart[index].stock;
                    cart[index].quantity = cart[index].stock;
                } else {
                    cart[index].quantity = val;
                }
                renderCart();
            });
        });

        // Remove
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', function() {
                const index = this.getAttribute('data-index');
                cart.splice(index, 1);
                renderCart();
            });
        });
    }

    btnCheckout.addEventListener('click', function() {
        let total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        modalTotalText.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        document.getElementById('modalTotalInput').value = total;
        paymentModal.show();
    });

    amountPaidInput.addEventListener('keyup', function() {
        let total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        let paid = parseInt(this.value) || 0;
        let change = paid - total;
        changeText.innerText = 'Change: Rp ' + (change > 0 ? new Intl.NumberFormat('id-ID').format(change) : '0');
    });

    document.getElementById('transactionForm').addEventListener('submit', function() {
        hiddenInputs.innerHTML = '';
        cart.forEach((item, index) => {
            hiddenInputs.innerHTML += `
                <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
            `;
        });
    });
});
</script>
@endsection
