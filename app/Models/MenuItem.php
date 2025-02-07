<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class MenuItem extends Model
{
    
    protected $table = 'menu_items';

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */    
    protected $fillable = [
        'id',
        'title',
        'subtitle',
        'target',
        'link',
        'level',
        'parent_id',
        'menu_id',
        'sort',
        'is_enable',
        'created_at',
        'updated_at',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort');
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public static function get_menu_drop_down($menu_id,$parent_id = 0,$id = 0){


        
       $html = "";
       $items = MenuItem::where('menu_id',$menu_id)
       ->whereNotIn('id',[$id])
       ->where('parent_id',NULL)
       ->orderBy('sort')
       ->get();

        foreach($items as $item){

                $level1 = $item->id == $parent_id ? 'selected' : '';

                $html .="<option  ".$level1." value='".$item->id.'-2'."'>".$item->title."</option>";

                foreach ($item->children->whereNotIn('id',[$id]) as $child){

                    $level2 = $child->id == $parent_id ? 'selected' : '';
                    $html .="<option ".$level2." value='".$child->id.'-3'."'>-- ".$child->title."</option>";
                    
                    foreach ($child->children->whereNotIn('id',[$id]) as $sub){
                        
                        $level3 = $sub->id == $parent_id ? 'selected' : '';
                        $html .="<option ".$level3." value='".$sub->id.'-4'."'>---- ".$sub->title."</option>";

                            foreach ($sub->children->whereNotIn('id',[$id]) as $subsub){
                                
                                $level4 = $subsub->id == $parent_id ? 'selected' : '';
                                $html .="<option ".$level4." value='".$subsub->id.'-5'."'>-------> ".$subsub->title."</option>";

                            }
                        }

                }

        }


        // dd($html);
        return $html;
    }


   
}
