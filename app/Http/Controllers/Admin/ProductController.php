<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Product\ProductAdminService;
use App\Models\Product;
use App\Http\Requests\Product\ProductFormRequest;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductAdminService $productService)
    {
        $this->productService = $productService;
    }

    public function list()
    {
        return view('admin.product.list', [
            'title' => 'Danh Sách Sản Phẩm',
            'products' => $this->productService->getAll()
        ]);
    }

    public function add()
    {
        return view('admin.product.add', [
            'title' => 'Thêm Sản Phẩm Mới',
            'menus' => $this->productService->getMenu()
        ]);
    }


    public function store(ProductFormRequest $request)
    {
        $request->validated();

        $this->productService->add($request);

        return redirect()->route('product.list');
    }

    public function edit($id)
    {
        return view('admin.product.edit', [
            'title' => 'Chỉnh Sửa Sản Phẩm',
            'product' => $this->productService->edit($id),
            'menus' => $this->productService->getMenu()
        ]);
    }


    public function update(Request $request, $id)
    {
        $result = $this->productService->update($request, $id);
        if ($result) {
            return redirect()->route('product.list');
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        $this->productService->delete($id);
        return redirect()->route('product.list');
    }
}
