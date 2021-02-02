@extends('web.base')

@section('pagemeta')
    <?php
        $category_name = ($category->name == 'Snack') ? 'Cemilan' : $category->name;
        $title = (isset($footer_text)) ? $footer_text->title . ' | Dapur Keju Prochiz' : 'Resep ' . $category_name . ' ' . ucfirst($type) . ' | Dapur Keju Prochiz'; 
        $metadesc = (isset($footer_text)) ? $footer_text->metadesc() : 'All Recipes ' . $category_name . ' ' . ucfirst($type) . ' from Dapur Keju Prochiz';
    ?>
    
    <title>{{ $title }}</title>

    <meta name="description" content="{{ $metadesc }}">

    <meta property="og:url" content="{{ url('/resep/'.$type.'/kategori/'.$slug) }}" />
    <meta property="og:title" content="{{ $title }}" />
    <meta property="og:description" content="{{ $metadesc }}" />
    <meta property="og:image" content="{{ asset('assets/web/img/resep-hero-1.jpg') }}" />
@endsection

@section('content')
    <div class="hero resep-page">
        <div class="img-box">
        @if ($banner)
            <img src="{{ asset('storage/img/'.$banner->image) }}" alt="Resep {{ ucfirst($type) }} {{ $category->name }}">
        @else
            <img src="{{ asset('assets/web/img/resep-hero-1.jpg') }}" alt="All Recipes {{ ucfirst($type) }}">
        @endif
        </div>
    </div>

    <div class="title-page">
        <div class="resep-filter">
            <ul class="menu small-text-center">
                <li class="filter">
                    <a href="{{ url('/resep/'.$type) }}">
                        <img class="show-for-medium" src="{{ asset('assets/web/img/all-recipe-icon-active.png?v=1') }}">
                        <img class="active-img show-for-medium" src="{{ asset('assets/web/img/all-recipe-icon-default.png?v=1') }}">
                        <span class="hide-for-medium">All Recipes</span>
                    </a>
                </li>
                <li class="connector show-for-large"><hr class=""></li>
                <li class="filter <?php if ($slug == 'sarapan') echo 'active'; ?>">
                    <a href="{{ url('/resep/'.$type.'/kategori/sarapan') }}">
                        <img class="show-for-medium" src="{{ asset('assets/web/img/sarapan-icon-active.png?v=1') }}">
                        <img class="active-img show-for-medium" src="{{ asset('assets/web/img/sarapan-icon-default.png?v=1') }}">
                        <span class="hide-for-medium">Breakfast</span>
                    </a>
                </li>
                <li class="connector show-for-large"><hr class=""></li>
                <li class="filter <?php if ($slug == 'makan-siang') echo 'active'; ?>">
                    <a href="{{ url('/resep/'.$type.'/kategori/makan-siang') }}">
                        <img class="show-for-medium" src="{{ asset('assets/web/img/makan-siang-icon-active.png?v=1') }}">
                        <img class="active-img show-for-medium" src="{{ asset('assets/web/img/makan-siang-icon-default.png?v=2') }}">
                        <span class="hide-for-medium">Lunch</span>
                    </a>
                </li>
                <li class="connector show-for-large"><hr class=""></li>
                <li class="filter <?php if ($slug == 'makan-malam') echo 'active'; ?>">
                    <a href="{{ url('/resep/'.$type.'/kategori/makan-malam') }}">
                        <img class="show-for-medium" src="{{ asset('assets/web/img/makan-malam-icon-active.png?v=1') }}">
                        <img class="active-img show-for-medium" src="{{ asset('assets/web/img/makan-malam-icon-default.png?v=1') }}">
                        <span class="hide-for-medium">Dinner</span>
                    </a>
                </li>
                <li class="connector show-for-large"><hr class=""></li>
                <li class="filter <?php if ($slug == 'snack') echo 'active'; ?>">
                    <a href="{{ url('/resep/'.$type.'/kategori/snack') }}">
                        <img class="show-for-medium" src="{{ asset('assets/web/img/snack-icon-default.png?v=1') }}">
                        <img class="active-img show-for-medium" src="{{ asset('assets/web/img/snack-icon-active.png?v=1') }}">
                        <span class="hide-for-medium">Snack</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="resep-full-list">
        <div class="row infinite-container" data-baseurl="{{ url('/resep/'.$type.'?page=') }}" data-lastpage="{{ $recipes->lastPage() }}">
        @foreach($recipes as $value)
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

    @if ($recipes->currentPage() < $recipes->lastPage())
        <div class="row">
            <div class="small-12 column text-center">
                <a href="{{ $recipes->nextPageUrl() }}" class="invinite-btn"><img src="{{ asset('assets/web/img/invinite-btn.png') }}"></a>
            </div>
        </div>
    @endif
@endsection