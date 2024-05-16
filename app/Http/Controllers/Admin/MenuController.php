<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Http\Requests\Menu\MenuFormRequest;
use App\Http\Services\Menu\MenuService;

class MenuController extends Controller
{
    /* Tạo 1 biến trung gian và constructor(Khởi tạo 1 đối tượng) để thông qua đó có thể truy cập tới các 
    phương thức ở class khác */
    protected $menuService;

    public function __construct(MenuService $menuService){
        $this->menuService = $menuService;
    }
    
    public function list(){
        return view('admin.menu.list', [
            'title' => 'DS danh mục',
            'menus' => $this->menuService->getAll()
        ]);
    }

    public function add(){
        return view('admin.menu.add', [
            'title' => 'Thêm danh mục mới',
            'menus' => $this->menuService->getParent()
        ]);
    }

    public function store(MenuFormRequest $request){
        $request->validated();

        $this->menuService->create($request);

        return redirect()->back();
    }

    public function edit($id){
        return view('admin.menu.edit', [
            'title' => 'Sửa danh mục',
            'menu' => $this->menuService->edit($id),
            'parentMenus' => $this->menuService->getParent()
        ]);
    }

    public function update(MenuFormRequest $request, $id){
        $request->validated();

        $this->menuService->update($request, $id);

        return redirect()->route('menu.list');
    }

    public function delete($id){
        $this->menuService->delete($id);

        return redirect()->back();
    }

    
}
