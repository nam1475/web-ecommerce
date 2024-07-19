<?php
namespace App\Http\Services\Admin;

use App\Models\Slider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Traits\HelperTrait;

class SliderService{
    use HelperTrait;

    public function add($request)
    {
        $request->validated();
        try {
            Slider::create($request->all());
            Session::flash('success', 'Thêm Slider mới thành công');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }

    public function edit($id){
        $slider = Slider::find($id);
        return $slider;
    }

    public function update($request, $id)
    {
        try {
            $slider = Slider::find($id);
            $slider->update($request->all());
            Session::flash('success', 'Cập nhật Slider thành công');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }

    public function delete($id)
    {
        // $slider = Slider::where('id', $request->input('id'))->first();
        try{
            $slider = Slider::find($id);
            self::deleteFile($slider);
            $slider->delete();
            Session::flash('success', 'Xóa Slider Thành Công');
        }
        catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }

    public function show()
    {
        return Slider::where('active', '=', 1)->orderByDesc('sort_by')->get();
    }


}