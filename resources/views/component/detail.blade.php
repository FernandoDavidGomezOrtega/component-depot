@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-10">
{{-- // mostramos mensaje --}}
@include('includes.message')

<div class="card pub_image pub_image_detail">
<div class="card-header">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="data-user mr-auto">
            {{ $component->name}}

        @if (Auth::user() && Auth::user()->role == 'admin')
            <div class="actions ml-auto">
                <a href="{{ route('component.edit', ['id' => $component->id]) }}" class="btn btn-sm btn-warning">Actualizar</a>

                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-sm btn-light" data-toggle="modal" data-target="#myModal">
                    Borrar
                </button>

                <!-- The Modal -->
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Confirmación necesaria</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                ¿Quieres borrar esta imagen definitivamente?
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <a href="{{ route('component.delete', ['id' => $component->id]) }}" class="btn btn-danger">Borrar definitivamente</a>
                                <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>

                            </div>

                        </div>
                    </div>
                </div>


            </div>
        @endif
    </div>



</div>

<div class="card-body">
    <div class="image-container image-detail">
        <img src="{{ route('component.file', ['filename' => $component->image_path]) }}" alt="">
    </div>

    <div class="description">
        <p>
            <strong>{{ $component->name }}</strong>
        </p>

        <p>
            {{ $component->description }}
        </p>
    </div>
    <div class="likes">
        {{--           Comprobar si el usuario le dio like a la imagen--}}
        @if (Auth::check())
            <?php $user_like = false ?>
            @foreach ($component->likes as $like)
                @if ($like->user->id == Auth::user()->id)
                    <?php $user_like = true ?>
                @endif
            @endforeach


            @if ($user_like)
                <img src="{{ asset('img/facebook-like-64-blue.png') }}" alt="" data-id="{{ $component->id }}" class="btn-dislike">
            @else
                <img src="{{ asset('img/facebook-like-64-gray.png') }}" alt="" data-id="{{ $component->id }}" class="btn-like">
            @endif
            <span class="number_likes">{{ count($component->likes) }}</span>

        @else
{{--            <img src="{{ asset('img/facebook-like-64-gray.png') }}" alt="" data-id="{{ $component->id }}" class="btn-like">--}}
            <img src="{{ asset('img/facebook-like-64-gray.png') }}" alt="">
            <span class="number_likes">{{ count($component->likes) }}</span>

        @endif



    </div>

    {{-- // comentarios --}}
    <div class="clearfix"></div>
    <div class="comments">
        <h2>Comentarios ({{ count($component->comments) }})</h2>
        <hr>

        <form action="{{ route('comment.save') }}" method="POST" id="">
            @csrf

            <input type="hidden" value="{{ $component->id }}" name="component_id" id="" />
            <p>
                <textarea name="content" id="" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" required></textarea>
                @if ($errors->has('content'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('content') }}</strong>
                </span>

                @endif
            </p>
            <button type="submit" class="btn btn-success" id="">Enviar</button>
        </form>

        <hr>
        @foreach ($component->comments as $comment)
        <div class="comment">
            <span class="nickname">
                {{ '@'.$comment->user->nick }}
            </span>
            <span class="nickname date">{{ ' | '.\FormatTime::LongTimeFilter($comment->created_at, 'M') }}</span>

            <p>
                {{ $comment->content }} <br>
                @if (Auth::check() && (Auth::user()->role == 'admin' ))
                <a href="{{ route('comment.delete', ['id' => $comment->id]) }}" class="btn btn-sm btn-light">Eliminar comentario</a>

                @endif
            </p>

        </div>
        @endforeach
    </div>
</div>
</div>

</div>

</div>
</div>

@endsection

