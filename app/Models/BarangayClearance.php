<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayClearance extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent', 'address', 'reason', 'minor', 'age', 'generated_number'];
}
