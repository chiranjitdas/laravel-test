<?php


namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
class MenuController extends BaseController
{
    /**
     * SAMPLE RESPONSE:
     *
     *
     */

    public function getMenuItems() {
        // throw new \Exception('implement in coding task 3');
        $finalReturnValue = [];
        $allParentMenuItems = DB::table('menu_items')
                   ->select('*')
                   ->where('parent_id', null)
                   ->get();
        $count = count($allParentMenuItems);
        if(count($allParentMenuItems) > 0){
            foreach($allParentMenuItems as $parent){
                $childrens = $this->showSubMenuItems('menu_items','parent_id', $parent->id);
                $childrenMenufinalReturnValue = [];
                
                if(count($childrens) > 0){
                    foreach($childrens as $childrenMenu){
                        $childrenVal = $this->showSubMenuItems('workshops','event_id', $childrenMenu->id);
                        $anotherChildArray = [];
                        $childrenMenu->id = ++$count;

                        if(count($childrenVal) > 0){
                            foreach($childrenVal as $anotherChild){
                                $anotherChild->children = [];
                                $anotherChild->id = ++$count;
                                $anotherChild->url = $childrenMenu->url.'/workshops';
                                $anotherChild->parent_id = $anotherChild->event_id;
                                unset($anotherChild->start);
                                unset($anotherChild->end);
                                unset($anotherChild->event_id);
                                array_push($anotherChildArray, $anotherChild);
                            }
                        }
                        $childrenMenu->children = $anotherChildArray; 
                        array_push($childrenMenufinalReturnValue, $childrenMenu);
                    }            
                }            
                $parent->children = $childrenMenufinalReturnValue;
                array_push($finalReturnValue, $parent);
            }
        }
        
        return response()->json($finalReturnValue);
    }
    public function showSubMenuItems($parent_table, $col_name, $parent_id) {
        $children = DB::table($parent_table)
                   ->select('*')
                   ->where($col_name, $parent_id)
                   ->get();
        return $children;
    }
}
