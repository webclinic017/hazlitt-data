@extends('layouts.app')
@section('content')
<div class="text-red-600">
    This is the {!! $commodity->name !!} commodities page
    @foreach ($commodity->articles as $article)
    <p>{!! $article->headline !!}</p>
        
    @endforeach
    

</div>
@endsection