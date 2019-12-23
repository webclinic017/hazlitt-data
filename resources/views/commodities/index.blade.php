@extends('layouts.app')
@section('content')
<div class="text-red-600">
    This is the {!! $commodity->name !!} commodities page
    {!! foreach($commodity->articles as $article) !!}
        {!! $article->headline !!}
    {!! endforeach !!}

</div>
@endsection