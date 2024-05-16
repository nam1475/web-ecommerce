<?php

namespace App\Http\View\Composers;

use App\Repositories\UserRepository;
use Illuminate\View\View;
use App\Models\Menu;

class MenuComposer{
    
    protected $users;
 
    public function __construct()
    {
        
    }

    public function compose(View $view)
    {
        $menus = Menu::select('id', 'name', 'parent_id')->where('active', '=', 1)->orderByDesc('id')->get();
        $view->with('menus', $menus); // Truyền menus đến view thông qua ViewServiceProvider
    }
}