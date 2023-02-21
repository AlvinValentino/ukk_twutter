@extends('layouts.layout')
@extends('layouts.navbar')

@section('main')
<div class="d-flex justify-content-center flex-column mt-5">
    <div class="d-flex justify-content-center">
        <div class="pb-5 border-bottom">
            <div class="d-flex align-items-center">
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
                    <img src="{{ url('storage/avatar/' . Auth::user()->avatar) }}" alt="" style="width: 100px; height: 100px;" class="rounded-circle">
                @endif
                <div class="ml-4 d-flex align-items-center">
                    <div class="mr-5">
                        <p class="h2">{{ Auth::user()->name }}</p>
                        <p class="h6">{{ '@' . Auth::user()->username }}</p>
                    </div>
                    <a href="{{ route('editProfile') }}" class="btn h-50" style=" margin-left: 15vh; border-radius: 15px; border: 2px solid #1D9BF0; color: #1D9BF0;">Edit Profile</a>
                </div>
            </div>
            <p class="h6 mt-5">{{ Auth::user()->bio }}</p>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div class="mt-3">
            <p class="h4 d-flex justify-content-center">Tweets</p>

            @if(count($dataTweet) == 0)
                <h3 style="margin-top: 15vh;">No Tweet yet.</h3>
            @endif

            @foreach($dataTweet as $data)
            <div>
                @if($data->image != null)
                    <div class="d-flex mt-4 border-bottom" style="height: 15%; padding-bottom: 270px;">
                @else
                    <div class="d-flex mt-4 border-bottom" style="height: 15%; padding-bottom: 150px;">
                @endif

                    @if($data->user->avatar == null)
                    <span style="
                    width:50px;
                    height:50px;
                    color:#fff;
                    font-weight:700;
                    font-size: 25px;
                    text-transform:600;
                    background-color:#5BC0F8;
                    border-radius:50%;
                    display:flex;
                    align-items:center;
                    justify-content:center;" 
                    class="initial mt-1">{{ substr($data->user->username, 0, 1) }}</span>
                    @else
                        <img src="{{ url('storage/avatar/' . Auth::user()->avatar) }}" alt="" style="width: 50px; height: 50px;" class="rounded-circle">
                    @endif
                <div>
                    <div class="d-flex flex-row">
                        <p class="ml-4 h4">{{ '@' . $data->user->username }}</p>
                        @if(Auth::user()->id == $data->user->id)
                    <div class="d-flex flex-row" style="margin-left: 25vh;">
                        <form action="{{ route('editTweet', $data->id) }}" method="GET" class="mr-3">
                            @csrf
                            <button class="btn text-white font-weight-bold" style="background-color: #1D9BF0; border-radius: 15px;">Edit Tweet</button>
                        </form>
                        <form action="{{ route('deleteTweet', $data->id) }}" method="POST">
                        @csrf
                            <button class="btn text-white font-weight-bold" style="background-color: #1D9BF0; border-radius: 15px;">Delete</button> 
                        </form>
                    </div>
                    @endif
                    </div>
                    <p class="ml-4 h6">{{ $data->tweet }}</p>
                    @if($data->image != null)
                    <img src="{{ url('storage/images/' . $data->image) }}" alt="" class="ml-4" style="width: 200px; height: 200px;">
                    @endif
                    <div class="ml-4 mt-4">
                        <form action="{{ route('comment', $data->id) }}" method="GET">
                        @csrf
                            <button type="submit" class="btn text-white font-weight-bold" style="background-color: #1D9BF0; border-radius: 15px;">Comment</button>
                        </form>
                    </div>
                </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection