<?php

namespace App\Models\Studies;

use App\Models\Masters\{
    Category,
    Tag,
};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $table = 'std_article';

    public function category()
    {
        return $this->belongsTo(Category::class)->select('id', 'name')->where('disabled', 0);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class)->select('id', 'name')->where('disabled', 0);
    }
}