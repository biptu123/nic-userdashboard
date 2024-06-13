<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'password', 'email', 'phone'];
    public function files()
    {
        return $this->hasMany(File::class);
    }
}
