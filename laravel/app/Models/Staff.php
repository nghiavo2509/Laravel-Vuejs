<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'user_staffs';
    protected $fillable = ['user_id', 'name', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
