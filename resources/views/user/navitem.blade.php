<div class="card text-center">
  <div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('user/dashboard') ? 'active' : '' }}" href={{route('dashboard')}}>Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('user/myorder/*') || Request::is('user/myorder') ? 'active' : '' }}" href="{{route('myorder.all')}}">My Order</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('user/passbook') ? 'active' : '' }}" href="{{route('passbook')}}">Passbook</a>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('user/profile') ? 'active' : '' }}" href="{{route('profile')}}">Profile</a>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('user/sell/*') || Request::is('user/sell')? 'active' : '' }}" href="{{route('sell')}}">sell</a>
      </li>
    </ul>
  </div>