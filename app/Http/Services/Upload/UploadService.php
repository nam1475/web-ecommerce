<?php

namespace App\Http\Services\Upload;


class UploadService{
    public function store($request){
        if ($request->hasFile('file')) {
            try{
                $inputFile = $request->file('file');
                $generatedFileName = time() . "-" . $inputFile->getClientOriginalName();
                $path = "uploads-files/";
                $inputFile->storeAs("public/" . $path, $generatedFileName);   
                return "/storage/" . $path . $generatedFileName;
            }catch(\Exception $err){
                return false;   
            }
        }
    }

}