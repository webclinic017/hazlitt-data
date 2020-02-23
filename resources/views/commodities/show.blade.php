@extends('layouts.app')
@section('content')
<div class="flex">
    <div class="w-1/2">
        <h2 class="text-2xl text-gray-100">{!! $commodity->name !!}</h2>
    </div>
    <div class="item-news bg-dark-opacity rounded w-1/2 text-gray-100">
        <h3 class="text-gold px-2">News</h3>
        <div class="rounded alternating-row">
            @foreach ($commodity->articles as $article)
            <div class="row-item p-2">
                <a href="{!! $article->url !!}">
                    <p class="headline text-gray-100 text-xs w-full">
                        {!! $article->headline !!}
                    </p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection