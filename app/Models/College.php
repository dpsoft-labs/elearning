<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{

    protected $table = 'colleges';

    protected $guarded = [];

    public function students()
    {
        return $this->hasMany(User::class, 'college_id', 'id');
    }

}
