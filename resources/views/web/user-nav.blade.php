<select id="user-navigation" class="user-nav hide-for-medium">
    <option value="{{ url('/my-account') }}" @if ($page == 'profil') selected @endif>Profil</option>
    <option value="{{ url('/my-account/password') }}" @if ($page == 'password') selected @endif>Ubah Password</option>
    <option value="{{ url('/my-account/resep') }}" @if ($page == 'resepku') selected @endif>Resepku</option>
    <option value="{{ url('/my-account/kuliner') }}" @if ($page == 'kulinerku') selected @endif>Kulinerku</option>
</select>

<ul class="tabs show-for-medium">
    <li class="tabs-title @if ($page == 'profil') is-active @endif"><a href="{{ url('/my-account') }}">Profil</a></li>
    <li class="tabs-title @if ($page == 'password') is-active @endif"><a href="{{ url('/my-account/password') }}">Ubah Password</a></li>
    <li class="tabs-title @if ($page == 'resepku') is-active @endif"><a href="{{ url('/my-account/resep') }}">Resepku</a></li>
    <li class="tabs-title @if ($page == 'kulinerku') is-active @endif"><a href="{{ url('/my-account/kuliner') }}">Kulinerku</a></li>
</ul>