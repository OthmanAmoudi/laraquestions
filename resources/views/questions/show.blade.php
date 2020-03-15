@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                        <h1 class="mt-0">{{$question->title}}</h1>
                        <h4 class="mt-0">Asked by <a href="{{$question->user->url}}">{{$question->user->name}}</a></h4>
                        <small>on {{$question->created_date}}</small>
                </div>

                <div class="card-body">
                       <div class="media">
                           <div class="media-body lead">
                                {!! $question->body_html !!}
                           </div>
                       </div>
                       <hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
