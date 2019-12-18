@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1>Posts</h1>
            @can('create', App\Post::class)
                <a href="#" class="btn btn-primary">Crear Post</a>
            @endcan
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Título</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <th scope="row">{{ $post->id }}</th>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->author->name }}</td>
                            <td class="d-flex justify-content-end">
                                @can('update', $post)
                                    <a href="{{ route('posts.edit', $post) }}"><i class="fas fa-edit fa-fw"></i></a>
                                @endcan
                                @can('delete', $post)
                                    <a href="{{ route('posts.destroy', $post) }}" onclick="event.preventDefault();
                                        document.getElementById('delete-button-{{ $post->id }}').submit();"><i class="fas fa-trash-alt fa-fw"></i>
                                    </a>
                                    <form id="delete-button-{{ $post->id }}" action="{{ route('posts.destroy', $post) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
