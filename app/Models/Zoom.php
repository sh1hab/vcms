<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zoom extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'zoom_meetings';
}
