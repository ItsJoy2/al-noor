@extends('admin.layouts.app')

@section('title', 'General Settings')

@section('content')
<div class="container">
    <h2 class="mb-4">Referral Settings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        <div class="row w-75">
            <!-- Left Sidebar Tabs -->
            <div class="col-md-3">
                <div class="nav flex-column nav-pills me-3" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="v-pills-shareholder-tab" data-bs-toggle="pill" data-bs-target="#v-pills-shareholder" type="button" role="tab">
                        Shareholder
                    </button>
                    <button class="nav-link" id="v-pills-club-tab" data-bs-toggle="pill" data-bs-target="#v-pills-club" type="button" role="tab">
                        Clubs
                    </button>
                    <button class="nav-link" id="v-pills-rank-tab" data-bs-toggle="pill" data-bs-target="#v-pills-rank" type="button" role="tab">
                        Ranks
                    </button>
                </div>
            </div>

            <!-- Right Content Area -->
            <div class="col-md-9">
                <div class="tab-content">
                    <!-- Shareholder Tab -->
                    <div class="tab-pane fade show active" id="v-pills-shareholder" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Shareholder Settings</h5>
                                <div class="mb-3">
                                    <label>Minimum Shares</label>
                                    <input type="number" step="0.01" name="shareholder_min_shares" value="{{ $settings['shareholder_min_shares'] ?? '' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Club Tab -->
                    <div class="tab-pane fade" id="v-pills-club" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Club Settings</h5>
                                @for($i=1; $i<=3; $i++)
                                    <div class="mb-3">
                                        <label>Club {{ $i }} Minimum Shares</label>
                                        <input type="number" step="0.01" name="club{{ $i }}_min_shares" value="{{ $settings['club'.$i.'_min_shares'] ?? '' }}" class="form-control">
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- Rank Tab -->
                    <div class="tab-pane fade" id="v-pills-rank" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Rank Settings</h5>

                                @for($i=1; $i<=3; $i++)
                                    <div class="mb-3"><strong>Rank {{ $i }}</strong></div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>Minimum Shares</label>
                                            <input type="number" step="0.01" name="rank{{ $i }}_min_shares"
                                                value="{{ $settings['rank'.$i.'_min_shares'] ?? '' }}"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Minimum Active Referrals</label>
                                            <input type="number" step="1" name="rank{{ $i }}_min_active_referrals"
                                                value="{{ $settings['rank'.$i.'_min_active_referrals'] ?? '' }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <hr>
                                @endfor

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
