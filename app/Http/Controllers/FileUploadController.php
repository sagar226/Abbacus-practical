<?php

namespace App\Http\Controllers;

use App\Category;
use App\DeliveryData;
use App\Exports\FileLogExport;
use App\FileLog;
use App\Imports\DeliveryImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class FileUploadController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function uploader(Request $request){
        
        $unique=$this->downloadFile($request->file);
        $path=config('filesystems.disks.public.root');
        $pathT=config('filesystems.disks.public.url');
        $url=$path.'/'.$unique;
    
        $uuid=time();
        Excel::import(new DeliveryImport($uuid),$url);
        
       $file=FileLog::where('uuid',$uuid)->count();
    //    if($file > 0 ){ 
    //        Excel::store(new FileLogExport($uuid), $uuid.'result.csv');
    //        $resultUrl=$pathT.'/'.$uuid.'result.csv';
    //        return view('category',['url' => $resultUrl,"response"=> "data imported succesfully"]);
    //    }
       return view('upload',['url' => "","response"=> "all data imported succesfully"]);
    }

}