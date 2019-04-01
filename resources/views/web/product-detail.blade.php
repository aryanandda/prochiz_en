@extends('web.base')

@section('pagemeta')
    <title>{{ $product->name }} - {{ $product->tagline }} | Dapur Keju Prochiz</title>

    <meta name="description" content="{{ $product->metadesc() }}">

    <meta property="og:url" content="{{ url('/produk/'.$product->slug) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $product->name }} - {{ $product->tagline }} | Dapur Keju Prochiz" />
    <meta property="og:description" content="{{ $product->metadesc() }}" />
    <meta property="og:image" content="{{ asset('storage/img/'.$product->image) }}" />
@endsection

@section('content')
    <div class="hero produk">
        <div class="img-box">
            <img src="{{ asset('assets/web/img/produk-text.png') }}">

            <div class="spacer tall hide-for-large"></div>
        </div>

        <ul class="menu show-for-medium">
        @foreach ($products as $value)
            <li @if ($slug == $value->slug) class="active" @endif>
                <a href="{{ url('/produk/'.$value->slug) }}">
                    <img src="{{ asset('storage/img/'.$value->image) }}" alt="{{ $value->name }}">
                    <span>{{ $value->name }}</span>
                </a>
            </li>
        @endforeach
        </ul>

        <div class="row hide-for-medium">
            <div class="small-12 column">
                <select id="product-selection">
                @foreach ($products as $value)
                    <option value="{{ url('/produk/'.$value->slug) }}" @if ($slug == $value->slug) selected @endif>{{ $value->name }}</option>
                @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="produk-detail">
        <div class="produk-detail-cage">
            <div class="expanded row align-middle">
                <div class="small-12 large-6 column">
                    <div class="img-box">
                        <img src="{{ asset('storage/img/'.$product->image) }}" alt="{{ $product->name }}">
                    </div>
                </div>
                <div class="small-12 large-6 column">
                    <div class="text-box text-center">
                        <h1 class="title-produk">{{ $product->tagline }}</h1>
                        <div>{!! $product->description !!}</div>
                    </div>
                </div>
            </div>
            <div class="expanded row">
                <div class="small-12 column"><hr/></div>
            </div>
            <div class="expanded row">
                <div class="small-12 large-4 column resep-detail">
                    <h3 class="title">&nbsp;BAHAN</h3>
                    <p>{{ $product->ingredients }}</p>
                </div>
                <div class="small-12 large-4 column resep-detail">
                    <h3 class="title">&nbsp;KARAKTERISTIK</h3>
                    <p>{{ $product->characteristics }}</p>
                </div>
                <div class="small-12 large-4 column resep-detail">
                    <h3 class="title">&nbsp;SIZE</h3>
                    <p>{{ $product->size }}</p>

                    <h3 class="title">&nbsp;STORAGE</h3>
                    <p>{{ $product->storage }}</p>
                </div>
            </div>  
        </div>
        
    </div>

    @if ($recipes->count() > 0)
        <div class="title-page">
            <h3 class="text">RESEP TERKAIT {{ strtoupper($product->name) }}</h3>
        </div>

        <div class="spacer"></div>

        <div class="produkresep-detail">
            <div class="img-box">
                <img src="{{ asset('storage/img/'.$product->image) }}" alt="{{ $product->name }}">
                <span>{{ $product->name }}</span>
            </div>
        </div>

        <div class="resep-full-list">
            <div class="row infinite-container" data-baseurl="{{ url('/produk/'.$product->slug.'?page=') }}" data-lastpage="{{ $recipes->lastPage() }}">
            @foreach($recipes as $value)
                <div class="small-12 medium-6 large-3 column infinite-item">
                    <div class="resep-card user">
                        <div class="img-box">
                            <img style="width: 100%;" src="{{ asset('storage/img/square/'.$value->image) }}" alt="{{ $value->name }}">
                            <img class="ribon" src="{{ asset('assets/web/img/'.$value->category->slug.'-ribon.png') }}">
                        </div>
                        <div class="text-box text-center">
                            <h3 class="title">{{ $value->name }}</h3>
                            
                            @if ($value->type == 'prochiz')
                                <span>oleh : {{ ($value->chef) ? $value->chef : 'Prochiz' }}</span>
                            @else
                                <span>oleh : {{ $value->user->name }}</span>
                            @endif
                        </div>
                        <a href="{{ url('/resep/'.$value->type.'/'.$value->id.'/'.$value->slug) }}" class="block-link"></a>
                    </div>
                </div>  
            @endforeach
            </div>
        </div>

        @if ($recipes->currentPage() < $recipes->lastPage())
            <div class="row">
                <div class="small-12 column text-center">
                    <a href="{{ $recipes->nextPageUrl() }}" class="invinite-btn"><img src="{{ asset('assets/web/img/invinite-btn.png') }}"></a>
                </div>
            </div>
        @endif
    @endif
@endsection

@section('scripts')
    <script>
        $('#product-selection').on('change', function(){
            window.location.href = $(this).val();
        });
    </script>
@endsection