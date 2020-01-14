@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Send a command to a specific channel on behalf of the user</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="channel">Channel:</label>
                            <input type="text" name="channel" required class="form-control" placeholder="Example: DBCMKT2CW">
                        </div>

                        <div class="form-group">
                            <label for="command">Command:</label>
                            <input type="text" name="command" required class="form-control" placeholder="Example: /gif">
                        </div>

                        <div class="form-group">
                            <label for="text">Text:</label>
                            <input type="text" name="text" required class="form-control" placeholder="Example: lol">
                        </div>

                        <button class="btn btn-primary" type="submit">
                            Send
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
