@extends('layouts.app')

@section('title', 'Edit Pesanan')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="order_number" class="form-label">Nomor Pesanan</label>
                            <input type="text" class="form-control" id="order_number" value="{{ $order->order_number }}" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="created_at" class="form-label">Tanggal Pesanan</label>
                            <input type="text" class="form-control" id="created_at" value="{{ $order->created_at->format('d M Y H:i') }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="customer_name" value="{{ $order->customer_name }}" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="customer_email" class="form-label">Email Pelanggan</label>
                            <input type="email" class="form-control" id="customer_email" value="{{ $order->customer_email }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="customer_phone" class="form-label">No. Telepon Pelanggan</label>
                    <input type="text" class="form-control" id="customer_phone" value="{{ $order->customer_phone }}" disabled>
                </div>

                <hr>

                <h5>Status Pesanan</h5>
                <div class="mb-3">
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
