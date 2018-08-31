<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'training';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('\App\User', 'id', 'user_id');
    }

    public function atasan()
    {
    	return $this->hasOne('\App\User', 'id', 'approved_hrd_id');
    }

    /**
     * [hrd description]
     * @return [type] [description]
     */
    public function hrd()
    {
    	return $this->hasOne('\App\User', 'id', 'approved_hrd_id');
    }
}
