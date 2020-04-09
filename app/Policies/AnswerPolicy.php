<?php

namespace App\Policies;

use App\User;
use App\Answer;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Answer $answer)
    {
        return $user->id == $answer->user_id;
    }

    public function accept(User $user,Answer $answer)
    {
        return $user->id == $answer->question->user_id;
    }
}
