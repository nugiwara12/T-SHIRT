<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Erwin extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'description',
    ];
}
