<?php
// Branch Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    protected $table = 'branches';

    protected $guarded = [];

    public function students()
    {
        return $this->hasMany(User::class, 'branch_id', 'id');
    }

}
