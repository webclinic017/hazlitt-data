@extends('layouts.app')
@section('content')

<div class="topbar mx-8 py-8 w-1/4">
    <div class="gothic-neo px-4 text-gold text-lg">
        <div class="logo inline-block">
            @svg('graph-blend-filled', 'text-lg align-middle inline-block')
            <p class="align-middle inline-block aldrich text-2xl">Hazlitt Data</p>
        </div>
    </div>
</div>
<section class="main flex ml-8">
    <div class="sidebar w-1/6">
        <a href="#" class="w-full flex py-6 px-4 text-gold gothic-neo text-lg">Dashboard</a>
        <a href="#" class="w-full flex py-6 px-4 text-old-gray gothic-neo text-lg">Commodities</a>
        <a href="#" class="w-full flex py-6 px-4 text-old-gray gothic-neo text-lg">Countries</a>
        <a href="#" class="w-full flex py-6 px-4 text-old-gray gothic-neo text-lg">Stocks</a>
        <a href="#" class="w-full flex py-6 px-4 text-old-gray gothic-neo text-lg">Research</a>
    </div>
    <div class="content w-5/6 bg-dark-mode-light rounded-l-lg shadow-inner-dark">
        <div class="">
            <p>Content</p>
        </div>
    </div>
</section>
@endsection