<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    protected $table = "files";

    public $guarded = [];

    public function sames()
    {
        return $this->hasMany(Files::class,'file_name','file_name');
    }
}
