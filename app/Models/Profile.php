<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['id', 'full_name', 'role', 'created_at'];

    public function user()
    {
        return $this->belongsTo(TetUser::class, 'id');
    }
}
