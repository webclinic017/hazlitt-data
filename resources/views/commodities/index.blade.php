@extends('layouts.app')
@section('content')
<h1 class="text-2xl text-gray-100">{!! $commodity->name !!}</h1>

<div class="bg-dark-mode-lighter w-1/2 rounded alternating-row">
    @foreach ($commodity->articles as $article)
    <div class="row-item p-2">
        <p class="text-gray-100 text-sm"><a href="{!! $article->url !!}">{!! $article->headline !!}</a></p>
    </div>
    @endforeach
</div>

@endsection