@extends('layouts.app')
@section('content')
<div class="flex">
    <div class="w-1/2">
        <h2 class="text-3xl text-gray-100">{!! $commodity->name !!}</h2>
        <h3 class="text-2xl text-gray-100 text-gold">${!! $commodity->spot !!}</h3>

        <div class="prices-chart flex">
            {!! $chart->container() !!}
            {!! $chart->script() !!}
        </div>
    </div>
    <div class="item-news bg-dark-opacity rounded w-1/2 text-gray-100 overflow-y-scroll overflow-hidden">
        <h3 class="text-gold px-2">News</h3>
        <div class="rounded alternating-row">
            @foreach ($commodity->articles as $article)
            <div class="row-item py-3 px-2">
                <a href="{!! $article->url !!}" rel="nofollow" target="_blank">
                    <div class="flex justify-between">
                        <p class="source opacity-50 text-xs text-gold rounded p-1 italic">{!! $article->source !!}</p>
                        <p class="date opacity-50 text-xs text-gold rounded p-1 italic">
                            {{-- {!! $carbon->createFromFormat('', $article->published) !!} --}}
                        </p>
                        <p class="date opacity-50 text-xs text-gold rounded p-1 italic">
                            {!! $article->published !!}
                        </p>
                    </div>
                    <p class="headline text-gray-100 text-xs whitespace-no-wrap overflow-hidden px-1">
                        {!! $article->headline !!}
                    </p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection