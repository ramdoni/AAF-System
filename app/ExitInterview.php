<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExitInterview extends Model
{
    protected $table = 'exit_interview';

    /**
     * [exit_interview_form description]
     * @return [type] [description]
     */
    public function exitInterviewReason()
    {
    	return $this->hasOne('App\ExitInterviewReason', 'id', 'exit_interview_reason');
    }

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
}
