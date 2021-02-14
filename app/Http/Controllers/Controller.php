<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function successResponse($data){       
        return response()->json([
            "error" => false,
            "data" => $data
        ],200);
    }

    public static function getUniqueFileName($fileExt="",$suffix = null){
        return isset($suffix) ? Carbon::now()->timestamp."_$suffix".$fileExt : Carbon::now()->timestamp.$fileExt;
   }

   public static function downloadFile($file){
        $filename = str_replace(' ','_',pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $uniqueName=self::getUniqueFileName(".".$file->getClientOriginalExtension(),$filename);
        Storage::put($uniqueName, file_get_contents($file));
        return $uniqueName;          

   }
   public function deleteFile($fileName){
        return Storage::delete($fileName);
   }



}
