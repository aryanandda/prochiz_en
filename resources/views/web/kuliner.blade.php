@extends('web.base')

@section('pagemeta')
    <title>Kuliner | Dapur Keju Prochiz</title>

    <meta name="description" content="Keju adalah makanan yang terbuat dari susu yang diproduksi ke dalam berbagai macam rasa, tekstur, dan bentuk. Keju memiliki hampir semua kandungan nutrisi pada susu, seperti protein, vitamin, mineral, kalsium, fosfor, lemak dan kolesterol. Salah satu jenis keju yang paling populer, termasuk di Indonesia adalah keju cheddar. Keju ini termasuk ke dalam jenis keju keras. Pada umumnya, keju cheddar digunakan sebagai bahan dasar utama untuk membuat kue dan makanan.">

    <meta property="og:url" content="{{ url('/kuliner') }}" />
    <meta property="og:title" content="Kuliner | Dapur Keju Prochiz" />
    <meta property="og:description" content="Keju adalah makanan yang terbuat dari susu yang diproduksi ke dalam berbagai macam rasa, tekstur, dan bentuk. Keju memiliki hampir semua kandungan nutrisi pada susu, seperti protein, vitamin, mineral, kalsium, fosfor, lemak dan kolesterol. Salah satu jenis keju yang paling populer, termasuk di Indonesia adalah keju cheddar. Keju ini termasuk ke dalam jenis keju keras. Pada umumnya, keju cheddar digunakan sebagai bahan dasar utama untuk membuat kue dan makanan." />
    <meta property="og:image" content="{{ asset('assets/web/img/kuliner-bg.jpg') }}" />
@endsection

@section('content')

    <div class="hero resep-page">
        <div class="img-box">
        @if ($banner)
            <img src="{{ asset('storage/img/'.$banner->image) }}" alt="Kuliner">
        @else
            <img src="{{ asset('assets/web/img/kuliner-bg.jpg') }}" alt="Kuliner">
        @endif
        </div>
    </div>

    @if ($partners->count() > 0)
        <div class="kuliner-list">
            <div class="expanded row">
            @foreach($partners as $value)
                <div class="small-12 medium-6 large-3 column kuliner-card-container">
                    <div class="kuliner-card">
                        @if($value->image != '')
                            <div class="img-box">
                                <img src="{{ asset('storage/kuliner/square/'.$value->image) }}" alt="{{ $value->name }}">
                            </div>
                        @endif

                        <div class="text-box">
                            <h2 class="title">{{ $value->name }}</h2>
                            <p>{{ $value->address }}</p>
                        </div>
                        <a href="{{ url('/kuliner/'.$value->id.'/'.$value->slug) }}" class="block-link"></a>
                    </div>
                </div>
            @endforeach
            </div>

            <div class="spacer"></div>

            <div class="expanded row">
                <div class="small-12 column text-center">
                    {{ $partners->links() }}
                </div>
            </div>

            <div class="spacer"></div>
        </div>
    @endif

    @if ($categories->count() > 0)
        <div class="title-page">
            <h2 class="text">PICK YOUR FAVORITE</h2>
        </div>

        <div class="spacer tall"></div>

        <div class="fav-list">
            <div class="expanded row">
            @foreach($categories as $value)   
                <div class="small-6 large-3 column">
                    <div class="fav-card">
                        @if($value->image != '')
                            <div class="img-box">
                                <img src="{{ asset('storage/kuliner/square/'.$value->image) }}">
                            </div>
                        @endif

                        <div class="text-box">
                            <h2 class="title">{{ $value->name }}</h2>
                        </div>
                        <a href="{{ url('/kuliner/kategori/'.$value->slug) }}" class="block-link"></a>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    @endif

@endsection