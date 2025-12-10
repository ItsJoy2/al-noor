<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Invoice Payment - Mindchain Ecosystem</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    body { background: linear-gradient(135deg, #0a0a0a, #1a1a1a, #2a2a2a, #1a1a1a, #0a0a0a); background-attachment: fixed; color: #fff; font-family: 'Segoe UI', sans-serif; min-height: 100vh;}
    .main-card { border-radius: 24px; background: rgba(15, 15, 15, 0.98); backdrop-filter: blur(20px); border: 1px solid rgba(64,64,64,0.3); box-shadow: 0 25px 50px -12px rgba(0,0,0,.9); overflow: hidden;}
    .card-header { background: linear-gradient(135deg, #111111, #222222); padding: 2rem; border-bottom: 1px solid rgba(64,64,64,0.3);}
    .company-logo { width: 50px; height: 50px; background: linear-gradient(135deg, #444, #666); border-radius: 12px; display:flex; align-items:center; justify-content:center; font-size:1.5rem; font-weight:bold; color:#fff;}
    .invoice-title { font-weight:700; font-size:2rem; margin:0;}
    .invoice-subtitle { color: rgba(255,255,255,.8);}
    .qr-container { background: rgba(25,25,25,.98); border-radius:20px; padding:2rem; text-align:center; border:2px solid rgba(64,64,64,.4);}
    .amount-display { font-size: 1.8rem; font-weight: 700; color: #fff;}
    .network-badge { background: linear-gradient(135deg,#333,#444); padding:.5rem 1rem; border-radius:20px; font-weight:600;}
    .address-container { background: rgba(10,10,10,.9); border-radius:12px; padding:1rem; border:1px solid rgba(64,64,64,.4); font-family:'Courier New', monospace;}
    .copy-btn { border-radius: 12px; background: linear-gradient(135deg,#333,#444); color:#fff; padding:0.5rem 1rem; border:1px solid rgba(255,255,255,.2);}
    .copy-btn:hover { background: linear-gradient(135deg,#444,#555);}
    .footer-branding { text-align:center; padding:2rem 0 1rem; color:rgba(255,255,255,.5); border-top:1px solid rgba(64,64,64,.3); margin-top:2rem;}
    .step { margin: 5px 0; }
    .step.active { color: #ffc107; font-weight: bold; }
    .step.completed { color: #28a745; font-weight: bold; }
    #paymentStatusBox { font-size: 1rem; }
  </style>
</head>
<body>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
      <div class="main-card">
        <!-- Header -->
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-auto">
              <div class="company-logo">
                <i class="fas fa-link"></i>
              </div>
            </div>
            <div class="col">
              <h1 class="invoice-title">Yeeo Finance</h1>
              <p class="invoice-subtitle">Secure Cryptocurrency Payment</p>
            </div>
            <div class="col-auto text-end">
              <div class="badge bg-warning text-dark px-3 py-2" style="font-size: 0.9rem;">
                <i class="fas fa-clock me-1"></i>
                Invoice #{{ $deposit->transaction_id }}
              </div>
            </div>
          </div>
        </div>

        <!-- Body -->
        <div class="card-body p-4">
          <!-- Timer & Steps -->
          <div class="row mb-4">
            <div class="col-md-8">
              <div class="timer-display">
                <p class="timer-label">Payment Window</p>
                <div id="timer" class="timer-text">Loading...</div>
                <div class="progress-container">
                  <div id="timerBar" class="progress-bar" style="width: 100%"></div>
                </div>
              </div>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
              <div class="d-flex flex-column gap-2">
                <div class="step pending" id="step1"><span class="status-indicator"></span> Awaiting Payment</div>
                <div class="step pending" id="step2"><span class="status-indicator"></span> Confirming Transaction</div>
                <div class="step pending" id="step3"><span class="status-indicator"></span> Payment Complete</div>
              </div>
            </div>
          </div>

          <!-- Payment Section -->
          <div class="row g-4">
            <!-- QR Code -->
            <div class="col-lg-5">
              <div class="qr-container">
                <div class="qr-title"><i class="fas fa-qrcode me-2"></i> Scan to Pay</div>
                <img id="qrCodeImg" src="" alt="Payment QR Code" class="img-fluid" style="max-width:200px;">
                <p class="small text-muted mt-2 mb-0"><i class="fas fa-mobile-alt me-1"></i> Compatible with Trust Wallet, MetaMask</p>
              </div>
            </div>

            <!-- Info -->
            <div class="col-lg-7">
              <div class="mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <h5><i class="fas fa-coins me-2 text-warning"></i> Payment Amount</h5>
                  <small id="createdTime" class="text-muted"></small>
                </div>
                <div class="d-flex align-items-center gap-3 mb-3">
                  <span id="amountText" class="amount-display"></span>
                  {{-- <span id="networkBadge" class="network-badge">MSC20</span> --}}
                  <button class="btn copy-btn copy-amount" data-copy=""><i class="fas fa-copy me-1"></i> Copy Amount</button>
                </div>
              </div>

              <div class="mb-4">
                <div class="d-flex align-items-center mb-2">
                  <div class="icon-badge me-3"><i class="fas fa-wallet"></i></div>
                  <h6 class="mb-0 text-light">Wallet Address</h6>
                </div>
                <div class="address-container">
                  <code id="walletAddress" class="d-block text-break text-info"></code>
                  <button class="btn copy-btn mt-2 copy-address" data-copy=""><i class="fas fa-copy me-1"></i> Copy Address</button>
                </div>
              </div>

              <div class="info-card p-3">
                <h6><i class="fas fa-info-circle me-2 text-info"></i> Network Details</h6>
                <div class="row text-sm">
                  <div class="col-sm-4"><strong>Network:</strong><br><span id="networkName" class="text-warning">Binance Smart Chain</span></div>
                  <div class="col-sm-4"><strong>Token:</strong><br><span id="tokenName" class="text-warning"></span></div>
                  <div class="col-sm-4"><strong>Confirmations:</strong><br><span class="text-warning">12 blocks</span></div>
                </div>
              </div>

              <div id="paymentStatusBox" class="alert alert-info text-center mt-4 d-none">
                <i class="fas fa-spinner fa-spin me-2"></i> Waiting for payment...
              </div>
            </div>
          </div>

          <!-- Footer -->
          <div class="footer-branding">
            <div class="d-flex align-items-center justify-content-center gap-3 mb-2">
              <i class="fas fa-lock text-success"></i><span>Powered by Blockchain Technology</span><i class="fas fa-check-circle text-success"></i>
            </div>
            <small>© {{ date('Y') }}  YEEO Finance. All rights reserved.</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Get dynamic transaction ID from Laravel
const transactionId = "{{ $deposit->transaction_id }}";

// Fetch invoice data
document.addEventListener("DOMContentLoaded", () => {
  fetch(`https://evm.blockmaster.info/api/invoice/${transactionId}`)
    .then(res => res.json())
    .then(data => {
      const invoice = data.invoice;
      const createdAt = new Date(invoice.created_at);
      const amountText = `${invoice.amount} ${invoice.token_name}`;

      document.getElementById("amountText").textContent = amountText;
      document.getElementById("walletAddress").textContent = invoice.wallet_address;
      document.getElementById("tokenName").textContent = invoice.token_name;
      document.getElementById("createdTime").textContent = createdAt.toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'});
      document.getElementById("qrCodeImg").src = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${invoice.wallet_address}`;

      document.querySelector(".copy-amount").setAttribute("data-copy", amountText);
      document.querySelector(".copy-address").setAttribute("data-copy", invoice.wallet_address);

      startTimer(invoice.created_at);
      updateStepByStatus(invoice.status);

      // Start polling
      setInterval(() => checkPaymentStatus(transactionId, invoice.token_name), 5000);
    })
    .catch(err => {
      console.error("API fetch error:", err);
    });
});

// Copy function
document.addEventListener("click", e => {
  if(e.target.closest(".copy-btn")) {
    const btn = e.target.closest(".copy-btn");
    const text = btn.getAttribute("data-copy");
    navigator.clipboard.writeText(text);
    btn.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
    setTimeout(()=>{ btn.innerHTML='<i class="fas fa-copy me-1"></i> Copy'; },2000);
  }
});

// Timer
function startTimer(createdAt) {
  const startTime = new Date(createdAt);
  const duration = 20 * 60 * 1000;
  const expiry = new Date(startTime.getTime() + duration);
  const timerEl = document.getElementById("timer");
  const timerBar = document.getElementById("timerBar");

  const interval = setInterval(()=>{
    const now = new Date();
    const remaining = expiry - now;
    if(remaining <= 0) {
      timerEl.innerHTML = "Invoice Expired";
      timerEl.classList.add("text-danger");
      timerBar.style.width = "0%";
      clearInterval(interval);
      return;
    }
    const min = Math.floor(remaining/1000/60);
    const sec = Math.floor((remaining/1000)%60);
    timerEl.innerHTML = `${String(min).padStart(2,"0")}:${String(sec).padStart(2,"0")}`;
    timerBar.style.width = `${(remaining/duration)*100}%`;
  },1000);
}

// Steps
function updateStepByStatus(status){
  const steps = {waiting:"step1", processing:"step2", success:"step3"};
  for(const id in steps){
    document.getElementById(steps[id]).classList.remove("active","completed");
  }
  if(status==="waiting"){ document.getElementById("step1").classList.add("active"); }
  if(status==="processing"){ document.getElementById("step1").classList.add("completed"); document.getElementById("step2").classList.add("active"); }
  if(status==="success"){ document.getElementById("step1").classList.add("completed"); document.getElementById("step2").classList.add("completed"); document.getElementById("step3").classList.add("active"); }
}

// Payment Polling
function checkPaymentStatus(txId, tokenName) {
  fetch(`https://evm.blockmaster.info/api/payments/${txId}`)
    .then(res => res.json())
    .then(data => {
      const statusBox = document.getElementById("paymentStatusBox");
      statusBox.classList.remove("d-none");

      if(data.balance && parseFloat(data.balance) > 0){
        updateStepByStatus("success");
        statusBox.classList.remove("alert-info");
        statusBox.classList.add("alert-success");
        statusBox.innerHTML = `<i class="fas fa-check-circle me-2"></i><strong>Payment Received:</strong> ${data.balance} ${tokenName}<br>Redirecting to dashboard...`;
        setTimeout(() => {
          window.location.href = "https://yeeo.finance/user/dashboard";
        }, 5000);
      } else {
        updateStepByStatus("waiting");
        statusBox.classList.remove("alert-success");
        statusBox.classList.add("alert-info");
        statusBox.innerHTML = `<i class="fas fa-clock me-2"></i> Awaiting payment...`;
      }
    })
    .catch(err => console.error("Status Check Error:", err));
}
</script>
</body>
</html>
