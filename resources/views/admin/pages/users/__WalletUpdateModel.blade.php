<!-- Wallet Update Modal -->
<div class="modal fade" id="walletUpdateModal" tabindex="-1" aria-labelledby="walletUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.users.wallet.update') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="walletUpdateModalLabel">Update Wallet Balance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{-- Wallet Selection --}}
                    <div class="mb-3">
                        <label for="wallet_type" class="form-label">Select Wallet</label>
                        <select class="form-select" name="wallet_type" id="wallet_type" required>
                            <option value="funding_wallet">Funding Wallet</option>
                            <option value="spot_wallet">Spot Wallet</option>
                            <option value="token_wallet">Token Wallet</option>
                        </select>
                    </div>

                    {{-- Action Type --}}
                    <div class="mb-3">
                        <label for="action_type" class="form-label">Action</label>
                        <select class="form-select" name="action_type" id="action_type" required>
                            <option value="add">Add</option>
                            <option value="subtract">Reduce</option>
                        </select>
                    </div>

                    {{-- Amount --}}
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update Balance</button>
                </div>
            </div>
        </form>
    </div>
</div>
