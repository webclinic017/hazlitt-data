@extends('layouts.app')
@section('content')
<div>
    <h1 class="text-2xl">{!! $commodity->name !!}</h1>

    @foreach ($commodity->articles as $article)
        <p>{!! $article->headline !!}</p>
    @endforeach
</div>
@endsection