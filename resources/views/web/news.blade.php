@extends('web.base')

@section('pagemeta')
    <title>News | Dapur Keju Prochiz</title>

    <meta name="description" content="Berita Dapur Keju Prochiz">

    <meta property="og:url" content="{{ url('/news') }}" />
    <meta property="og:title" content="News | Dapur Keju Prochiz" />
    <meta property="og:description" content="Berita Dapur Keju Prochiz" />
    <meta property="og:image" content="{{ asset('assets/web/img/news-bg.jpg') }}" />
@endsection

@section('content')
    <div class="hero news">
        <div class="img-box">
            @if ($banner)
                <img src="{{ asset('storage/img/'.$banner->image) }}" alt="News">
            @else
                <img src="{{ asset('assets/web/img/news-bg.jpg') }}" alt="News">
            @endif
            <img class="text-img" src="{{ asset('assets/web/img/news-text.png') }}" alt="News">
        </div>
    </div>

    <div class="news-list">
        <ul class="infinite-container" data-baseurl="{{ url('/news?page=') }}" data-lastpage="{{ $news->lastPage() }}">
        @foreach($news as $value)
            <li class="infinite-item">
                <div class="row">
                    <div class="small-12 large-6 column">
                        <div class="img-box">
                            <a href="{{ url('/news/'.$value->slug) }}">
                                <img style="width: 100%;" src="{{ asset('storage/img/square/'.$value->image) }}" alt="{{ $value->title }}">
                            </a>
                        </div>
                    </div>
                    <div class="small-12 large-6 column">
                        <div class="text-box">
                            <a href="{{ url('/news/'.$value->slug) }}"><h2 class="title">{{ $value->title }}</h2></a>
                            <h3 class="date">{{ $value->published_at->format('d/m/Y') }}</h3>
                            <p>{{ $value->metadesc() }}</p>
                            <a class="text-img" href="{{ url('/news/'.$value->slug) }}"><img src="{{ asset('assets/web/img/read-more.png') }}"></a>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
        </ul>

        @if ($news->currentPage() < $news->lastPage())
            <div class="row">
                <div class="small-12 column text-center">
                    <a href="{{ $news->nextPageUrl() }}" class="invinite-btn"><img src="{{ asset('assets/web/img/invinite-btn.png') }}"></a>
                </div>
            </div>
        @endif
    </div>
@endsection