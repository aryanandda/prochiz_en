@component('mail::message')

Hai {{ $name }},<br>

@if ($partner->status == 'pending')
    
{{ $title }}.<br>

Kuliner Anda saat ini sedang menunggu persetujuan dari Kami terlebih dahulu sebelum dapat ditampilkan di website dapurkejuprochiz.com.<br>

Anda dapat melihat status dari kuliner Anda dengan mengeklik link di bawah ini :

@component('mail::button', ['url' => url('/my-account/kuliner'), 'color' => 'orange'])
Lihat Status Kuliner Anda
@endcomponent

@elseif ($partner->status == 'approved')

{{ $title }}.<br>

Anda dapat melihat kuliner Anda dengan mengeklik link di bawah ini :

@component('mail::button', ['url' => url('/my-account/kuliner'), 'color' => 'orange'])
Lihat Kuliner Anda
@endcomponent

@elseif ($partner->status == 'rejected')

{{ $title }}.<br>

Anda tetap dapat mengupload kuliner Anda yang lain, tetapi pastikan sesuai dengan syarat dan ketentuan agar kuliner Anda bisa kami terima.

@component('mail::button', ['url' => url('/partner'), 'color' => 'orange'])
Lihat Syarat dan Ketentuan
@endcomponent

@endif

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
