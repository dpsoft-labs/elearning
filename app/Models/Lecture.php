<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $guarded = [];

    protected $table = 'lectures';

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
