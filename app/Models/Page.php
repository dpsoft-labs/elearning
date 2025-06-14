<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;
    protected $table = 'pages';
    protected $guarded = [];
    public $translatable = ['content'];
}
