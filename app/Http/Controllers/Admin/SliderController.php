<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Admin\SliderService;
use App\Models\Slider;
use App\Http\Requests\Admin\SliderFormRequest;
use App\Traits\HelperTrait;

class SliderController extends Controller
{
    use HelperTrait;

    protected $slider;

    public function __construct(SliderService $slider)
    {
        $this->slider = $slider;
    }

    public function list(Request $request)
    {
        return view('admin.slider.list', [
            'title' => 'Danh Sách Slider',
            'sliders' => self::getAll($request, Slider::class),
        ]);
    }

    public function add()
    {
        return view('admin.slider.add', [
           'title' => 'Thêm SLider mới'
        ]);
    }

    public function store(SliderFormRequest $request)
    {
        $result = $this->slider->add($request);
        if ($result) {
            return redirect()->route('slider.list');
        }
        return redirect()->back();
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
        $result = $this->slider->update($request, $id);
        if ($result) {
            return redirect()->route('slider.list');
        }

        return redirect()->back();
    }

    public function delete($id)
    {
        $result = $this->slider->delete($id);
        if($result){
            return redirect()->route('slider.list');
        }
        return redirect()->back();
    }
}
