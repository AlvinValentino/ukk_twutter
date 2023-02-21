@extends('layouts.layout')
@extends('layouts.navbar')

@section('main')
<div class="d-flex justify-content-center mt-4">
    <div id="main">
        <div>
            <form id="form-search" action="{{ route('explore.search') }}" class="d-flex" method="GET">
            @csrf
                <input type="text" class="" style="width: 65vh;" name="search" style="border: 1px solid #ddd; border-radius: 5px 0 0 5px;" value="{{ $search }}" placeholder="Search Twitter">
                <button type="submit" class="btn" style="border: 1px solid #ddd; border-radius: 0 5px 5px 0;">Submit</button>
            </form>
        </div>
        @if(count($dataTweet) == 0 && count($dataComment) == 0)
        <p class="h3 d-flex justify-content-center" style="margin-top: 30vh;">No tweets or comments yet.</p>
        @endif

        @if(count($dataTweet) > 0)
        @foreach($dataTweet as $data)
        <!-- Pengecekan jika image tidak ada dalam database maka padding bottomnya akan berubah -->
        <div class="d-flex mt-5 border-bottom" style="height: 15%; padding-bottom: 350px;">

        <!-- Pengecekan jika avatar dari user tidak ada dalam database maka akan menggunakan initial avatar -->
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
            <img src="{{ url('storage/avatar/' . $data->user->avatar) }}" alt="" style="width: 50px; height: 50px;">
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
                <p class="ml-4 h6">
                    <a class="text-decoration-none text-dark">{{ $data->tweet }}</a>
                </p>
                @if($data->image != null)
                <img src="{{ url('storage/images/' . $data->image) }}" alt="" class="ml-3" style="width: 150px; height: 150px;">
                @endif
                <div class="ml-4 mt-4">
                    <form action="{{ route('comment', $data->id) }}" method="GET">
                    @csrf
                        <input type="hidden" name="tweet" value="{{ $data->tweet }}">
                        <button type="submit" class="btn text-white font-weight-bold" style="background-color: #1D9BF0; border-radius: 15px;">Comment</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

        @endif

        @if(count($dataComment) > 0)

        @foreach($dataComment as $data)
            <!-- Pengecekan jika image tidak ada dalam database maka padding bottomnya akan berubah -->
        <div class="d-flex mt-5 border-bottom" style="height: 15%; padding-bottom: 350px;">

        <!-- Pengecekan jika avatar dari user tidak ada dalam database maka akan menggunakan initial avatar -->
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
            <img src="{{ url('storage/avatar/' . $data->user->avatar) }}" alt="" style="width: 50px; height: 50px;">
        @endif
            <div>
                <div class="d-flex flex-row">
                    <p class="ml-4 h4">{{ '@' . $data->user->username }}</p>
                    @if(Auth::user()->id == $data->user->id)
                    <div class="d-flex flex-row" style="margin-left: 25vh;">
                        <form action="{{ route('editComment', $data->id) }}" method="GET" class="mr-3">
                            @csrf
                            <button class="btn text-white font-weight-bold" style="background-color: #1D9BF0; border-radius: 15px;">Edit Comment</button>
                        </form>
                        <form action="{{ route('deleteComment', $data->id) }}" method="POST">
                        @csrf
                            <button class="btn text-white font-weight-bold" style="background-color: #1D9BF0; border-radius: 15px;">Delete</button> 
                        </form>
                    </div>
                    @endif
                </div>
                <p class="ml-4 h6">
                    <a class="text-decoration-none text-dark">{{ $data->comment }}</a>
                </p>
                @if($data->image != null)
                <img src="{{ url('storage/images/' . $data->image) }}" alt="" class="ml-3" style="width: 150px; height: 150px;">
                @endif
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection