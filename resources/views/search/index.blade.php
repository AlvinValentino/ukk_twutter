@extends('layouts.layout')
@extends('layouts.navbar')

@section('main')
<div class="d-flex justify-content-center mt-4">
    <div>
        <form id="form-search" action="{{ route('explore.search') }}" class="d-flex" method="GET">
        @csrf
            <input type="text" class="" style="width: 65vh;" name="search" style="border: 1px solid #ddd; border-radius: 5px 0 0 5px;" value="{{ old('search') }}" placeholder="Search Twitter">
            <button type="submit" class="btn" style="border: 1px solid #ddd; border-radius: 0 5px 5px 0;">Submit</button>
        </form>
    </div>
</div>
@endsection