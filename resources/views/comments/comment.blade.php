@extends('layouts.layout')
@extends('layouts.navbar')

@section('main')
<div class="d-flex justify-content-center overflow-y-scroll">
    <div class="d-flex flex-column">

        <!-- Pengecekan jika image tidak ada dalam database maka padding bottomnya akan berubah -->
        <div class="d-flex mt-4 border-bottom" style="height: 15%; padding-bottom: 30vh;">

        <!-- Pengecekan jika avatar dari user tidak ada dalam database maka akan menggunakan initial avatar -->
        @if($dataTweet->user->avatar == null)
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
            class="initial mt-1">{{ substr($dataTweet->user->username, 0, 1) }}</span>
        @else
            <img src="{{ url('storage/avatar/' . $dataTweet->user->avatar) }}" alt="" style="width: 50px; height: 50px;" class="rounded-circle">
        @endif
            <div>
                <div class="d-flex flex-row align-items-center">
                    <p class="ml-4 h4">@ {{ $dataTweet->user->username }}</p>
                    <div class="d-flex flex-row" style="margin-left: 25vh;">
                    @if(Auth::user()->id == $dataTweet->user->id)
                        <form action="{{ route('editTweet', $dataTweet->id) }}" method="GET" class="mr-3">

                            <button type="submit" class="btn text-white font-weight-bold" style="background-color: #1D9BF0; border-radius: 15px;">Edit Tweet</button>
                        </form>
                        <form action="{{ route('deleteTweet', $dataTweet->id) }}" method="POST">
                        @csrf
                            <button class="btn text-white font-weight-bold" style="background-color: #1D9BF0; border-radius: 15px;">Delete</button> 
                        </form>
                    @endif
                    </div>
                </div>
                <p class="ml-4 h6">{{ $dataTweet->tweet }}</p>
               @if($dataTweet->image != null)
                    <img src="{{ url('storage/images/' . $dataTweet->image) }}" alt="" class="ml-4" style="width: 150px; height: 150px;">
                @endif
    
            </div>
        </div>
            <div class="d-flex mt-4 border-bottom" style="height: 15%; padding-bottom: 160px;">
        @if(Auth::user()->avatar == null)
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
            class="initial mt-1">{{ substr(Auth::user()->username, 0, 1) }}</span>
        @else
            <img src="{{ url('storage/avatar/' . Auth::user()->avatar) }}" alt="" style="width: 50px; height: 50px;" class="rounded-circle">
        @endif
            <div>
                <form id="form-comment" action="{{ route('createComment') }}" method="POST">
                @csrf
                    <input type="hidden" name="tweet_id" value="{{ $dataTweet->id }}">
                    <textarea class="ml-3 form-control form-control-lg border-0" name="comment" placeholder="Tweet your reply" value="{{ old('comment') }}"></textarea>
                    <div class="ml-4 mt-4 d-flex align-items-center">
                        <input type="file" name="image">
                        <button type="submit" class="btn text-white font-weight-bold" style="background-color: #1D9BF0; border-radius: 15px; margin-left: 17vh;">Reply</button>
                    </div>
                </form>
            </div>
        </div>
        <div>
            @foreach($dataComment as $data)
    
            <div class="d-flex mt-4 border-bottom" style="height: 15%; padding-bottom: 35vh;">
    
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
                    <p class="ml-4 h6">{{ $data->comment }}</p>
                    @if($data->image != null)
                        <img src="{{ url('storage/comment/' . $data->image) }}" alt="" class="ml-4" style="width: 200px; height: 200px;">
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        function submitComment(e) {
            e.preventDefault();
            
            $.ajax({
                type: 'POST',
                url: $('#form-comment').attr('action'),
                data: new FormData(this),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                contentType: false,
                processData: false,
                success: function() {
                    location.reload()
                }
            })
        }

        $('#form-comment').on('submit', submitComment)
    })
</script>
@endsection