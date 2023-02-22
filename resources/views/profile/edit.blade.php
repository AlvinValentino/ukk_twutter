@extends('layouts.layout')
@extends('layouts.navbar')

@section('main')
<div class="d-flex justify-content-center">
    <div class="d-flex flex-column">
        <form id="form-edit" action="{{ route('editProfile.action', Auth::user()->id) }}" method="POST">
        @csrf
        <div class="d-flex align-items-center my-5">
        @if(Auth::user()->avatar == null)
            <span style="
            width:100px;
            height:100px;
            color:#fff;
            font-weight:700;
            font-size: 50px;
            text-transform:600;
            background-color:#5BC0F8;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;" 
            class="initial mt-1">{{ substr(Auth::user()->username, 0, 1) }}</span>
        @else
        <img src="{{ url('storage/avatar/' . Auth::user()->avatar) }}" style="width: 50px; height: 50px;" class="rounded-circle" alt="">
        @endif
            <input type="file" name="avatar" class="mx-3" value="{{ Auth::user()->avatar }}">
        </div>
            <div>
                <div class="form-group">
                    <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" value="{{ Auth::user()->username }}">
                </div>
                <div class="form-group">
                    <input type="text" name="name" class="form-control form-control-lg" placeholder="Name" value="{{ Auth::user()->name }}">
                </div>
                <div class="form-group">
                    <textarea name="bio" class="form-control form-control-lg" placeholder="Bio">{{ Auth::user()->bio }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn text-white font-weight-bold" style="background-color: #1D9BF0; width: 60vh;">Save</button>
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
                    window.location.href = '/profile';
                },
            })
        }

        $('#form-edit').on('submit', editProfile)
    })
</script>
@endsection