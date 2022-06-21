<?php

namespace App\Models\Studies;

use App\Models\Masters\{
    ClassModel,
    Month
};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Present extends Model
{
    use HasFactory;

    protected $table = 'std_present';
}