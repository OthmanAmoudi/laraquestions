<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use URL;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function getUrlAttribute()
    {
        return URL::to('/').'/user/'.$this->id;
    }

    public function getAvatarAttribute()
    {
        $email = $this->email;
        $size = 40;
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    }

    public function favorites()
    {
        return $this->belongsToMany(Question::class,'favorites')->withTimestamps();//,'user_id','question_id');
    }

    public function is_favorited($question_id)
    {
        return $this->favorites()->where('question_id',$question_id)->count() > 0;
    }

    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class,'votable');
    }

    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class,'votable');
    }

    public function voteQuestion(Question $question, $vote)
    {
        $voteQuestions = $this->voteQuestions();

        if($voteQuestions->where('votable_id',$question->id)->exists()){
            $voteQuestions->updateExistingPivot($question,['vote'=>$vote]);
        }else{
            $voteQuestions->attach($question,['vote' => $vote]);
        }

        $question->load('votes');
        $upVotes = (int) $question->upVotes()->sum('vote');
        $downVotes = (int) $question->downVotes()->sum('vote');

        $question->votes_count = $downVotes + $upVotes;
        $question->save();

    }

    public function voteAnswer(Answer $answer, $vote)
    {
        $voteAnswers = $this->voteAnswers();

        if($voteAnswers->where('votable_id',$answer->id)->exists()){
            $voteAnswers->updateExistingPivot($answer,['vote'=>$vote]);
        }else{
            $voteAnswers->attach($answer,['vote' => $vote]);
        }

        $answer->load('votes');
        $upVotes = (int) $answer->upVotes()->sum('vote');
        $downVotes = (int) $answer->downVotes()->sum('vote');

        $answer->votes_count = $upVotes + $downVotes;
        $answer->save();

    }
}

//11-3-1