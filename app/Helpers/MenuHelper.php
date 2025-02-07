<?php

namespace App\Helpers;

use App\Models\MenuItem;
use App\Models\Subcategory;
use App\Models\Setting;

class MenuHelper
{
    // Get menu items by menu_id and level
    public static function getMenuItems($menuId)
    {
        return MenuItem::where('menu_id', $menuId)
            ->where('is_enable', 1)
            ->orderBy('sort', 'asc')
            ->get();
    }
    public static function getsubAttractions($attid)
    {
        return Subcategory::where('category_id', $attid)
            ->orderBy('created_at', 'asc')
            ->get();
    }


}