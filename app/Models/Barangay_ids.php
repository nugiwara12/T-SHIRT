<?php

// app\Models\Barangay_ids.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay_ids extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'address',
        'date_of_birth',
        'place_of_birth',
        'age',
        'citizenship',
        'gender',
        'civil_status',
        'contact_no',
        'guardian',
        'relation',
        'minor',
        'generated_number',
    ];
}

