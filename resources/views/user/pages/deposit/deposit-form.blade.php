@extends('user.layouts.app')

@section('userContent')
<div class="page-header">
  <h3 class="page-title"> Add Fund </h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Wallets</a></li>
      <li class="breadcrumb-item active" aria-current="page">Add Fund</li>
    </ol>
  </nav>
</div>
@include('user.layouts.alert')
<div class="row">
  <div class="col-lg-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Deposit Form</h4>
        <p>Select a payment method & complete your deposit.</p>

        <form class="forms-sample" method="POST" action="{{ route('user.deposit.store') }}">
        @csrf

          {{-- Select Wallet --}}
          <div class="form-group">
            <label>Select Wallet</label>
            <select class="form-control bg-transparent text-light border" name="wallet" required>
              <option value="funding">Funding Wallet</option>
            </select>
          </div>

          {{-- Deposit Methods --}}
          <div class="form-group">
            <label>Select Deposit Method</label>
            <select class="form-control bg-transparent text-light border" name="method_id" id="methodSelect" required>
                <option value="" class="text-dark">-- Select Method --</option>
                @foreach ($methods as $method)
                    <option value="{{ $method->id }}"
                            data-details="{{ json_encode($method->details) }}" class="text-dark">
                        {{ $method->name }} ({{ ucfirst(str_replace('_',' ', $method->type)) }})
                    </option>
                @endforeach
            </select>
          </div>

          {{-- Dynamic Payment Details + Copy Button --}}
          <div id="methodDetailsBox" class="alert alert-warning d-none"></div>

          {{-- Amount --}}
          <div class="form-group">
            <label>Deposit Amount</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text bg-primary text-white">৳</span>
              </div>
              <input type="number" class="form-control bg-transparent text-light border" name="amount" step="0.01" required>
            </div>
          </div>

          {{-- Transaction ID --}}
          <div class="form-group">
            <label>Transaction ID</label>
            <input type="text" class="form-control bg-transparent text-light border" name="transaction_id" placeholder="Enter transaction ID" required>
          </div>

          <button type="submit" class="btn btn-primary mr-2">Submit</button>
          <button type="reset" class="btn btn-dark">Cancel</button>

        </form>

      </div>
    </div>
  </div>
</div>

@endsection
@push('scripts')


<script>
// SHOW PAYMENT DETAILS + COPY ICON
const methodSelect = document.getElementById('methodSelect');
const methodDetailsBox = document.getElementById('methodDetailsBox');

methodSelect.addEventListener('change', function () {
    let details = this.selectedOptions[0].getAttribute('data-details');

    if(details) {
        details = JSON.parse(details);

        let html = "<strong>Payment Details:</strong><br><br>";

        for (const key in details) {
            let label = key.replace('_', ' ').toUpperCase();

            // ONLY these fields get COPY BUTTON
            if (
                key === "account" ||
                key === "account_number" ||
                key === "wallet_address"
            ) {

                html += `
                    <div class="d-flex align-items-center mb-2">
                        <span id="${key}_text">${label}: <strong>${details[key]}</strong></span>

                        <button type="button" class="btn btn-sm ml-2 copy-btn"
                            data-copy-target="${key}_text">
                            <i class="fa-solid fa-copy text-success"></i>
                        </button>
                    </div>
                `;

            } else {
                // NO COPY BUTTON
                html += `
                    <div class="mb-2">
                        ${label}: <strong>${details[key]}</strong>
                    </div>
                `;
            }
        }

        methodDetailsBox.innerHTML = html;
        methodDetailsBox.classList.remove('d-none');

        activateCopyButtons();
    }
    else {
        methodDetailsBox.classList.add('d-none');
    }
});


// COPY FUNCTION
function activateCopyButtons() {
    const buttons = document.querySelectorAll('.copy-btn');

    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            const target = this.getAttribute('data-copy-target');
            const fullText = document.getElementById(target).innerText;

            // Remove the label part — only copy the number / address
            const text = fullText.split(":").slice(1).join(":").trim();

            navigator.clipboard.writeText(text).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'Copied to clipboard.',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        });
    });
}
</script>
@endpush
