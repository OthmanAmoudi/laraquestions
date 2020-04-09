<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use Auth;
class FavoritesController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }

    public function store(Question $question)
    {
        $question->favorites()->attach(auth()->id());
        return back()->with('success',"Question has been Added to Favourite");
    }

    public function delete(Question $question)
    {
        $question->favorites()->detach(auth()->id());
        return back()->with('success',"Question has been Removed from Favourite");
    }
}
