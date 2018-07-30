<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalReimbursement extends Model
{
    protected $table = 'medical_reimbursement';

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->hasOne('App\User','id','user_id');
    }

    /**
     * [form description]
     * @return [type] [description]
     */
    public function form()
    {
    	return $this->hasMany('App\MedicalReimbursementForm', 'medical_reimbursement_id', 'id');
    }
}