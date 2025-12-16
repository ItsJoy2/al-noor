@extends('admin.layouts.app')

@section('title', 'Pool Distribution')

@section('content')
<div class="container">
    <h2 class="mb-4">Pool Distribution</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">

        {{-- Rank Pool --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Rank Pool</h5>
                        <p class="text-muted mb-0">Balance: <strong>৳ {{ number_format($pool->rank, 2) }}</strong></p>
                    </div>
                    <button class="btn btn-primary"
                        onclick="confirmDistribute('rank')"
                        {{ $pool->rank <= 0 ? 'disabled' : '' }}>Distribute</button>
                </div>
            </div>
        </div>

        {{-- Club Pool --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Club Pool</h5>
                        <p class="text-muted mb-0">Balance: <strong>৳ {{ number_format($pool->club, 2) }}</strong></p>
                    </div>
                    <button class="btn btn-success"
                        onclick="confirmDistribute('club')"
                        {{ $pool->club <= 0 ? 'disabled' : '' }}>Distribute</button>
                </div>
            </div>
        </div>

        {{-- Shareholder Pool --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Shareholder Pool</h5>
                        <p class="text-muted mb-0">Balance: <strong>৳ {{ number_format($pool->shareholder, 2) }}</strong></p>
                    </div>
                    <button class="btn btn-warning"
                        onclick="confirmDistribute('shareholder')"
                        {{ $pool->shareholder <= 0 ? 'disabled' : '' }}>Distribute</button>
                </div>
            </div>
        </div>

        {{-- Director Pool --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Director Pool</h5>
                        <p class="text-muted mb-0">Balance: <strong>৳ {{ number_format($pool->director, 2) }}</strong></p>
                    </div>
                    <button class="btn btn-secondary"
                        onclick="confirmDistribute('director')"
                        {{ $pool->director <= 0 ? 'disabled' : '' }}>Distribute</button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDistribute(pool) {
        let poolName = pool.charAt(0).toUpperCase() + pool.slice(1);
        Swal.fire({
            title: `Distribute ${poolName} Pool?`,
            text: `Are you sure you want to distribute ${poolName} Pool to eligible users?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Distribute!'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/distribute-${pool}`;

                let token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = '{{ csrf_token() }}';
                form.appendChild(token);

                document.body.appendChild(form);
                form.submit();
            }
        })
    }
</script>

