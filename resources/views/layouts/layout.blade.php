<!DOCTYPE html>
<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>{{ $title }}</title>
    </head>
    <body>
        <div class="d-flex justify-content-center mt-5">     
            @if(session()->has('success'))
                <div class="alert alert-success" style="width: 40vh;">{{ session('successs') }}</div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger" style="width: 40vh;">{{ session('error') }}</div>
            @endif
        </div>

        @yield('main')
    </body>
</html>