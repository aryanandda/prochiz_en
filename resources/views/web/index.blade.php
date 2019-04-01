@extends('web.base')

@section('pagemeta')
    @if (isset($footer_text))
        <title>Dapur Keju Prochiz</title>

        <meta name="description" content="{{ $footer_text->metadesc() }}">

        <meta property="og:title" content="Dapur Keju Prochiz" />
        <meta property="og:description" content="{{ $footer_text->metadesc() }}" />
    @else
        <title>Dapur Keju Prochiz</title>

        <meta name="description" content="Keju adalah makanan yang terbuat dari susu yang diproduksi ke dalam berbagai macam rasa, tekstur, dan bentuk. Keju memiliki hampir semua kandungan nutrisi pada susu, seperti protein, vitamin, mineral, kalsium, fosfor, lemak dan kolesterol. Salah satu jenis keju yang paling populer, termasuk di Indonesia adalah keju cheddar. Keju ini termasuk ke dalam jenis keju keras. Pada umumnya, keju cheddar digunakan sebagai bahan dasar utama untuk membuat kue dan makanan.">

        <meta property="og:title" content="Dapur Keju Prochiz" />
        <meta property="og:description" content="Keju adalah makanan yang terbuat dari susu yang diproduksi ke dalam berbagai macam rasa, tekstur, dan bentuk. Keju memiliki hampir semua kandungan nutrisi pada susu, seperti protein, vitamin, mineral, kalsium, fosfor, lemak dan kolesterol. Salah satu jenis keju yang paling populer, termasuk di Indonesia adalah keju cheddar. Keju ini termasuk ke dalam jenis keju keras. Pada umumnya, keju cheddar digunakan sebagai bahan dasar utama untuk membuat kue dan makanan." />
    @endif

    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:image" content="{{ asset('assets/web/img/slide-3.jpg') }}" />
@endsection

