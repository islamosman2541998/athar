<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;



trait FileHandler
{

    public function download_file($path = '', $title = '')
    {
        $arr = explode('.', $path);
        $mimetype = $arr[count($arr) - 1];
        return response()->download($path, $title . '.' . $mimetype);
    }

    public function upload_file($file, $path = '', $key = "")
    {
        $imageName = time() . $key . '.' . $file->extension();
        return "attachments" . "/" . $file->store($path, 'attachment');
    }


    public function delete_file($path = '')
    {
        File::delete($path);
    }

    public function delete_dir($path = '')
    {
        File::deleteDirectory($path);
    }

    public function loadArrayFromFile($path)
    {
        return File::getRequire($path);
    }

    public function CopyFileContent($src, $target)
    {
        if ($this->FileExists($src))
            File::copy($src, $target);
    }

    public function PutFileContent($path, $content)
    {
        File::put($path, $content);
    }

    public function GetFileContent($path)
    {
        return File::get($path);
    }

    public function FileExists($path)
    {
        return File::exists($path);
    }

    /***************basma*******************/
    //1
    // 
    
    function storeImage2($request, string $path, $requestName, string $name, int $key = 0)
{
    if ($requestName instanceof UploadedFile) {
        $file = $requestName;
    } elseif ($request->hasFile($name)) {
        $file = $request->file($name);
    } else {
        return null;
    }

    if (! $file->isValid()) {
        return null;
    }

    $ext = $file->getClientOriginalExtension();
    $newFileName = time() . "_{$key}." . $ext;

    $relativePath = trim($path, '/');
    $fullDir = public_path($relativePath);
    if (! File::isDirectory($fullDir)) {
        File::makeDirectory($fullDir, 0755, true);
    }

    $source = $file->getRealPath();
    $dest   = $fullDir . DIRECTORY_SEPARATOR . $newFileName;
    if (! @copy($source, $dest)) {
        $file->move($fullDir, $newFileName);
    }

    return $newFileName;
}

protected function storeMedia($file, $path)
{
    
    $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
    $file->storeAs('public' . $path, $filename); 
    
    return $filename;
}


protected function deleteMedia($filename)
{
    if (! $filename) return;
    $full = public_path($this->slider_path . $filename);
    if (file_exists($full)) {
        @unlink($full);
    }
    
}

function storePocketImage($file, $path, $key = 0)
{
    if (!$file->isValid()) {
        return null;
    }

    $ext = $file->getClientOriginalExtension();
    $newFileName = md5(uniqid() . time() . $key) . '.' . $ext;

    $relativePath = trim($path, '/');
    $fullDir = public_path($relativePath);
    
    if (!File::isDirectory($fullDir)) {
        File::makeDirectory($fullDir, 0755, true);
    }

    $source = $file->getRealPath();
    $dest = $fullDir . DIRECTORY_SEPARATOR . $newFileName;
    
    if (!@copy($source, $dest)) {
        $file->move($fullDir, $newFileName);
    }

    return $newFileName;
}

//     function storeImage2($request, string $path, $requestName, string $name, int $key = 0)
// {
//     if ($requestName instanceof UploadedFile) {
//         $file = $requestName;

//     } elseif ($request->hasFile($name)) {
//         $file = $request->file($name);

//     } else {
//         return null;
//     }

//     $newFileName = time() . $key . '.' . $file->getClientOriginalExtension();

//     $file->move(public_path($path), $newFileName);

//     return $newFileName;
// }


// function storeImage2($request, $path, $file, $key = 0)
// {
//     if ($file instanceof \Illuminate\Http\UploadedFile) {
//         $newfile = time() . $key . '.' . $file->getClientOriginalExtension();
//         $file->move(public_path() . $path, $newfile);
//         return $newfile;
//     }
//     return null;
// }



    /*******************/

    function deleteImage($model, $name)
    {
        if (   !(is_dir(public_path() . $model->path() . ($model->$name)))   &&  file_exists(public_path() . $model->path() . ($model->$name))) {
            unlink(public_path() . $model->path() . ($model->$name));
        }
    }
    /***********************/
    /*******************/

    function deleteImageOfGallery($path, $model, $name )
    {

        if (file_exists(public_path() . $path . $model->$name ) && !is_dir(public_path() . $path . $model->$name )) {
            unlink(public_path()  . $path . $model->$name);
        }
    }
    /***********************/
    function updateImage( $request , $model  , $path , $requestName , $name )
    {

                  if(isset($requestName )  ) {

                    if ($request->file($name)) {


                        if ($request->file($name)) {
                            $file = $request->file($name);
                            $newfile = time() . '.' . $file->getClientOriginalExtension();
                            $file->move(public_path() . $path, $newfile);

                            if ($model->$name  != null) {
                                if (@getimagesize((public_path() . $path . '/' . ($model->$name )))) {
                                    unlink(public_path() . $path . '/' . ($model->$name ));
                                }
                            }
                        }
                    }
                }
         return $newfile ;


    }


    function updateImageMulti( $request , $model , $id , $path , $requestName , $name )
    {

        $newfileAll = [];
        $idAll = [];
        if($requestName) {
            foreach ($requestName as $key => $val) {
                if(isset($requestName[$key]) && isset($request->id[$key]) ) {

                    if (isset($request->file($name)[$key])) {

                        $managements = $model::where('id', (int)$request->id[$key])->first();

                        if (isset($request->file($name)[$key])) {
                            $file = $request->file($name)[$key];
                            $newfile = time() .$key . '.' . $file->getClientOriginalExtension();
                            $file->move(public_path() . $path, $newfile);
                            $newfileAll[] = $newfile;
                            $idAll[] = $request->id[$key];

                            if ($managements->$name  != null) {
                                if (@getimagesize((public_path() . $path . '/' . ($managements->$name )))) {
                                    unlink(public_path() . $path . '/' . ($managements->$name ));
                                }
                            }
                        }
                    }
                }
            }
        }
        return [$newfileAll , $idAll];


    }


    /*************************/


    function storeImageMulti($request , $path , $requestName , $name)
    {
        $newfileAll = [];
        foreach ($requestName as $key => $val) {

            if(isset($requestName[$key])) {
                if (isset($request->file($name)[$key])) {
                    $file = $request->file($name)[$key];
                    $newfile = time().$key . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . $path, $newfile);
                    $newfileAll[] = $newfile;
                }
            }
        }
        return $newfileAll;
    }
}
