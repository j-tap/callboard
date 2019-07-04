<?php

namespace App\Models\Org;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelFileUpload;
use App\Traits\ApiControllerTrait;

class ImagesDeals extends Model
{
    
    use ModelFileUpload;
    use ApiControllerTrait;
    
    protected $table = 'images_deals';
    protected $fillable = [
        'file_name',
        'file_name_ext',
        'file_full_path',
        'size',
        'user_upload',
    ];

    
    static protected $sortable = ['id', 'deal_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deal()
    {
        return $this->belongsTo(\App\Models\Org\OrganizationDeal::class, 'deal_id'); // обратное отношение , местный внешний ключ  deal_id
    }

    public function uploadFileAndSaveToDB($image,  $userId, $dealId , $resizeValMaxPx = null)
    {

        try{

            $arrToImportTable = $this->uploadImageToStore($image, 'users/' . $userId . '/deals/' . $dealId . '/images', $resizeValMaxPx);

            if(isset( $arrToImportTable['file_name']) and isset( $arrToImportTable['file_full_path'])){
                $this->deal_id = $dealId;
                $this->user_id = $userId;
                $this->file_name        = $arrToImportTable['file_name'];
                $this->file_full_path   = $arrToImportTable['file_full_path'];
                $this->save();
                return true;
            }
    
            return false;
        }
        catch(\Exception $e){
            // return $this->errorResponse($e->getMessage());
            false;
		}
      
    }

    public function deleteImageDeal($id)
    {
        try{

            $path = $this->file_full_path;
            if(!$this->deleteImageFromStore($path)){
                return false;
            }

            return true;
        }
        catch(\Exception $e){
            //return $this->errorResponse($e->getMessage());
            false;
		}

    }
}
