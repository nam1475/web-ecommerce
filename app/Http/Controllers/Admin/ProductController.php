<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Admin\ProductAdminService;
use App\Models\Product;
use App\Http\Requests\Admin\ProductFormRequest;
use App\Traits\HelperTrait;
use App\Models\Menu;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductAdminService $productService)
    {
        $this->productService = $productService;
    }

    public function list(Request $request)
    {
        return view('admin.product.list', [
            'title' => 'Danh Sách Sản Phẩm',
            'products' => HelperTrait::getAll($request, Product::class),
            'menuProducts' => $this->productService->getMenuProducts(),
            'highestPrice' => $this->productService->getHighestProductPrice(),
        ]);
    }

    public function filterQueryString(Request $request)
    {
        return HelperTrait::filterQueryString($request, 'product.list');
    }

    public function add()
    {        
        return view('admin.product.add', [
            'title' => 'Thêm Sản Phẩm Mới',
            'menus' => HelperTrait::getMenus(),
            'sizes' => $this->productService->getSizes()
        ]);
    }

    public function store(ProductFormRequest $request)
    {
        $request->validated();
        
        $result = $this->productService->add($request);
        if($result){
            return redirect()->route('product.list');
        }
        return redirect()->back();
    }

    public function edit($id)
    {
        return view('admin.product.edit', [
            'title' => 'Chỉnh Sửa Sản Phẩm',
            'product' => $this->productService->getProductById($id),
            'menus' => HelperTrait::getMenus(),
            'sizes' => $this->productService->getSizes(),
            'productSizes' => $this->productService->getProductSizes('', $id)
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
        $result = $this->productService->delete($id);
        if($result){
            // return response()->json([
            //     'error' => false,
            // ]);
            return redirect()->route('product.list');
        }
        return redirect()->back();
        // return response()->json(['error' => true]);
    }
}
