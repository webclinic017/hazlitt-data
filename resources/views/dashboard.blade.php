@extends('layouts.app')
@section('content')
<div class="topbar container">
    <div class="px-4 gold gothic-neo text-lg ml-8 mt-6">
        <div class="logo w-1/8 inline-block">
            @svg('graph-blend-filled', 'text-lg align-middle inline-block')
            <p class="align-middle inline-block">Hazlitt Data</p>
        </div>
    </div>
</div>
<div class="sidebar container">
    <div class="w-1/8 pt-8 ml-8">
        <a href="#" class="w-full flex py-6 px-4 gold gothic-neo text-lg">Dashboard</a>
        <a href="#" class="w-full flex py-6 px-4 text-gray-500 gothic-neo text-lg">Commodities</a>
        <a href="#" class="w-full flex py-6 px-4 text-gray-500 gothic-neo text-lg">Countries</a>
        <a href="#" class="w-full flex py-6 px-4 text-gray-500 gothic-neo text-lg">Stocks</a>
        <a href="#" class="w-full flex py-6 px-4 text-gray-500 gothic-neo text-lg">Research</a>
    </div>
</div>
@endsection