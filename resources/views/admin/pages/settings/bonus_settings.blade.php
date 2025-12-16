@extends('admin.layouts.app')

@section('title', 'Bonus Settings')

@section('content')
<div class="container">
    <h2 class="mb-4">Bonus Settings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.bonus-settings.update') }}" method="POST">
        @csrf

        <div class="row  w-75">
            <!-- Left Sidebar Navigation -->
            <div class="col-md-4">
                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist">

                    <button class="nav-link active" id="v-pills-level-tab"
                            data-bs-toggle="pill" data-bs-target="#v-pills-level"
                            type="button" role="tab">
                        <i class="fas fa-level-up-alt me-2"></i> Level Bonuses
                    </button>
                    <button class="nav-link" id="v-pills-pool-tab"
                            data-bs-toggle="pill" data-bs-target="#v-pills-pool"
                            type="button" role="tab">
                        <i class="fas fa-users me-2"></i> Pool Bonuses
                    </button>
                    <button class="nav-link" id="v-pills-rank-tab"
                            data-bs-toggle="pill" data-bs-target="#v-pills-rank"
                            type="button" role="tab">
                        <i class="fas fa-award me-2"></i> Rank Distribution
                    </button>

                    <button class="nav-link" id="v-pills-club-tab"
                            data-bs-toggle="pill" data-bs-target="#v-pills-club"
                            type="button" role="tab">
                        <i class="fas fa-star me-2"></i> Club Distribution
                    </button>
                    <button class="nav-link" id="v-pills-other-tab"
                            data-bs-toggle="pill" data-bs-target="#v-pills-other"
                            type="button" role="tab">
                        <i class="fas fa-cog me-2"></i> Reactivation Settings
                    </button>

                </div>
            </div>

            <!-- Right Content Area -->
            <div class="col-md-8">
                <div class="tab-content" id="v-pills-tabContent">

                    <!-- LEVEL BONUS TAB -->
                    <div class="tab-pane fade show active" id="v-pills-level" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Level Bonuses (%)
                                </h5>

                                <div class="row">
                                    @foreach (['level1','level2','level3','level4','level5'] as $lvl)
                                        <div class="col-md-6 mb-3">
                                            <label>{{ ucfirst($lvl) }} (%)</label>
                                            <input type="number" step="0.01" name="{{ $lvl }}"
                                                   value="{{ $bonus->$lvl }}"
                                                   class="form-control">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- POOL BONUS TAB -->
                    <div class="tab-pane fade" id="v-pills-pool" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Pool Bonuses (%)
                                </h5>

                                <div class="row">
                                    @foreach (['rank_pool','club_pool','shareholder_pool','director_pool'] as $pool)
                                        <div class="col-md-6 mb-3">
                                            <label>{{ ucwords(str_replace('_',' ',$pool)) }} (%)</label>
                                            <input type="number" step="0.01" name="{{ $pool }}"
                                                   value="{{ $bonus->$pool }}"
                                                   class="form-control">
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Rank Distribution Tab   --}}
                    <div class="tab-pane fade" id="v-pills-rank" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Rank Distribution (%)</h5>

                                <div class="row">
                                    @foreach (['rank1_percent','rank2_percent','rank3_percent'] as $rank)
                                        <div class="col-md-6 mb-3">
                                            <label>{{ ucwords(str_replace('_',' ',$rank)) }} (%)</label>
                                            <input type="number" step="0.01"
                                                name="{{ $rank }}"
                                                value="{{ $bonus->$rank }}"
                                                class="form-control">
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Club Distribution Tab  --}}

                    <div class="tab-pane fade" id="v-pills-club" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Club Distribution (%)</h5>

                                <div class="row">
                                    @foreach (['club1_percent','club2_percent','club3_percent'] as $club)
                                        <div class="col-md-6 mb-3">
                                            <label>{{ ucwords(str_replace('_',' ',$club)) }} (%)</label>
                                            <input type="number" step="0.01"
                                                name="{{ $club }}"
                                                value="{{ $bonus->$club }}"
                                                class="form-control">
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- OTHER SETTINGS TAB -->
                    <div class="tab-pane fade" id="v-pills-other" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Reactivation Settings
                                </h5>

                                <div class="mb-3">
                                    <label>Reactivation Charge (৳)</label>
                                    <input type="number" step="0.00000001" name="reactivation_charge"
                                           value="{{ number_format($bonus->reactivation_charge, 2) }}"
                                           class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Max Pending Installments</label>
                                    <input type="number" min="1" name="max_pending_installments"
                                           value="{{ $bonus->max_pending_installments }}"
                                           class="form-control">
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Settings</button>
                </div>

            </div>
        </div>

    </form>
</div>

<style>
    .nav-pills .nav-link {
        border-radius: 0.25rem;
        margin-bottom: 0.5rem;
        padding: 0.75rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .nav-pills .nav-link.active {
        background-color: #0d6efd;
        color: white;
    }
    .nav-pills .nav-link:hover:not(.active) {
        background-color: #f8f9fa;
    }
    .card {
        border: none;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .card-title {
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: 600;
    }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush
