<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Http\Requests\Admin\MenuFormRequest;
use App\Http\Services\Admin\MenuService;
use App\Traits\HelperTrait;

class MenuController extends Controller
{
    use HelperTrait;

    /* Tạo 1 biến trung gian và constructor(Khởi tạo 1 đối tượng) để thông qua đó có thể truy cập tới các 
    phương thức ở class khác */
    protected $menuService;

    public function __construct(MenuService $menuService){
        $this->menuService = $menuService;
    }
    
    public function list(Request $request){
        /* Lấy ra danh sách các menu con theo lần lượt từng menu cha */
        // $menus = Menu::with('childrenRecursive')->whereNull('parent_id')->where('active', 1)->paginate(2);
        // dd($menus); 
        return view('admin.menu.list', [
            'title' => 'DS danh mục',
            'menus' => self::getAll($request, Menu::class),
            'menuParents' => self::getParents(Menu::class),
        ]);
    }

    public function add(){
        return view('admin.menu.add', [
            'title' => 'Thêm danh mục mới',
            // 'menus' => self::getParents(Menu::class),
            'menus' => self::getMenus()
        ]);
    }

    public function store(MenuFormRequest $request){
        $request->validated();

        $result = $this->menuService->create($request);
        if($result){
            return redirect()->route('menu.list');
        }
        return redirect()->back();
    }

    public function edit($id){
        return view('admin.menu.edit', [
            'title' => 'Sửa danh mục',
            'menu' => $this->menuService->edit($id),
            // 'parentMenus' => self::getParents(Menu::class)
            'menus' => self::getMenus()
        ]);
    }

    public function update(Request $request, $id){
        $result = $this->menuService->update($request, $id);
        if($result){
            return redirect()->route('menu.list');
        }
        return redirect()->back();        
    }

    public function delete($id){
        $result = $this->menuService->delete($id);
        if($result){
            return redirect()->route('menu.list');
        }
        return redirect()->back();
    }

    
}