@section('content')
    <div id="hero-index" class="hero index" style="height: 600px;">
        <div class="text-box">
            <img class="text" src="{{ asset('assets/web/img/kresikan-resepmu.png') }}">
            <p class="text-body"></p>
            <a class="cta" href="{{ url('upload-resep') }}"><img src="{{ asset('assets/web/img/upload-resep.png') }}"></a>
            <br/>  
            <a href="{{ url('page/syarat-ketentuan') }}" class="syarat">syarat dan ketentuan</a>  
        </div>  
    </div>

    <div class="resep-list">
        @if ($homebanner)
            <div class="row">
                <div class="small-12 column">
                    <a href="{{ $homebanner->url }}" class="homebanner">
                        <img src="{{ asset('storage/img/'.$homebanner->image) }}" alt="{{ $homebanner->caption }}">
                    </a>
                </div>
            </div>

            <div class="spacer giant"></div>
        @endif

        @if ($prochizlover_recipes->count() > 0)
            <div class="row align-middle">
                <div class="small-12 medium-6 large-8 column">
                    <h2 class="title-section resep-title small-text-center">{{ $prochizlover_recipes_title }}</h2>
                </div>
                <div class="medium-6 large-4 column text-right show-for-medium">
                    <a href="{{ $prochizlover_recipes_link }}" class="button lihat">lihat semua</a>
                </div>
            </div>
            
            <div class="spacer"></div>

            <div class="row">
            @foreach($prochizlover_recipes as $value)
                <div class="small-12 medium-6 large-3 column">
                    <div class="resep-card user">
                        <div class="img-box">
                            <img style="width: 100%;" src="{{ asset('storage/img/square/'.$value->image) }}" alt="{{ $value->name }}">
                            <img class="ribon" src="{{ asset('assets/web/img/'.$value->category->slug.'-ribon.png') }}">
                        </div>
                        <div class="text-box text-center">
                            <h3 class="title">{{ $value->name }}</h3>
                            
                            <span>oleh : {{ $value->user->name }}</span>
                        </div>
                        <a href="{{ url('/resep/'.$value->type.'/'.$value->id.'/'.$value->slug) }}" class="block-link"></a>
                    </div>
                </div> 
            @endforeach
            </div>

            <div class="spacer tall hide-for-medium"></div>
            
            <div class="small-12 column text-center hide-for-medium">
                <a href="{{ $prochizlover_recipes_link }}" class="button lihat">lihat semua</a>
            </div>

            <div class="spacer tall hide-for-medium"></div>
            <hr class="hide-for-medium" />
            <div class="spacer tall hide-for-medium"></div>
        
            <div class="spacer giant show-for-medium"></div>
        @endif

        <div class="expanded row align-middle">
            <div class="small-12 medium-6 column small-text-center">
                <h2 class="title-section resep-title">RESEP PROCHIZ</h2>
            </div>
            <div class="medium-6 column text-right show-for-medium">
                <a href="{{ url('resep/prochiz') }}" class="button lihat">lihat semua</a>
            </div>
        </div>
    </div>

    <div class="resep-list-pc">
        <div class="expanded row collapse">
        @foreach($prochiz_recipes as $value)
            <div class="small-12 medium-6 large-3 column">
                <div class="resep-card prochiz">
                    <div class="img-box">
                        <img style="width: 100%;" src="{{ asset('storage/img/square/'.$value->image) }}" alt="{{ $value->name }}">
                    </div>
                    <div class="text-box text-center">
                        <img class="ribon" src="{{ asset('assets/web/img/'.$value->category->slug.'-ribon.png') }}">
                        <h3 class="title">{{ $value->name }}</h3>
                        <span>oleh : {{ ($value->chef) ? $value->chef : 'Prochiz' }}</span>
                    </div>
                    <a href="{{ url('/resep/'.$value->type.'/'.$value->id.'/'.$value->slug) }}" class="block-link"></a>
                </div>
            </div>
        @endforeach
        </div>
    </div>

    <div class="tips-news">
        <div class="overlay"></div>

        <div class="row">
            <div class="small-12 large-6 column">
                <div class="pc-card text-center">
                    <div class="text-box">
                        <h3 class="title">TIPS &amp; TRICK</h3>
                    </div>

                    <div class="spacer tall"></div>

                    <ul class="tips-news-list">
                    @foreach($tips as $value)
                        <li class="tips-news-card">
                            <div class="row">
                                <div class="small-12 medium-4 column">
                                    <div class="img-box">
                                        <a href="{{ url('/tips/'.$value->slug) }}">
                                            <img style="width: 100%;" src="{{ asset('storage/img/square/'.$value->image) }}" alt="{{ $value->title }}">
                                        </a>
                                    </div>
                                </div>
                                <div class="small-12 medium-8 column text-left">
                                    <div class="text-box">
                                        <h4 class="title-card"><a href="{{ url('/tips/'.$value->slug) }}">{{ $value->title }}</a></h4>
                                        <p class="text-left">{{ $value->metadesc() }}</p>
                                        <a href="{{ url('/tips/'.$value->slug) }}" class="tips-news-readmore">read more</a>
                                    </div>        
                                </div>
                            </div>
                        </li>
                    @endforeach
                    </ul>

                    <div class="spacer tall"></div>
                    <a href="{{ url('/tips') }}" class="more-btn"><img src="{{ asset('assets/web/img/more-btn.png') }}"></a>
                    <div class="spacer tall"></div>
                    <hr class="hide-for-medium" />
                </div>
            </div>

            <div class="small-12 large-6 column">
                <div class="pc-card text-center">
                    <div class="text-box">
                        <h3 class="title">NEWS</h3>
                    </div>

                    <div class="spacer tall"></div>

                    <ul class="tips-news-list">
                    @foreach($news as $value)
                        <li class="tips-news-card">
                            <div class="row">
                                <div class="small-12 medium-4 column">
                                    <div class="img-box">
                                        <a href="{{ url('/news/'.$value->slug) }}">
                                            <img style="width: 100%;" src="{{ asset('storage/img/square/'.$value->image) }}" alt="{{ $value->title }}">
                                        </a>
                                    </div>
                                </div>
                                <div class="small-12 medium-8 column text-left">
                                    <div class="text-box">
                                        <h4 class="title-card"><a href="{{ url('/news/'.$value->slug) }}">{{ $value->title }}</a></h4>
                                        <p class="text-left">{{ $value->metadesc() }}</p>
                                        <a href="{{ url('/news/'.$value->slug) }}" class="tips-news-readmore">read more</a>
                                    </div>        
                                </div>
                            </div>
                        </li>
                    @endforeach
                    </ul>

                    <div class="spacer tall"></div>
                    <a href="{{ url('/news') }}" class="more-btn"><img src="{{ asset('assets/web/img/more-btn.png') }}"></a>
                    <div class="spacer tall"></div>
                    <hr class="hide-for-medium" />
                </div>
            </div>
        </div>
    </div>

    <div class="video">
        <div class="row align-middle">
            <div class="small-12 medium-6 column small-text-center">
                <h2 class="title-section resep-title">VIDEO</h2>
            </div>
            <div class="medium-6 column text-right show-for-medium">
                <a href="{{ url('/video') }}" class="button lihat">lihat semua</a>
            </div>
        </div>

        <div class="spacer"></div>

        <div class="row">
        @foreach($videos as $value)
            <div class="small-12 medium-6 column">
                <div class="video-card">
                    <div class="img-box">
                        <img style="width: 100%;" src="{{ asset('storage/img/'.$value->image) }}" alt="{{ $value->title }}">
                        <div class="overlay"></div>
                        <div class="play-icon">
                            <img src="{{ asset('assets/web/img/play-icon.png') }}">
                        </div>
                    </div>
                    <div class="text-box">
                        <h4 class="title">{{ $value->title }}</h4>
                    </div>
                    <a href="{{ url('/video/'.$value->slug) }}" class="block-link"></a>    
                </div>
            </div>

            <div class="spacer small-12 column hide-for-medium"></div>
        @endforeach
        </div>

        <div class="spacer hide-for-medium"></div>
        
        <div class="small-12 column text-center hide-for-medium">
            <a href="{{ url('video') }}" class="button lihat">lihat semua</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $("#hero-index").vegas({
            slides: [
            @foreach($sliders as $value)
                { src: "{{ asset('storage/img/'.$value->image) }}" },
            @endforeach
            ],
            transition: 'zoomOut',
            transitionDuration: 20000,
            loop: true,
            timer: false,
            delay: 10000
        });
    </script>
@endsection