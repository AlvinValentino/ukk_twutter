@extends('layouts.layout')
@extends('layouts.navbar')

@section('main')
<div class="d-flex justify-content-center">
    <div class="d-flex flex-column">
        <form id="form-edit" action="{{ route('updateComment', $dataComment->id) }}" method="POST">
        @csrf
        <div class="d-flex align-items-center my-5">
            @if($dataComment->image == null)
            <img src="{{ url('assets/no-image.jpg') }}" class="rounded-circle" style="width: 50px; height: 50px;" alt="">
            @else
            <img src="{{ url('storage/comment/' . $dataComment->image) }}" class="rounded-circle" style="width: 50px; height: 50px;" alt="">
            @endif
            <input type="file" name="image" class="mx-3" value="{{ $dataComment->image }}">
        </div>
            <div>
                <div class="form-group">
                    <textarea name="comment" class="form-control form-control-lg" placeholder="Comment">{{ $dataComment->comment }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn text-white font-weight-bold" style="background-color: #1D9BF0; width: 60vh;">Save</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        function editComment(e) {
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
                    window.location.href = '/home';
                }
            })
        }

        $('#form-edit').on('submit', editComment)
    })
</script>
@endsection