@extends('layouts.layout')
@extends('layouts.navbar')

@section('main')
<div class="d-flex justify-content-center">
    <div class="d-flex flex-column">
        <form id="form-edit" action="{{ route('updateTweet', $dataTweet->id) }}" method="POST">
        @csrf
        <div class="d-flex align-items-center my-5">
            @if($dataTweet->image == null)
            <img src="{{ url('assets/no-image.jpg') }}" class="rounded-circle" style="width: 50px; height: 50px;" alt="">
            @else
            <img src="{{ url('storage/images/' . $dataTweet->image) }}" class="rounded-circle" style="width: 50px; height: 50px;" alt="">
            @endif
            <input type="file" name="image" class="mx-3" value="{{ $dataTweet->image }}">
        </div>
            <div>
                <div class="form-group">
                    <textarea name="tweet" class="form-control form-control-lg" placeholder="Tweet">{{ $dataTweet->tweet }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn text-white font-weight-bold" style="background-color: #1D9BF0; width: 60vh;">Save</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        function editTweet(e) {
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
                success: function() {
                    window.location = document.referrer
                }
            })
        }

        $('#form-edit').on('submit', editTweet)
    })
</script>
@endsection