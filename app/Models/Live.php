<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Live extends Model
{
    protected $guarded = [];

    protected $table = 'lives';

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
