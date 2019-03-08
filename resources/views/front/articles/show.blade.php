@extends('layouts.app')

@section('content')

    <div class="px-6">
        <div>
            <h3 class="text-2xl">{{ $article->title }}</h3>
            <p class="text-grey text-sm my-3">{{ $article->created_at->toDayDateTimeString() }}</p>
        </div>

        <div class="markdown-body">
        
            @markdown($article->body)


        </div>

        <hr>

    </div>

@endsection

@section('sidebar')
    @include('layouts.sidebars.app')
@endsection
