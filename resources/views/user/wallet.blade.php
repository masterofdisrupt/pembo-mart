@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h3 class="text-muted mb-3">Wallet Balance</h3>
                    <h2 class="display-4">₦ {{ number_format(auth()->user()->wallet ?? 0, 2) }}</h2>
                </div>
            </div>

            <div class="d-flex justify-content-center mb-4">
                <div class="col-md-4">
                        <div class="card-body text-center">
                            <button class="btn btn-primary btn-lg w-100" data-bs-toggle="modal" data-bs-target="#topUpModal">
                                 Top Up Wallet
                            </button>
                    
                    </div>
                </div>
               
            </div>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Transaction History</h5>
                </div>
                <div class="card-body">
                    @if(isset($transactions) && count($transactions) > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                        <td>{{ $transaction->type }}</td>
                                        <td>₦ {{ number_format($transaction->amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : 'warning' }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted">No transactions found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Top Up Modal -->
<div class="modal fade" id="topUpModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Top Up Wallet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('user.wallet.topup') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" class="form-control" name="amount" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection