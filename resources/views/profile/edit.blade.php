@extends('layouts.layout')

@section('main')
@include('layouts.navbar')
<div class="d-flex justify-content-center">
    <div class="d-flex flex-column">
        <form id="form-edit" action="{{ route('editProfile.action', Auth::user()->id) }}" method="POST">
        @csrf
            <div class="d-flex align-items-center my-5">
            @if(Auth::user()->avatar == null)
                @include('profile.avatar')
            @else
                <img src="{{ url('storage/avatar/' . Auth::user()->avatar) }}" style="width: 80px; height: 80px;" class="rounded-circle" alt="">
            @endif
                <div class="mx-5">
                    <input type="file" name="avatar" id="avatar" hidden>
                    <label for="avatar" class="text-white rounded" style="background-color: #1D9BF0; font-weight: 500; padding: 0.4rem 1.5rem; cursor: pointer;"> Change profile </label>
                </div>
            </div>
            <div>
                <div class="form-group">
                    <label for="username"> Username : </label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="{{ Auth::user()->username }}">
                </div>
                <div class="form-group">
                    <label for="name"> Name : </label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Name" value="{{ Auth::user()->name }}">
                </div>
                <div class="form-group">
                    <label for="bio"> Bio : </label>
                    <textarea name="bio" id="bio" class="form-control" placeholder="Bio">{{ Auth::user()->bio }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn text-white mt-3" style="font-weight: 500; background-color: #1D9BF0; width: 60vh;">Save</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        function editProfile(e) {
            e.preventDefault();
            
            $.ajax({
                type: 'POST',
                url: $('#form-edit').attr('action'),
                data: new FormData(this),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        title: response.message,
                        icon: 'success',
                    }).then(() => window.location.href = '/profile')
                },
                error: function(err) {
                    Swal.fire({
                        title: err.responseJSON.message,
                        icon: 'error'
                    })
                }
            })
        }

        $('#form-edit').on('submit', editProfile)
    })
</script>
@endsection