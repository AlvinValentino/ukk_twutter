<nav class="border-bottom">
    <div class="navbar navbar-expand-lg" style="margin: 0.2rem 5rem;">
        <a href="{{ route('home') }}">
            <div class="py-2">
                <img src="{{ url('assets/twitter.png') }}" style="width: 40px;" alt="">
                <a href="{{ route('home') }}" class="navbar-brand font-weight-bold ml-2 text-dark">Twutter</a>
            </div>
        </a>
        <div class="collapse navbar-collapse d-flex justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item my-auto" style="margin: 0 5rem;">
                    <a class="nav-link text-dark {{ $title == 'Home Page' ? 'font-weight-bold' : '' }}" href="/home"> Home </a>
                </li>
                <li class="nav-item my-auto">
                    <a class="nav-link text-dark {{ $title == 'Profile Page' ? 'font-weight-bold' : '' }}" href="/profile"> Profile </a>
                </li>
                <li class="nav-item my-auto" style="margin: 0 5rem;">
                    <a class="nav-link text-dark {{ $title == 'Explore Page' ? 'font-weight-bold' : '' }}" href="/explore"> Explore </a>
                </li>
                <li class="nav-item my-auto" style="cursor: pointer;" id="logout">
                    <a class="nav-link text-dark main-logout"> Logout </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    $(document).ready(function() {
        function logout() {
            $.ajax({
                type: 'GET',
                url: "{{ route('auth.logout') }}",
                success: function(response) {
                    Swal.fire({
                        title: response.message,
                        icon: 'success',
                    }).then(() => window.location.href = '/')
                },
                error: function(err) {
                    Swal.fire({
                        title: err.responseJSON.message,
                        icon: 'error'
                    })
                }
            })
        }

        $('.main-logout').on('click', logout)
    })
</script>
