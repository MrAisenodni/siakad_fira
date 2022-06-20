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

    public function month()
    {
        return $this->belongsTo(Month::class)->select('id', 'name')->where('disabled', 0);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class)->select('id', 'name')->where('disabled', 0);
    }
}