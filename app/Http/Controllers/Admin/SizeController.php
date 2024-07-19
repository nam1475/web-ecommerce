<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
use Illuminate\Support\Facades\Session;
use App\Traits\HelperTrait;

class SizeController extends Controller
{
    use HelperTrait;

    public function list(Request $request)
    {
        return view('admin.size.list', [
            'title' => 'Danh Sách Sản Phẩm',
            'sizes' => self::getAll($request, Size::class),
        ]);
    }

    public function add()
    {
        return view('admin.size.add', [
            'title' => 'Thêm Sản Phẩm Mới',
        ]);
    }

    public function store(Request $request)
    {
        Size::create($request->all());
        Session::flash('success', 'Thêm size thành công!');
        return redirect()->route('size.list');
    }

    public function edit($id)
    {
        $size = Size::find($id);
        return view('admin.size.edit', [
            'title' => 'Chỉnh Sửa Sản Phẩm',
            'size' => $size
        ]);
    }

    public function update(Request $request, $id)
    {
        $size = Size::find($id);
        $size->update($request->all());
        Session::flash('success', 'Cập Nhật Size Thành Công!');
        return redirect()->route('size.list');
    }

    public function delete($id)
    {
        Size::find($id)->delete();
        Session::flash('success', 'Xóa Size Thành Công!');
        return redirect()->route('size.list');
    }

}
