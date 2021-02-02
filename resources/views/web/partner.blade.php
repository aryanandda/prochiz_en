@extends('web.base')

@section('pagemeta')
    <title>Partner | Dapur Keju Prochiz</title>

    <meta name="description" content="Keju adalah makanan yang terbuat dari susu yang diproduksi ke dalam berbagai macam rasa, tekstur, dan bentuk. Keju memiliki hampir semua kandungan nutrisi pada susu, seperti protein, vitamin, mineral, kalsium, fosfor, lemak dan kolesterol. Salah satu jenis keju yang paling populer, termasuk di Indonesia adalah keju cheddar. Keju ini termasuk ke dalam jenis keju keras. Pada umumnya, keju cheddar digunakan sebagai bahan dasar utama untuk membuat kue dan makanan.">

    <meta property="og:url" content="{{ url('/partner') }}" />
    <meta property="og:title" content="Partner | Dapur Keju Prochiz" />
    <meta property="og:description" content="Keju adalah makanan yang terbuat dari susu yang diproduksi ke dalam berbagai macam rasa, tekstur, dan bentuk. Keju memiliki hampir semua kandungan nutrisi pada susu, seperti protein, vitamin, mineral, kalsium, fosfor, lemak dan kolesterol. Salah satu jenis keju yang paling populer, termasuk di Indonesia adalah keju cheddar. Keju ini termasuk ke dalam jenis keju keras. Pada umumnya, keju cheddar digunakan sebagai bahan dasar utama untuk membuat kue dan makanan." />
    <meta property="og:image" content="{{ asset('assets/web/img/slide-3.jpg') }}" />
@endsection


@section('content')
    <div class="partner">
        <div class="partner-cage">
            <div class="partner-box">
                <div class="add-bg"></div>
                <div class="spacer giant"></div>
                <div class="spacer giant show-for-large"></div>
                <div class="spacer giant show-for-large"></div>
                <div class="text-box text-center">
                    <h2 class="title">Deskripsi Partner</h2>
                    <p class="text-justify">Partner Prochiz adalah para konsumen Prochiz yang menggunakan Prochiz untuk kebutuhan bisnis mereka. Dengan berbagai variasi keju yang kami miliki, banyak bakery, café maupun restaurant yang telah menggunakan Prochiz dalam makanan yang mereka jual.</p>
                </div>
                <div class="spacer giant"></div>
                <div class="spacer giant show-for-large"></div>
                <div class="text-box text-center">
                    <h2 class="title">Keuntungan menjadi Partner</h2>
                    <ul class="text-justify">
                        <li>Dengan menjadi Partner, anda dapat mempromosikan usaha HOREKA milik anda melalui website dapurkejuprochiz tanpa dipungut biaya</li>
                        <li>Dengan menjadi Partner, profil bakery anda akan ditampilkan di website kami dan dapat meningkatkan penjualan</li>
                        <li>Dengan menjadi Partner, anda dapat menampilkan menu apa saja yang ada di outlet anda sehingga dapat menarik calon pembeli</li>
                    </ul>
                </div>
                <div class="spacer giant"></div>
                <div class="spacer giant show-for-large"></div>
                <div class="text-box text-center">
                    <h2 class="title">Syarat &amp; Ketentuan menjadi Partner</h2>
                    <ul class="text-justify">
                        <li>Calon Partner memiliki jenis usaha dibidang HOREKA ( Bakery, Restaurant, Café )</li>
                        <li>Calon Partner harus melakukan registrasi di website dapurkejuprochiz sehingga dapat mendaftarkan usahanya di website dapurkejuprochiz</li>
                        <li>Calon Partner harus menggunakan Prochiz pada produk yang dijualnya</li>
                        <li>Calon Partner harus mengisi data lengkap di kolom pendaftaran yang ada di website dapurkejuprochiz</li>
                        <li>Calon Partner bersedia untuk divisit oleh team Prochiz untuk diverifikasi sebelum Profilnya ditayangkan di website dapurkejuprochiz</li>
                    </ul>
                </div>
                <div class="spacer giant"></div>

                <div class="text-box text-center">
                    <a href="{{ url('/partner/register') }}" class="button large expanded alert partner-btn">Registrasi Partner</a>
                </div>

                <div class="spacer giant"></div>
                <div class="spacer giant show-for-large"></div>
            </div>
        </div>
    </div>
@endsection