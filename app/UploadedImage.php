<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UploadedImage extends Model
{
    protected $appends = ['human_time', 'url', 'prev_url'];
    // protected $dates = ['created_at', 'updated_at'];
    protected $hidden = ['path', 'preview_path'];


    public function getHumanTimeAttribute(){
        return $this->created_at->diffForHumans();
    }
    public function getUrlAttribute(){
        return Storage::url($this->path);
    }
    public function getPrevUrlAttribute(){
        return Storage::url($this->preview_path);
    }           
}
