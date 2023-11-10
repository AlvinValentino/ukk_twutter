@extends('layouts.layout')

@section('main')
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="bg-white rounded d-flex justify-content-center" style="width: 40rem; height: 34rem; border: 2px solid #ddd;">
        <div class="d-flex flex-column align-items-center">
            <div class="mt-5 d-flex flex-column align-items-center">
                <img src="{{ url('assets/twitter.png') }}" style="width: 60px; height: 50px;" class="" alt="">
                <p class="h4 mt-4 ml-2">Sign in to Twutter</p>
            </div>
            <form id="form-login" class="d-flex flex-column align-items-center" style="margin-top: 40px;" method="POST" action="{{ route('auth.loginAction') }}" method="POST">
            @csrf
                <div class="form-group" style="width: 30rem;">
                    <label for="email"> Email : </label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="name@xyz.com">
                </div>
                <div class="form-group mb-3" style="width: 30rem;">
                    <label for="password"> Password : </label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                </div>
                <button type="submit" class="btn mt-4 text-white" style="font-weight: 500; width: 30rem; height: 2.5rem; background-color: #1D9BF0;">Login</button>
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
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        title: response.message,
                        icon: 'success',
                    }).then(() => window.location.href = '/home')
                },
                error: function(err) {
                    Swal.fire({
                        title: err.responseJSON.message,
                        icon: 'error'
                    })
                }

            })
        }

        $('#form-login').on('submit', submitData)
    })
</script>
@endsection
