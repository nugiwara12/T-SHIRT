<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = ['mother_name', 'address', 'purpose', 'your_name', 'date', 'minor', 'age', 'date_of_birth', 'generated_number'];

}
