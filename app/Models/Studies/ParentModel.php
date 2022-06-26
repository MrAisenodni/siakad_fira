<?php

namespace App\Models\Studies;

use App\Models\Masters\{
    Occupation,
    Religion,
};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;

    protected $table = 'mst_parent';

    public function religion() 
    {
        return $this->belongsTo(Religion::class)->select('id', 'name')->where('disabled', 0);
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class)->select('id', 'name')->where('disabled', 0);
    }
    
    public function student()
    {
        return $this->belongsTo(Student::class)->select('id', 'nis', 'full_name')->where('disabled', 0);
    }
}