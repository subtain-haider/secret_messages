@extends('layout.app')
@section('content')
<div class="container">
    <div class="row my-3">
        <div class="col-md-6">
            <h4>Messages</h4>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addMessage">Create Message</button>
        </div>
    </div>

    @include('error_message')

        @if ($errors->any())
            <div class="row mb-2">
                <div class="col-12">

                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    <div class="row">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                    <li class="nav-item" role="presentation">
                      <a
                        class="nav-link active"
                        id="inbox-1"
                        data-bs-toggle="tab"
                        href="#inbox"
                        role="tab"
                        aria-controls="inbox"
                        aria-selected="true"
                        >Inbox</a
                      >
                    </li>
                    <li class="nav-item" role="presentation">
                      <a
                        class="nav-link"
                        id="sent-1"
                        data-bs-toggle="tab"
                        href="#sent"
                        role="tab"
                        aria-controls="sent"
                        aria-selected="false"
                        >Sent</a
                      >
                    </li>
                  </ul>
                  <div class="tab-content" id="ex1-content">
                    <div
                      class="tab-pane fade show active"
                      id="inbox"
                      role="tabpanel"
                      aria-labelledby="inbox-1"
                    >
                    <!----inbox table---->
                    @if($receivedMessages->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>From</td>
                                        <td>Message</td>
                                        <td>Date</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($receivedMessages as $receivedMessage)
                                        <tr class="clickable-row" data-id={{ $receivedMessage->id }}>
                                            <td>{{ $receivedMessage->sender->name }}</td>
                                            <td>{{ Str::limit($receivedMessage->text, 50) }}</td>
                                            <td>{{ $receivedMessage->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {!! $receivedMessages->withQueryString()->links() !!}
                    @else
                    <p class="text-center">No messages available.</p>
                    @endif
                    <!----inbox table---->
                    </div>
                    <div class="tab-pane fade" id="sent" role="tabpanel" aria-labelledby="sent-1">
                       <!----inbox table---->
                    @if($sentMessages->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>To</td>
                                    <td>Message</td>
                                    <td>Date</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sentMessages as $sentMessage)
                                    <tr class="clickable-row" data-id={{ $sentMessage->id }}>
                                        <td>{{ $sentMessage->recipient->name }}</td>
                                        <td>{{ Str::limit($sentMessage->text, 50) }}</td>
                                        <td>{{ $sentMessage->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {!! $sentMessages->withQueryString()->links() !!}
                @else
                <p class="text-center">No messages available.</p>
                @endif
                <!----inbox table---->
                    </div>
                  </div>
            </div><!---card body--->
        </div>
    </div>
</div>


<!--modal--->
<div class="modal fade" id="showMessage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
            <h4>Message Details</h4>
            <p id="message"></p>
            <p id="date"></p>
            <div class="d-grid gap-2">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
      </div>
    </div>
</div>


<!--create message--->
<div class="modal fade" id="addMessage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Send New Message</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('messages.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-12 mb-3">
                    <select name="recipient_id" class="form-control" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <textarea name="text"  class="form-control" required></textarea>
                </div>

                <div class="col-12 mb-3">
                    <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">Send</button>
                    </div>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        var showMessage = new bootstrap.Modal(document.getElementById("showMessage"), {});
        // Attach a click event handler to the table rows
        $('.clickable-row').click(function() {
            // Open the modal
            var messageId = $(this).data('id');
            fetch(`/messages/${messageId}`)
                .then(response => response.json())
                .then(data => {
                    if(data['message'])
                    {
                        $('#message').text(data['message']['text'])
                        $('#date').text(data['message']['created_at'])
                        showMessage.show();
                    }
                });
            });
    });

</script>
@endsection
