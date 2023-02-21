@extends('layouts.layout')
@extends('layouts.navbar')

@section('main')
<div class="d-flex justify-content-center overflow-y-scroll">
    <div style="width: 35%;">
        <div class="d-flex mt-4 border-bottom" style="height: 15%; padding-bottom: 200px;">
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
                <form id="form-tweet" action="{{ route('postTweet') }}" method="POST">
                @csrf
                    <textarea class="ml-3 form-control form-control-lg border-0" name="tweet" placeholder="What's happening ?" value="{{ old('tweet') }}"></textarea>
                    <div class="ml-4 mt-4 d-flex align-items-center">
                        <input type="file" name="image">
                        <button type="submit" class="btn text-white font-weight-bold" style="background-color: #1D9BF0; border-radius: 15px; margin-left: 17vh;">Tweet</button>
                    </div>
                </form>
            </div>
        </div>
        @foreach($tweetData as $data)

        <!-- Pengecekan jika image tidak ada dalam database maka padding bottomnya akan berubah -->
        <div class="d-flex mt-4 border-bottom" style="height: 15%; padding-bottom: 350px;">

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
                        <button type="submit" class="btn text-white font-weight-bold" style="background-color: #1D9BF0; border-radius: 15px;">Comment</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<script>
    $(document).ready(function() {
        function submitData(e) {
            e.preventDefault();
            
            $.ajax({
                type: 'POST',
                url: $('#form-tweet').attr('action'),
                data: new FormData(this),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    location.reload();
                },
                error: function(err) {
                    console.log(err)
                }
            })
        }

        $('#form-tweet').on('submit', submitData)
    })
</script>
@endsection