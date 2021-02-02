@extends('web.base')

@section('pagemeta')
    <title>{{ $recipe->name }} | Dapur Keju Prochiz</title>

    <meta name="description" content="{{ $recipe->metadesc() }}">

    <meta property="og:url" content="{{ url('/resep/'.$recipe->type.'/'.$recipe->id.'/'.$recipe->slug) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $recipe->name }} | Dapur Keju Prochiz" />
    <meta property="og:description" content="{{ $recipe->metadesc() }}" />
    <meta property="og:image" content="{{ asset('storage/img/'.$recipe->image) }}" />
@endsection

@section('content')
    
    @if ($type == 'prochiz')
        <div class="hero resep-detail-page">
            <div class="img-box">
                <img class="show-for-medium" style="width: 100%;" src="{{ asset('storage/img/'.$recipe->image) }}" alt="{{ $recipe->name }}">
                <img class="hide-for-medium" style="width: 100%;" src="{{ asset('storage/img/square/'.$recipe->image) }}" alt="{{ $recipe->name }}">
            </div>
        </div>

        <div class="row table-layout">
            <div class="small-12 column text-center">
                <div class="table-status">
                    <div class="table-item">
                        <div class="img-box">
                            <img src="{{ asset('assets/web/img/time-icon.png') }}">
                        </div>
                        <div class="text-box">
                            {{ $recipe->time }} <span>minutes</span>
                        </div>
                    </div>
                    <div class="table-item">
                        <div class="img-box">
                            <img src="{{ asset('assets/web/img/food-icon.png') }}">
                        </div>
                        <div class="text-box">
                            {{ $recipe->servings }} <span>portion</span>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    @elseif ($type == 'prochizlover')
        <div class="hero resep-detail-page prochizlover-img">
            <div class="prochizlover-img-bg show-for-medium"></div>

            <div class="row align-center">
                <div class="small-12 medium-7 large-5 column">
                    <div class="img-box">
                        <img style="width: 100%;" src="{{ asset('storage/img/square/'.$recipe->image) }}" alt="{{ $recipe->name }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="spacer tall"></div>
    @endif

    <div class="resep-title row align-center">
        <div class="small-12 large-8 column">
            <h1 class="text-center text">{{ $recipe->name }}</h1>
            <div class="spacer short"></div> 
            @if ($recipe->type == 'prochiz')
                <div class="resep-author text-center">by : {{ ($recipe->chef) ? $recipe->chef : 'Prochiz' }}</div>
            @else
                <div class="resep-author text-center">by : {{ $recipe->user->name }}</div>
            @endif
            <div class="spacer "></div> 
        </div>

        <div class="small-12 large-8 column text-box box-detail-content">
            <div class="share-btns">
                <div class="share-btn">
                    <div class="fb-share-button" data-href="{{ url('/resep/'.$recipe->type.'/'.$recipe->id.'/'.$recipe->slug) }}" data-layout="button" data-size="large" data-mobile-iframe="true"></div>
                </div>

                <div class="share-btn">
                    <a class="twitter-share-button"
                        href="https://twitter.com/share"
                        data-size="large"
                        data-text="{{ $recipe->name }} | Dapur Keju Prochiz"
                        data-url="{{ url('/resep/'.$recipe->type.'/'.$recipe->id.'/'.$recipe->slug) }}">
                    </a>
                </div>
            </div>
            
            {!! $recipe->description !!}
        </div>
    </div>

    <div class="resep-detail">
        <div class="row align-center">
            <div class="small-12 large-8 column">
                <div class="row">
                    <div class="small-12 medium-6 column text-right">
                        <div class="text-left">
                            <div class="title">
                                <span>Ingredients</span>
                            </div>
                            <ul class="list-bahan">
                                @foreach ($recipe->ingredients as $value)
                                    <li>{{ $value->amount }} {{ $value->name }}</li>
                                @endforeach
                            </ul>
                        </div>  
                    </div>
                        
                    <div class="small-12 medium-6 column">
                        <div class="title">
                            <span>How To</span>
                        </div>
                        <ol class="list-cara">
                            @foreach ($recipe->directions as $value)
                                <li>{{ $value->name }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>    
            </div>
        </div>
    </div>

    @if ($related->count() > 0)
        <div class="title-page">
            <h2 class="text">RELATED RECIPES</h2>
        </div>

        <div class="resep-full-list">
            <div class="row">
            @foreach($related as $value)
                <div class="small-12 medium-6 large-3 column infinite-item">
                    <div class="resep-card user">
                        <div class="img-box">
                            <img style="width: 100%;" src="{{ asset('storage/img/square/'.$value->image) }}" alt="{{ $value->name }}">
                            <img class="ribon" src="{{ asset('assets/web/img/'.$value->category->slug.'-ribbon.png?v=1') }}">
                        </div>
                        <div class="text-box text-center">
                            <h3 class="title">{{ $value->name }}</h3>
                            
                            @if ($value->type == 'prochiz')
                                <span>by : {{ ($value->chef) ? $value->chef : 'Prochiz' }}</span>
                            @else
                                <span>by : {{ $value->user->name }}</span>
                            @endif
                        </div>
                        <a href="{{ url('/resep/'.$value->type.'/'.$value->id.'/'.$value->slug) }}" class="block-link"></a>
                    </div>
                </div>  
            @endforeach
            </div>
        </div>
    @endif
@endsection