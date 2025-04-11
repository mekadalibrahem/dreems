<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'id',
        'username',
        'role',
        'created_at',
        'updated_at',
        'deleted_at',
        ''
    ]; // Adjust based on your table
}