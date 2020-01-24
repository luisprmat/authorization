@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Panel de control</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">{{ __('Close') }}</span>
                            </button>
                            {{ session('status') }}
                        </div>
                    @endif

                    ¡Te encuentras autenticado en el sistema!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
