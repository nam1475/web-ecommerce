<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Upload\UploadService;

class UploadController extends Controller
{
    protected $upload;

    public function __construct(UploadService $upload)
    {
        $this->upload = $upload;
    }

    public function store(Request $request){
        // if(isset($request->submit)){
            $urlFile = $this->upload->store($request);
            if($urlFile){
                return response()->json([
                    'error' => false,
                    'urlFile' => $urlFile
                ]);
            }
            else{
                return response()->json([
                    'error' => true,
                    'messageError' => 'Upload ảnh ko thành công'
                ]);                                 
            }
        // }
    }
}
