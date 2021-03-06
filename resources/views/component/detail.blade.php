@extends('layouts.app')
@section('title')
    <title>Información del componente</title>
@endsection

@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-10">
{{-- // mostramos mensaje --}}
@include('includes.message')

<div class="card pub_image_solo pub_image_detail">
<div class="card-header">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="data-user mr-auto">
            {{ $component->name}}

        @if (Auth::user() && Auth::user()->role == 'admin')
            <div class="actions ml-auto">
                <a href="{{ route('component.edit', ['id' => $component->id]) }}" class="btn btn-sm btn-warning">Actualizar</a>

                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal">
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
                                ¿Quiere borrar éste componente definitivamente?
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

<div class="card-body align-center">
    <div class="row  justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <img class="mw-100" src="{{ route('component.file', ['filename' => $component->image_path]) }}" alt="">
        </div>
    </div>

    <div class="name_component">
        <p>
            <strong>{{ $component->name }}</strong>
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
            <img src="{{ asset('img/facebook-like-64-gray.png') }}" alt="">
            <span class="number_likes">{{ count($component->likes) }}</span>

        @endif


            {{--        //pintamos el average--}}

        <div class="row justify-content-center mt-2">

            <div class="stars">
                {{--        //pintamos el average--}}

                <select id="stars-{{$component->id}}" class="stars">
                    <option value=""></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>

            </div>

        </div>
        <div class="row justify-content-center mb-2">
             <span>
                @if (\App\Helpers\RatingsHelper::ratingsQuantity($component->id) == 1)
                     <i id="vote-{{$component->id}}">{{ \App\Helpers\RatingsHelper::ratingsQuantity($component->id) }} valoración</i>
                 @else
                     <i id="vote-{{$component->id}}">{{ \App\Helpers\RatingsHelper::ratingsQuantity($component->id) }} valoraciones</i>
                 @endif
            </span>
        </div>
        @if ($ratingsQuantity == 0)
            <div class="row justify-content-center">
                <p>Sé el primero en valorar éste producto</p>
            </div>
        @endif


    </div>

    {{-- // descripción --}}
    <div class="clearfix"></div>
    <div class="description">
        <h2 >Descripción</h2>
        <hr>


        <hr>
            <div class="comment">

                <p>
                    {{ $component->description }} <br>

                </p>

            </div>
    </div>
    <hr>

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

<script>
    var componentId = '{{ $component->id }}';
    var averageRating = parseInt('{{\App\Helpers\RatingsHelper::getAverageForComponent($component->id)}}');
    var rated = '{{ $rated }}';

    // console.log(rated + 'votaciones');


    var userId = '{{ Auth::user()->id}}';
    var urlRatingStore = '{{route('rating.store')}}';

    // console.log(userId);
    // console.log(urlRatingStore);
</script>

<script src="{{asset('js/jsBarrating.js')}}"></script>
<script src="{{ asset('js/stars.js') }}"></script>



@endsection
