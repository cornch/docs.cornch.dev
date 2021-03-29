@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-6">
        <div class="flex -mx-2">
            <div class="w-1/4 sidebar">
                <x-doc-sidebar />
            </div>

            <div class="w-3/4 content mx-2 language-php">
                {!! $markdown !!}
            </div>
        </div>
    </div>
@endsection
