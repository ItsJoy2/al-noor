@extends('user.layouts.app')

@section('userContent')
<div class="page-header">
    <h3 class="page-title">Buy Shares</h3>
</div>

@include('user.layouts.alert')

<div class="row g-4">

    @foreach($packages as $package)
    <div class="col-md-4">
        <div class="card h-100 shadow-sm">

            <div class="card-body">
                <h4 class="text-primary mb-3">{{ $package->share_name }}</h4>

                <p><strong>Share Price:</strong> ${{ $package->amount }}</p>
                <p><strong>Total Quantity:</strong> {{ $package->total_share_quantity }}</p>
                <p><strong>User Max Purchase:</strong> {{ $package->per_purchase_limit }} Shares</p>

                @if($package->first_installment > 0)
                    <p><strong>First Installment:</strong> ${{ $package->first_installment }}</p>
                    <p><strong>Monthly EMI:</strong> ${{ $package->monthly_installment }}</p>
                    <p><strong>Total Months:</strong> {{ $package->installment_months }}</p>
                @endif

                <button class="btn btn-success w-100 mt-3 buyShareBtn"
                        data-id="{{ $package->id }}"
                        data-name="{{ $package->share_name }}"
                        data-price="{{ $package->amount }}"
                        data-limit="{{ $package->per_purchase_limit }}"
                        data-first="{{ $package->first_installment }}"
                        data-monthly="{{ $package->monthly_installment }}"
                        data-months="{{ $package->installment_months }}">
                    Buy Now
                </button>
            </div>

        </div>
    </div>
    @endforeach

</div>

{{-- Buy Share Modal --}}
<div class="modal fade" id="buyShareModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('user.share.purchase') }}" id="buyShareForm">
            @csrf
            <input type="hidden" name="package_id" id="modalPackageId">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buy Share</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <p><strong>Share:</strong> <span id="modalShareName"></span></p>

                    <div class="mb-3">
                        <label>Quantity</label>
                        <input type="number" min="1" class="form-control" name="quantity" id="modalQuantityInput">
                        <small id="modalQuantityLimit" class="text-muted"></small>
                    </div>

                    <div class="mb-3">
                        <label>Payment Type</label>
                        <select name="purchase_type" id="paymentType" class="form-control">
                            <option value="full">Full Payment</option>
                            <option value="installment">Installment</option>
                        </select>
                    </div>

                    <div id="installmentDetails" class="d-none">
                        <p><strong>First Installment:</strong> $<span id="firstInstallmentText"></span></p>
                        <p><strong>Monthly EMI:</strong> $<span id="monthlyInstallmentText"></span></p>
                        <p><strong>Total Months:</strong> <span id="totalMonthsText"></span></p>
                    </div>

                    <p class="mt-3">
                        <strong>Total Payable:</strong> $<span id="modalTotalAmount">0.00</span>
                    </p>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Confirm Purchase</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

<script>
document.addEventListener("DOMContentLoaded", function () {
    let modal = new bootstrap.Modal(document.getElementById('buyShareModal'));

    document.querySelectorAll(".buyShareBtn").forEach(btn => {
        btn.addEventListener("click", function () {

            let id = this.dataset.id;
            let name = this.dataset.name;
            let price = parseFloat(this.dataset.price);
            let limit = parseInt(this.dataset.limit);
            let first = parseFloat(this.dataset.first);
            let monthly = parseFloat(this.dataset.monthly);
            let months = parseInt(this.dataset.months);

            document.getElementById("modalPackageId").value = id;
            document.getElementById("modalShareName").textContent = name;
            document.getElementById("modalQuantityLimit").textContent = `Max ${limit} shares allowed`;
            document.getElementById("firstInstallmentText").textContent = first;
            document.getElementById("monthlyInstallmentText").textContent = monthly;
            document.getElementById("totalMonthsText").textContent = months;
            document.getElementById("modalQuantityInput").value = "";
            document.getElementById("modalTotalAmount").textContent = "0.00";
            document.getElementById("installmentDetails").classList.add("d-none");

            modal.show();

            // Quantity Input Change
            document.getElementById("modalQuantityInput").addEventListener("input", function () {
                let qty = parseInt(this.value || 0);
                if (qty > limit) qty = limit;

                let total = qty * price;
                document.getElementById("modalTotalAmount").textContent = total.toFixed(2);

                // Update Installment Display
                document.getElementById("firstInstallmentText").textContent = (first * qty).toFixed(2);
                document.getElementById("monthlyInstallmentText").textContent = (monthly * qty).toFixed(2);
            });

            // Payment Type Toggle
            document.getElementById("paymentType").addEventListener("change", function () {
                if (this.value === "installment") {
                    document.getElementById("installmentDetails").classList.remove("d-none");
                } else {
                    document.getElementById("installmentDetails").classList.add("d-none");
                }
            });
        });
    });
});
</script>
