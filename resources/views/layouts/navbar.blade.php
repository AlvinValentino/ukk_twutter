<nav class="navbar navbar-expand-lg border-bottom">
  <a href="{{ route('home') }}">
  <div class="ml-5 py-2">
        <img src="{{ url('assets/twitter.png') }}" style="width: 40px;" alt="">
        <a href="{{ route('home') }}" class="navbar-brand font-weight-bold ml-2 text-dark">Twutter</a>
      </div>
    </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarSupportedContent">
    <ul class="navbar-nav mr-5">
      <li class="nav-item">
        <a class="nav-link text-dark {{ $title == 'Home Page' ? 'font-weight-bold' : '' }}" href="/home">Home</a>
      </li>
      <li class="nav-item ml-5">
        <a class="nav-link text-dark {{ $title == 'Profile Page' ? 'font-weight-bold' : '' }}" href="/profile">Profile</a>
      </li>
      <li class="nav-item ml-5">
        <a class="nav-link text-dark {{ $title == 'Explore Page' ? 'font-weight-bold' : '' }}" href="/explore">Explore</a>
      </li>
      <li class="nav-item ml-5">
        <form action="{{ route('auth.logout') }}" method="GET">
            @csrf
            <button class="bg-white border-0 nav-link text-dark" type="submit">Logout</button>
        </form>
      </li>
    </ul>
  </div>
</nav>
