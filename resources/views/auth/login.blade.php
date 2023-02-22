@extends('layouts.layout')

@section('main')
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="bg-white rounded d-flex justify-content-center" style="width: 30%; height: 65%; border: 2px solid #ddd;">
        <div class="d-flex flex-column align-items-center">
            <div class="mt-5 d-flex flex-column align-items-center">
                <img src="{{ url('assets/twitter.png') }}" style="width: 60px; height: 50px;" class="" alt="">
                <p class="h4 mt-4 ml-2">Sign in to Twutter</p>
            </div>
            <form id="form-login" class="d-flex flex-column align-items-center" style="margin-top: 90px;" method="POST" action="{{ route('auth.loginAction') }}" method="POST">
            @csrf
                <div class="form-group" style="width: 40vh;">
                    <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="name@xyz.com">
                </div>
                <div class="form-group mt-3" style="width: 40vh;">
                    <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Password">
                </div>
                <button type="submit" class="btn mt-4 text-white font-weight-bold" style="width: 45vh; height: 5vh; background-color: #1D9BF0;">Login</button>
            </form>
            <p class="mt-2">Don't have an account ? <a class="text-decoration-none" href="{{ route('auth.register') }}">Register</a></p>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        function submitData(e) {
            e.preventDefault();
            
            $.ajax({
                type: 'POST',
                url: $('#form-login').attr('action'),
                data: new FormData(this),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                processData: false,
                contentType: false,
                success: function() {
                    window.location.href = '/home'
                },
                error: function(err) {
                    alert(err.responseJSON.error)
                    location.reload()
                }

            })
        }

        $('#form-login').on('submit', submitData)
    })
</script>
@endsection
