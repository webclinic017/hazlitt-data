@extends('layouts.app')
@section('content')

<div class="flex">
    {!! $chart->container() !!}
    {!! $chart->script() !!}
</div>

@endsection