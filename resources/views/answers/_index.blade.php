<div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{$answersCount . " " . str_plural('Answer',$answersCount)}}</h2>
                    </div>
                    <hr>
                    
                    @foreach ($answers as $answer)
                        <div class="media">
                            
                            <div class="d-flex-flex-column vote-controls">
                                <a onclick="event.preventDefault();document.getElementById('upvote-form-{{$answer->id}}').submit()" title="This Answer is useful" class="vote-up {{Auth::guest() ? 'off' : '' }}">
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <form action="{{route('answers.vote',$answer)}}" method="POST" id="upvote-form-{{$answer->id}}">
                                    @csrf
                                    <input type="hidden" name="vote" value="1">
                                </form>
    
                                <span class="votes-count">{{$answer->votes_count}}</span>
    
                                <a onclick="event.preventDefault();document.getElementById('downvote-form-{{$answer->id}}').submit()" title="This Answer is not useful" class="vote-down {{Auth::guest() ? 'off' : '' }}">
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>
                                <form action="{{route('answers.vote',$answer)}}" method="POST" id="downvote-form-{{$answer->id}}">
                                    @csrf
                                    <input type="hidden" name="vote" value="-1">
                                </form>
    
                                @can('accept',$answer)
                                <a 
                                title="Mark this answer as best answer" 
                                class="{{$answer->status}} mt-2"
                                onclick="event.preventDefault();document.getElementById('accept-answer-{{$answer->id}}').submit();"
                                >
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                                <form id="accept-answer-{{$answer->id}}" action="{{route('answers.accept',$answer->id)}}" method="post" class="d-none">
                                    @csrf
                                </form>
                                @else
                                    @if($answer->is_best)
                                        <a 
                                        title="This answer was Marked as Best Answer" 
                                        class="{{$answer->status}} mt-2"
                                        >
                                            <i class="fas fa-check fa-2x"></i>
                                        </a>
                                    @endif
                                @endcan
                            </div>

                            <div class="media-body">
                                {!!$answer->body_html!!}
                                
                                <div class="row">
                                    <div class="col-4">
                                            @can('update',$answer)
                                            <div class="ml-auto">
                                               <a href="{{route('questions.answers.edit',[$question->id,$answer->id])}}" class="btn btn-sm btn-outline-info">Edit</a>
                                               @can('update',$answer)
                                                    <form class="d-inline" action="{{route('questions.answers.destroy',[$question->id,$answer->id])}}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure to delete this ?')">Delete</button>
                                                    </form>
                                                @endcan
                                           </div>
                                           @endcan
                                    </div>

                                    <div class="col-4"> </div>

                                    <div class="col-4">
                                        <span class="text-muted">Answered {{$answer->created_date}}</span>
                                        <div class="media">
                                            <a href="{{$answer->user->url}}" class="pr-2">
                                                <img src="{{$answer->user->avatar}}" alt="">
                                            </a>
                                            <div class="media-body mt-2">
                                                <a href="{{$answer->user->url}}">{{$answer->user->name}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>