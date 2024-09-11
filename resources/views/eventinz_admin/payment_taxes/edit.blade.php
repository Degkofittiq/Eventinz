@extends('eventinz_admin.layouts.app')
@section('content_admin') 
<div class="card card-primary">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card-header">
      <h3 class="card-title">Payment Found Details</h3>
    </div>
    <!-- /.card-header --><table class="table">
    <tr>
        <th>Payment Id</th>
        <td>{{ $paymentFound->payment_id ?? ""}}</td>
    </tr>
    <tr>
        <th>User Name</th>
        <td>{{ $paymentFound->user->username ?? ""}}</td>
    </tr>
    <tr>
        <th>Number/Email</th>
        <td>{{ $paymentFound->phone_number_or_email ?? ""}}</td>
    </tr>
    <tr>
        <th>Service Type</th>
        <td>{{ $paymentFound->payment_type ?? ""}}</td>
    </tr>
    <tr>
        <th>Payment Date</th>
        <td>{{ $paymentFound->payment_date ?? ""}}</td>
    </tr>
    <tr>
        <th>Amount</th>
        <td>{{ $paymentFound->amount ?? ""}}</td>
    </tr>
    <tr>
        <th>Payment Method</th>
        <td>{{ $paymentFound->paymentmethod ?? ""}}</td>
    </tr>
    <tr>
        <th>Currency</th>
        <td>{{ $paymentFound->currency ?? ""}}</td>
    </tr>
    <tr>
        <th>Description</th>
        <td>{{ $paymentFound->description ?? ""}}</td>
    </tr>
    <tr>
        <th>Status</th>
        {{--  pending  --}}
        @if ($paymentFound->status == "failed" || $paymentFound->status == "pending")
            <td class="{{ $paymentFound->status == "pending" ? "text-warning" : "text-red" }}">
                <strong>
                    {{ $paymentFound->status ?? ""}}
                </strong>
            </td>
        @else
            <strong>
                <td class="text-success">{{ $paymentFound->status ?? ""}}</td>              
            </strong>          
        @endif
    </tr>
</table>
</div>

@endsection