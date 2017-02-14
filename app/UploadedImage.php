<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class UploadedImage extends Model
{
    protected $appends = ['human_time'];
    // protected $dates = ['created_at', 'updated_at'];

    public function getHumanTimeAttribute(){
		return $this->created_at->diffForHumans();
    }
}
