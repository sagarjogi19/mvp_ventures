<?php 

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait ImgaeUpload
{
    function updateOrCreateImage($request,$checkFileKey,$requestAttribute,$model,$folder=NULL)
    {
        if ($request->file($checkFileKey)) {
            $imageName = $this->imageUploder($request->$checkFileKey,$model->$requestAttribute,$folder);  
            $request->request->add([$requestAttribute => $imageName]); //add request
        }
    }

    function imageUploder($image,$oldImage=NULL,$folder=NULL){
    
        if($oldImage){
            if(Storage::disk('public')->exists($folder.'/'.$oldImage)){
                Storage::disk('public')->delete($folder.'/'.$oldImage);
            }
        }
         $prefix = time() . "_" .rand(1000,9999);
        $imageName = $prefix.'.'.$image->getClientOriginalExtension();  
    
        Storage::disk('public')->putFileAs($folder.'/', $image,$imageName);
        
        return $imageName;
    }
}