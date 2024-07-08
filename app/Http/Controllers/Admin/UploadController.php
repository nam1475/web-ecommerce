<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Admin\UploadService;

class UploadController extends Controller
{   
    protected $upload;

    public function __construct(UploadService $upload)
    {
        $this->upload = $upload;
    }

    public function store(Request $request){
        $urlFile = $this->upload->store($request);
        if($urlFile != false){
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
    }
}
