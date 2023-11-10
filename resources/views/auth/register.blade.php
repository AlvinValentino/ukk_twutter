@extends('layouts.layout')

@section('main')
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="bg-white rounded d-flex justify-content-center" style="width: 40rem; height: 38rem; border: 2px solid #ddd;">
        <div class="d-flex flex-column align-items-center">
            <div class="mt-5 d-flex flex-column align-items-center">
                <img src="{{ url('assets/twitter.png') }}" style="width: 60px; height: 50px;" class="" alt="">
                <p class="h4 mt-4 ml-2">Create your account</p>
            </div>
            <form id="form-register" class="d-flex flex-column align-items-center" style="margin-top: 40px;" method="POST" action="{{ route('auth.registerAction') }}">
            @csrf
                <div class="form-group" style="width: 30rem;">
                    <label for="email"> Email : </label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="name@xyz.com">
                </div>
                <div class="form-group mb-3" style="width: 30rem;">
                    <label for="username"> Username : </label>
                    <input type="username" name="username" id="username" class="form-control" placeholder="Username">
                </div>
                <div class="form-group mb-3" style="width: 30rem;">
                    <label for="password"> Password : </label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                </div>
                <button type="submit" class="btn mt-4 text-white" style="font-weight: 500; width: 30rem; height: 2.5rem; background-color: #1D9BF0;">Register</button>
            </form>
            <p class="mt-2">Already have an account ? <a class="text-decoration-none" href="{{ route('auth.login') }}">Login</a></p>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        function submitData(e) {
            e.preventDefault();
            
            $.ajax({
                type: 'POST',
                url: $('#form-register').attr('action'),
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                success: function() {
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

        $('#form-register').on('submit', submitData)
    })
</script>
@endsection