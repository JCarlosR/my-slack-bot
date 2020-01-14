@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Opciones:</p>

                    <a href="{{ url('logs') }}" class="btn btn-primary btn-block">Mensajes de Log (Slack)</a>
                    <a href="{{ url('send') }}" class="btn btn-primary btn-block">Enviar mensajes (Impersonate)</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
