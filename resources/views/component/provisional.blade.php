{{--@extends('layouts.app')--}}

{{--@section('title')--}}
{{--    <title>Resultados de la búsqueda</title>--}}
{{--@endsection--}}

{{--@section('content')--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            <h3>Componentes coincidentes con la búsqueda: "{{ $search }}"</h3>--}}
{{--            <table class="table table-striped">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th scope="col">Producto</th>--}}
{{--                    <th scope="col"></th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @foreach ($components as $component)--}}
{{--                    <tr>--}}
{{--                        <th scope="row">{{ $component->name }}</th>--}}
{{--                        <td>--}}
{{--                            <a href="{{ route('component.detail', ['id' => $component->id]) }}" class="btn btn-sm btn-warning">Ver</a>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--            --}}{{-- // añadimos enlaces de paginacion --}}
{{--        </div>--}}
{{--        <div class="row justify-content-center">--}}
{{--            --}}{{--            {{ $articles->links() }}--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    --}}{{--    </div>--}}

{{--    --}}{{--    </div>--}}

{{--    --}}{{--    </div>--}}
{{--@endsection--}}
