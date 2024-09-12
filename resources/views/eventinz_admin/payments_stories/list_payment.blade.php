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
      <h3 class="card-title">Payments List</h3>
      {{-- <div class="card-tools">
        <a href="{{ route('admin.add.servicescategory') }}" class="btn bg-default">
          <i class="fas fa-plus"></i>
          Add New
        </a>
      </div> --}}
    </div>
    <!-- /.card-header -->
    <div class="card" id="responsive">

        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Users Generic Ids</th>
              <th scope="col">Types</th>
              <th scope="col">Dates</th>
              <th scope="col">Amounts</th>
              <th scope="col">Methods</th>
              <th scope="col">Currencies</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php  $count = 1;  ?>
            @forelse ($paymentsStories as $paymentsstorie)
                
                <tr>
                <th scope="row">{{ $count++ }}</th>
                <td>{{ $paymentsstorie->user->generic_id  ?? "" }}</td>
                <td>{{ $paymentsstorie->payment_type }}</td>
                <td>{{ $paymentsstorie->payment_date }}</td>
                <td>{{ $paymentsstorie->amount }}</td>
                <td>{{ $paymentsstorie->paymentmethod }}</td>
                <td>{{ $paymentsstorie->currency }}</td>
                <td>
                    <a href="{{ route('admin.show.payment', $paymentsstorie->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Details</a>
                </td>
                </tr>
            @empty
                <div class="alert alert-warning">
                  No Payment yet
                </div>
            @endforelse
          </tbody>
        </table>
      </div>

</div>

@endsection