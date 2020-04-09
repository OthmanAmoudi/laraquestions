<div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Your Answer</h3>
                    </div>
                    <hr>
                    @auth
                    <form action="{{route('questions.answers.store',$question->id)}}" method="post">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" id="body" rows="7" class="form-control {{$errors->has('body') ? 'is-invalid' : ''}}"></textarea>
                            @if ($errors->has('body'))
                                <div class="invalid-feedback">
                                    <strong>{{$errors->first('body')}}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <button  type="submit" class="btn btn-lg btn-outline-primary">Submit</button>
                        </div>
                    </form>
                    @else
                    <p class="text-center">Please <a href="{{route('login')}}">Login</a> / <a href="{{route('register')}}">Register</a> to Answer this question</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>