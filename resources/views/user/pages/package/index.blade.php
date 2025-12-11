@extends('user.layouts.app')

@section('userContent')
<div class="page-header">
    <h3 class="page-title">Buy Shares</h3>
</div>

@include('user.layouts.alert')

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-center g-4">
                @foreach($packages as $package)
                    <div class="col-md-6 col-lg-4 d-flex">
                        <div class="package-card w-100">
                            <div class="package-title">{{ $package->share_name }}</div>

<div class="price-tag">
    ${{ number_format($package->amount, 2) }} <br>
    <span class="text-gray" style="font-size: 12px; font-weight: 500;">(Installment Available)</span>
</div>



                            <hr style="border-top: 1px solid #ccc; margin: 1rem 0;">

                            <div class="stats-container mt-4">

                                <div class="stat-item">
                                    <span><i class="fas fa-layer-group"></i> Total Shares</span>
                                    <span>{{ $package->total_share_quantity }} </span>
                                </div>

                                <div class="stat-item">
                                    <span><i class="fas fa-user-check"></i> Max Purchase</span>
                                    <span>{{ $package->per_purchase_limit }} Shares</span>
                                </div>



                                @if($package->first_installment > 0)

                                    <div class="stat-item">
                                        <span><i class="fas fa-hand-holding-usd"></i> First Installment</span>
                                        <span>${{ number_format($package->first_installment, 2) }}</span>
                                    </div>

                                    <div class="stat-item">
                                        <span><i class="fas fa-calendar-alt"></i> Monthly EMI</span>
                                        <span>${{ number_format($package->monthly_installment, 2) }}</span>
                                    </div>

                                    <div class="stat-item">
                                        <span><i class="fas fa-clock"></i> Duration</span>
                                        <span>{{ $package->installment_months }} Months</span>
                                    </div>

                                @endif

                            </div>

                            <button type="button"
                                class="btn btn-purchase w-100 buyShareBtn mt-3"
                                data-id="{{ $package->id }}"
                                data-name="{{ $package->share_name }}"
                                data-price="{{ $package->amount }}"
                                data-limit="{{ $package->per_purchase_limit }}"
                                data-first="{{ $package->first_installment }}"
                                data-monthly="{{ $package->monthly_installment }}"
                                data-months="{{ $package->installment_months }}"
                                data-remaining="{{ $package->user_remaining }}">
                                Buy Now
                            </button>

                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </div>
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
                    <button type="button" class="btn-close text-danger" data-bs-dismiss="modal">X</button>
                </div>

                <div class="modal-body">

                    <p><strong>Share:</strong> <span id="modalShareName"></span></p>

                    <div class="mb-3">
                        <label>Quantity</label>
                        <input type="number" min="1" class="form-control bg-transparent text-light" name="quantity" id="modalQuantityInput">
                        <small id="modalQuantityLimit" class="text-muted"></small>
                    </div>

                    <div class="mb-3">
                        <label>Payment Type</label>
                        <select name="purchase_type" id="paymentType" class="form-control bg-dark text-light">
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
            let remaining = parseInt(this.dataset.remaining);
            let first = parseFloat(this.dataset.first);
            let monthly = parseFloat(this.dataset.monthly);
            let months = parseInt(this.dataset.months);

            document.getElementById("modalPackageId").value = id;
            document.getElementById("modalShareName").textContent = name;

            document.getElementById("modalQuantityLimit").textContent =
                `Max ${limit} shares allowed — You can still buy ${remaining} shares`;

            document.getElementById("firstInstallmentText").textContent = first;
            document.getElementById("monthlyInstallmentText").textContent = monthly;
            document.getElementById("totalMonthsText").textContent = months;

            document.getElementById("modalQuantityInput").value = "";
            document.getElementById("modalQuantityInput").max = remaining;
            document.getElementById("modalTotalAmount").textContent = "0.00";
            document.getElementById("installmentDetails").classList.add("d-none");

            modal.show();

            // Quantity input event
            document.getElementById("modalQuantityInput").addEventListener("input", function () {
                let qty = parseInt(this.value || 0);

                // Prevent entering more than remaining
                if (qty > remaining) {
                    this.value = remaining;
                    qty = remaining;
                }

                let total = qty * price;
                document.getElementById("modalTotalAmount").textContent = total.toFixed(2);

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

