@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('layouts._messages')
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h1 class="mt-0">{{$question->title}}</h1>
                            <div class="ml-auto">
                                <a href="{{route('questions.index')}}" class="btn btn-secondary btn-outline-secondary">Back To All questions</a>
                            </div>
                            {{-- <h4 class="mt-0">Asked by <a href="{{$question->user->url}}">{{$question->user->name}}</a></h4> --}}
                            {{-- <small>on {{$question->created_date}}</small> --}}
                        </div>
                    </div>

                    <hr>

                    <div class="media">
                        <div class="d-flex-flex-column vote-controls">
                            <a onclick="event.preventDefault();document.getElementById('upvote-form').submit()" title="This question is useful" class="vote-up {{Auth::guest() ? 'off' : '' }}">
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>
                            <form action="{{route('questions.vote',$question)}}" method="POST" id="upvote-form">
                                @csrf
                                <input type="hidden" name="vote" value="1">
                            </form>

                            <span class="votes-count">{{$question->votes_count}}</span>

                            <a onclick="event.preventDefault();document.getElementById('downvote-form').submit()" title="This question is not useful" class="vote-down {{Auth::guest() ? 'off' : '' }}">
                                <i class="fas fa-caret-down fa-3x"></i>
                            </a>
                            <form action="{{route('questions.vote',$question)}}" method="POST" id="downvote-form">
                                @csrf
                                <input type="hidden" name="vote" value="-1">
                            </form>
                            @auth
                            @if(!auth()->user()->is_favorited($question->id))
                            <a onclick="event.preventDefault();document.getElementById('fav-form').submit();" title="Click to mark as favorite question (click again to undo)" class="favorite mt-2">
                                <form action="{{route('questions.favorite',$question->id)}}" method="post" id="fav-form">
                                    @csrf
                                </form>
                            @else
                            <a onclick="event.preventDefault();document.getElementById('unfav-form').submit();" title="Click to mark as favorite question (click again to undo)" class="favorite mt-2 favorited">
                                <form action="{{route('questions.unfavorite',$question->id)}}" method="post" id="unfav-form">
                                    @csrf
                                    @method("DELETE")
                                </form>
                            @endif    
                                <i class="fas fa-star fa-2x"></i>
                                <span class="favoirte-count" >{{$question->favorites_count}}</span>
                            </a>
                            @endauth
                        </div>
                        <div class="media-body lead">
                            {!! $question->body_html !!}
                            <div class="row">
                                <div class="col-4"></div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <span class="text-muted">Asked {{$question->created_date}} by:</span>
                                    <div class="media">
                                        <a href="{{$question->user->url}}" class="pr-2">
                                            <img src="{{$question->user->avatar}}" alt="">
                                        </a>
                                        <div class="media-body mt-2">
                                            <a href="{{$question->user->url}}">{{$question->user->name}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('answers._index',[
        'answers' => $question->answers,
        'answersCount' => $question->answers_count
    ])

    @include('answers._create')
</div>
@endsection
