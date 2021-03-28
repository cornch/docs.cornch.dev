@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-6">
        <div class="content">
            {!! Str::markdown($markdown) !!}
        </div>
    </div>
@endsection
