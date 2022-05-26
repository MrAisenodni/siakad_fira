<?php

namespace App\Models\Settings;

use App\Models\Settings\SubMenu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'stg_menu';

    public function sub_menus() 
    {
        return $this->hasMany(SubMenu::class)->select('title', 'url', 'icon', 'menu_id')->where('disabled', 0);
    }
}
