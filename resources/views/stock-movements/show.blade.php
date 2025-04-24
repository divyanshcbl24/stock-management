@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Stock Movement Details</h3>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Product:</div>
                        <div class="col-md-8">{{ $stockMovement->product->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Movement Type:</div>
                        <div class="col-md-8">
                            <span class="badge badge-{{ $stockMovement->type === 'in' ? 'success' : 'danger' }}">
                                {{ $stockMovement->type === 'in' ? 'Stock In' : 'Stock Out' }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Quantity:</div>
                        <div class="col-md-8">{{ $stockMovement->quantity }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Notes:</div>
                        <div class="col-md-8">{{ $stockMovement->notes ?? 'No notes provided' }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Recorded By:</div>
                        <div class="col-md-8">{{ $stockMovement->user->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Date:</div>
                        <div class="col-md-8">{{ $stockMovement->created_at->format('Y-m-d H:i:s') }}</div>
                    </div>

                    <div class="form-group mb-0">
                        <a href="{{ route('stock-movements.index') }}" class="btn btn-secondary">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
