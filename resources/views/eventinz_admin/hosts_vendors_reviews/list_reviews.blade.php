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
    <div class="card">

        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Events</th>
              <th scope="col">Author</th>
              <th scope="col">Cibles</th>
              <th scope="col">Content</th>
              <th scope="col">Date</th>
              <th scope="col">Cibles starts</th>
              <th scope="col">Status</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php  $count = 1;  ?>
            @forelse ($allReviews as $eachReview)
                
                <tr>
                <th scope="row">{{ $count++ }}</th>
                
                <td>
                    <a href="{{ $eachReview->event != null ? route('admin.details.event', $eachReview->event->id) : '#'}}">
                        {{ $eachReview->event != null ? $eachReview->event->generic_id : "This event does not exist"}}
                    </a>
                    {{-- {{ $eachReview->event->generic_id  ?? "" }} --}}
                </td>
                <td>{{ $eachReview->user->username }}</td>
                <td>{{ $eachReview->cibleUser->username }}</td>
                <td>{{ $eachReview->review_content }}</td>
                <td>{{ $eachReview->date_review }}</td><td>
                    <?php
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $eachReview->start_for_cibe) {
                                echo '<i class="fa fa-star"></i>'; // Étoile pleine
                            } else {
                                echo '<i class="fa fa-star-o"></i>'; // Étoile vide
                            }
                        }
                    ?>
                </td>
                <td>{{ $eachReview->status ?? "Show"}}</td>
                <td>
                    <a href="{{ route('admin.show.review', $eachReview->id) }}"  class="btn btn-info btn-sm"><i class="fas fa-pen"></i> Update</a>
                </td>
                </tr>
            @empty
                <div class="alert alert-warning">
                  No Reviews yet
                </div>
            @endforelse
          </tbody>
        </table>
      </div>

</div>

@endsection