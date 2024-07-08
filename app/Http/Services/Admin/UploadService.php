<?php

namespace App\Http\Services\Admin;

use Illuminate\Support\Facades\Session;

class UploadService{
    public function store($request){
        /* Kiểm tra có file nào được tải lên với trường input có name là 'file' hay ko */
        if ($request->hasFile('file')) {
            try{
                $inputFile = $request->file('file');
                $generatedFileName = time() . "-" . $inputFile->getClientOriginalName();
                $path = "uploads-files/";
                /* storeAs(): Lưu tên file tự đặt, lưu file vào storage/app/public/uploads-files/ 
                - Khi lưu vào trong storage/app/public/uploads-files/ sẽ đồng thời lưu vào 
                public/storage/uploads-files/ nhờ lệnh php artisan storage:link
                */
                $inputFile->storeAs("public/" . $path, $generatedFileName);   
                /* Trả về đường dẫn public/storage/uploads-files/ để có thể truy cập ngoài 
                trình duyệt */
                return "/storage/" . $path . $generatedFileName;
            }catch(\Exception $err){
                Session::flash('error', $err->getMessage());
                return false;   
            }
        }
    }

}