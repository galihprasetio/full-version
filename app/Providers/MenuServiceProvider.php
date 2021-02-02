<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Systems\Menu;
class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //get all menus from database 
        $menus = Menu::where('is_parent',true)->orderBy('order','asc')->get();
        $parent = [];
        
        foreach ($menus as $key => $menu) {
            $submenus = Menu::where('parent_id',$menu->id)->orderBy('order','asc')->get();
            if ($submenus->count() > 0  && $menu->is_parent) {
                $child = [];
                foreach ($submenus as $key => $submenu) {
                    $child[] = [
                        'url' => $submenu->url,
                        'name' => $submenu->name,
                        'slug' => $submenu->slug,
                        'icon' => $submenu->icon,
                    ]; 
                }
            }
            if ($menu->is_parent && $submenus->count() > 0 ) {
                $parent[] = [
                    'url' => $menu->url,
                    'name' => $menu->name,
                    'slug' => $menu->slug,
                    'icon' => $menu->icon,
                    'navheader' => $menu->navheader,
                    'submenu' => $child,
                ];
            }else{
                $parent[] = [
                    'url' => $menu->url,
                    'name' => $menu->name,
                    'slug' => $menu->slug,
                    'icon' => $menu->icon,
                    'navheader' => $menu->navheader,
                ];
            }
            
        }
        $result = json_encode(['menu' => $parent]);
        //dd($result);
        // get all data from menu.json file
        $verticalMenuJson = file_get_contents(base_path('resources/json/verticalMenu.json'));
        $verticalMenuData = json_decode($verticalMenuJson);
        // dd($verticalMenuData);
        // $horizontalMenuJson = file_get_contents(base_path('resources/json/horizontalMenu.json'));
        // $horizontalMenuData = json_decode($horizontalMenuJson);

        // Share all menuData to all the views
        \View::share('menuData',[$verticalMenuData]);
    }
}
