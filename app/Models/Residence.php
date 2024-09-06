<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residence extends Model
{
    use HasFactory;
    
    protected $fillable = ['mother_name', 'address', 'purpose', 'your_name', 'date_of_birth', 'gender', 'age', 'date_start', 'minor', 'generated_number'];

}
