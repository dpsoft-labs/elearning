<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ai extends Model
{
    use HasFactory;
    protected $table = 'ai';
    protected $fillable = ['user_id', 'message', 'date'];

}
