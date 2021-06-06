<?php

namespace app\components;

use Yii;
use \yii\web\UploadedFile;
use yii\imagine\Image;

class UploadImage {
    
    public $upload_folder ='uploads/img';
    
    public function upload($model, $attribute, $column, $folder = null)
    {
        $photo  = UploadedFile::getInstance($model, $attribute);

        
        if ($photo !== null) {
            $path = $this->getUploadPath($folder);
            
            //var_dump($path);exit();
            if(!is_dir($path)){
                mkdir ($path);
                chmod ($path, 0777);
            }

            $fileName = time() . '_' . str_replace($folder, '', $photo->baseName) . '.' . $photo->extension;

            if($photo->saveAs($path.$fileName)){
                if(!$model->isNewRecord && $model->$column && file_exists(Yii::getAlias('@webroot').'/' . $model->$column)){
                    unlink(Yii::getAlias('@webroot').'/'. $model->$column);
                }
                if($folder){
                    return '/'.$this->upload_folder.'/'.$folder.'/'.$fileName;
                }
                return '/'.$this->upload_folder.'/'.$fileName;
            }
        }
        return $model->isNewRecord ? false : $model->getOldAttribute($column);
        
    }
    
    public function getUploadPath($folder){
        if($folder){
            return Yii::getAlias('@webroot').'/'.$this->upload_folder.'/'.$folder.'/';
        }
        return Yii::getAlias('@webroot').'/'.$this->upload_folder.'/';
    }

    /*public function getUploadUrl(){
        return Yii::getAlias('@web').'/'.$this->upload_folder.'/';
    }*/
    
    public function upload_thumbnail($img, $folder, $width = 50, $height = 50){
        $path = Yii::getAlias('@webroot').'/'.$this->upload_folder;
        
        $path_thumb = $path . '/'.$folder.'/thumbnail';
        
        if(!is_dir($path_thumb)){
            mkdir ($path_thumb);
            chmod ($path_thumb, 0777);
        }
        $thumbnail = str_replace($folder,$folder."/thumbnail",$img);
        
        // Generate a thumbnail image
        Image::thumbnail($path.$img, $width, $height)->save($path.$thumbnail, ['quality' => 80]);
    }
    
}
