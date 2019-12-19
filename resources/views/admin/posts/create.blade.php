@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Crear post</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('posts.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="title">Título del post</label>

                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="teaser">Teaser</label>

                            <textarea id="teaser" class="form-control @error('teaser') is-invalid @enderror" name="teaser" rows="3">
                                {{ old('teaser') }}
                            </textarea>

                            @error('teaser')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Contenido</label>

                            <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content" rows="5">
                                {{ old('content') }}
                            </textarea>

                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                Crear borrador
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
