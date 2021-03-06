@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">HTTP Requests</div>

            <div class="card-body">
                <p>Total captured requests: {{ $requests->total() }}</p>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Request URL</th>
                            <th>Request Content</th>
                            <th>Request Method</th>
                            <th>Response</th>
                            <th>Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($requests as $request)
                            <tr>
                                <td>{{ $request->request_url }}</td>
                                <td>
                                    <pre>{{ $request->pretty_request_content }}</pre>
                                </td>
                                <td>{{ $request->request_method }}</td>
                                <td>{{ $request->response }}</td>
                                <td>{{ $request->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
