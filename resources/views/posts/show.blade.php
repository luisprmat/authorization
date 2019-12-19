@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $post->title }}</div>

                <div class="card-body">
                    {{ $post->teaser }}

                    <hr>

                    @can('see-content')
                        {{ $post->content }}
                        <hr>
                        <p><strong>Autor: </strong><i>{{ $post->author->name }}</i></p>
                    @else
                        <h5>Debes aceptar nuestros términos de uso para ver el contenido</h5>

                        <form action="{{ url('accept-terms') }}" method="POST">
                            @csrf
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="accept" id="accept" value="1">
                                <label class="custom-control-label" for="accept">
                                    Confirmo que acepto los términos y condiciones de uso
                                </label>
                                <br>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
