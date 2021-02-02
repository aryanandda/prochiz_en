@component('mail::message')

Hai {{ $name }},<br>

@if ($recipe->status == 'pending')
    
{{ $title }}.<br>

Resep Anda saat ini sedang menunggu persetujuan dari Kami terlebih dahulu sebelum dapat ditampilkan di website dapurkejuprochiz.com.<br>

Anda dapat melihat status dari resep Anda dengan mengeklik link di bawah ini :

@component('mail::button', ['url' => url('/my-account/resep'), 'color' => 'orange'])
Lihat Status Resep Anda
@endcomponent

@elseif ($recipe->status == 'approved')

{{ $title }}.<br>

Anda dapat melihat resep Anda dengan mengeklik link di bawah ini :

@component('mail::button', ['url' => url('/resep/prochizlover/'.$recipe->id.'/'.$recipe->slug), 'color' => 'orange'])
Lihat Resep Anda
@endcomponent

@elseif ($recipe->status == 'rejected')

{{ $title }}.<br>

Anda tetap dapat mengupload resep Anda yang lain, tetapi pastikan sesuai dengan syarat dan ketentuan agar resep Anda bisa kami terima.

@component('mail::button', ['url' => url('/page/syarat-ketentuan'), 'color' => 'orange'])
Lihat Syarat dan Ketentuan
@endcomponent

@endif

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
