@extends('layouts.layout')

@section('main')
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="bg-white rounded d-flex justify-content-center" style="width: 30%; height: 65%; border: 2px solid #ddd;">
        <div class="d-flex flex-column align-items-center">
            <div class="mt-5 d-flex flex-column align-items-center">
                <img src="{{ url('assets/twitter.png') }}" style="width: 60px; height: 50px;" class="" alt="">
                <p class="h4 mt-4 ml-2">Create your account</p>
            </div>
            <form class="d-flex flex-column align-items-center" style="margin-top: 90px;" method="POST" action="{{ route('auth.registerAction') }}">
            @csrf
                <div class="form-group" style="width: 40vh;">
                    <input type="email" name="email" class="form-control form-control-lg" placeholder="name@xyz.com">
                </div>
                <div class="form-group mt-3" style="width: 40vh;">
                    <input type="username" name="username" class="form-control form-control-lg" placeholder="Username">
                </div>
                <div class="form-group mt-3" style="width: 40vh;">
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password">
                </div>
                <button type="submit" class="btn mt-4 text-white font-weight-bold" style="width: 45vh; height: 5vh; background-color: #1D9BF0;">Register</button>
            </form>
            <p class="mt-2">Already have an account ? <a class="text-decoration-none" href="{{ route('auth.login') }}">Login</a></p>
        </div>
    </div>
</div>
@endsection