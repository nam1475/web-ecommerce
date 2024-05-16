<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Slider\SliderService;

class SliderController extends Controller
{
    protected $slider;

    public function __construct(SliderService $slider)
    {
        $this->slider = $slider;
    }

    public function list()
    {
        return view('admin.slider.list', [
            'title' => 'Danh Sách Slider',
            'sliders' => $this->slider->getAll()
        ]);
    }

    public function add()
    {
        return view('admin.slider.add', [
           'title' => 'Thêm SLider mới'
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'thumb' => 'required',
            'url'   => 'required'
        ]);

        $this->slider->add($request);

        return redirect()->route('slider.list');
    }


    public function edit($id)
    {
        return view('admin.slider.edit', [
            'title' => 'Chỉnh Sửa Slider',
            'slider' => $this->slider->edit($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'thumb' => 'required',
            'url'   => 'required'
        ]);

        $result = $this->slider->update($request, $id);
        if ($result) {
            return redirect()->route('slider.list');
        }

        return redirect()->back();
    }

    // public function destroy(Request $request)
    // {
    //     $result = $this->slider->destroy($request);
    //     if ($result) {
    //         return response()->json([
    //             'error' => false,
    //             'message' => 'Xóa thành công Slider'
    //         ]);
    //     }

    //     return response()->json([ 'error' => true ]);
    // }

    public function delete($id)
    {
        $this->slider->delete($id);
        return redirect()->route('slider.list');
    }
}
