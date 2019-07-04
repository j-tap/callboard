<?php
/**
 * Created by black40x@yandex.ru
 * Date: 06/12/2018
 */

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Image;
use File;

trait ModelFileUpload
{

    public function resizeAndStoreImage($file, $path, $resizeValMaxPx = 1200){

        try{
            //get filename with extension
            $filenamewithextension = $file->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $file->getClientOriginalExtension();

            //filename to store
            $filenametostore = uniqid($filename . '_').'.'.$extension;

            $imagePath = public_path() . config('filesystems.disks.local.prefix') . $path;

            $localPath = config('filesystems.disks.local.prefix') . $path . '/' . $filenametostore;

            $fullLocalName = public_path() . $localPath ;

            // $OsVersion  = substr(PHP_OS, 0, 3) == "WIN" ? "Windows" : "Unix";

            $img = Image::make($file->getPathName());

            $height = $img->height();
            $width = $img->width();
            
            //    dd(['height' =>$height, 'width' =>  $width ]);
            if($height >= ($resizeValMaxPx +1)) {
                $img->resize( null, $resizeValMaxPx, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            if($width >= ($resizeValMaxPx + 1)) {
                $img->resize($resizeValMaxPx, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
          // dd( $imagePath);
            if (!File::exists($imagePath)) {
                File::makeDirectory($imagePath,0775,true);
            }
            
            $img->save($fullLocalName);

            return $localPath;
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
            false;
        }
    }

    function uploadFile(Request $request, $filename, $path, $default = null, $resizeValMaxPx = null )
    {
        try{
  
            if ($request->file($filename)) {

                $file = $request->file($filename);

                if($resizeValMaxPx === null){
                    $path = $file->store($path);
                    $name = $file->getClientOriginalName();
                    return config('filesystems.disks.local.prefix') . $path;
                }

                return $this->resizeAndStoreImage($file, $path, $resizeValMaxPx);

            }

            return $default;
        }
        catch(\Exception $e){
           // return $this->errorResponse($e->getMessage());
            false;
        }
    }

    function uploadImageToStore($image, $path,  $resizeValMaxPx = null)
    {
        try{

            $arrToImportTable = [];   

            if($resizeValMaxPx === null){
                $localStorePath = $image->store( $path );

                $arrToImportTable = [
                        'file_name' => $image->getClientOriginalName(),
                        'file_full_path' =>  config('filesystems.disks.local.prefix') . $localStorePath // $image->store( $path ),
                ];
                
                return $arrToImportTable;
            }
           
        //    dd($this->resizeAndStoreImage($image, $path, $resizeValMaxPx));
            $retArr =  [
                'file_name' => $image->getClientOriginalName(),
                'file_full_path' =>  $this->resizeAndStoreImage($image, $path, $resizeValMaxPx)
            ];
               
            return $retArr;
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
            false;
		}

    }

    function deleteImageFromStore($path)
    {
        try{
            return unlink(public_path($path));            
        }
        catch(\Exception $e){
            //return $this->errorResponse($e->getMessage());
            false;
		}
    }
}