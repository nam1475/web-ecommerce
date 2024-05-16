<?php
namespace App\Http\Services\Slider;

use App\Models\Slider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SliderService{
    public function add($request)
    {
        try {
            Slider::create($request->all());
            Session::flash('success', 'Thêm Slider mới thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm Slider Lỗi');
            return false;
        }
        return true;
    }

    public function getAll()
    {
        $sliders = Slider::orderByDesc('id')->paginate(10);
        return $sliders;
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
            Session::flash('error', 'Cập nhật slider Lỗi');
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        // $slider = Slider::where('id', $request->input('id'))->first();
        try{
            $slider = Slider::find($id);
            if ($slider) {
                /* Thay thế string storage -> public để truy cập vào folder storage/public bên server */
                $path = str_replace('storage', 'public', $slider->thumb);
                Storage::delete($path); // Xóa ảnh trong server và client
                $slider->delete();
                Session::flash('success', 'Xóa Slider Thành Công');
                return true;
            }
        }
        catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
    }

    public function show()
    {
        return Slider::where('active', '=', 1)->orderByDesc('sort_by')->get();
    }


}