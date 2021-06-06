<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use \yii\web\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UploadFile extends Model
{
    public $file;
    public $date;
    public $end_date;
    public $upload_folder ='uploads';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date'], 'safe'],
            [['file'], 'file', 'extensions' => 'xlsx, xls', 'maxSize' => 1024 * 1024 * 5/*, 'skipOnEmpty' => true*/],
            //[['file'] , 'check_file_existe'],
            [['end_date'], 'required', 'on' => 'end_date']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        
    }
    
    public function check_file_existe($attribute, $params){
        //exit();
        //var_dump($attribute);exit();
        //$this->addError('date', 'sss');
        //$this->addError($attribute, 'Email นี้ได้ถูกใช้ไปแล้ว.');
    }


    public function upload($model, $attribute, $folder = null)
    {
        $photo  = UploadedFile::getInstance($model, $attribute);

        $fileName = false;
        if ($photo !== null) {
            $path = $this->getUploadPath($folder);
            
            if(!is_dir($path)){
                mkdir ($path);
                chmod ($path, 0777);
            }

            $fileName = time() . '_' . md5($photo->baseName) . '.' . $photo->extension;

            if($photo->saveAs($path.$fileName)){
                if($folder){
                    //return '/'.$this->upload_folder.'/'.$folder.'/'.$fileName;
                }
                //return '/'.$this->upload_folder.'/'.$fileName;
                
            }
        }
        return $fileName;
    }
    
    public function getUploadPath($folder){
        if($folder){
            return Yii::getAlias('@app').'/web/'.$this->upload_folder.'/'.$folder.'/';
        }
        return Yii::getAlias('@app').'/web/'.$this->upload_folder.'/';
    }
    
    public function remove_file($filename, $folder = null){
        $path = $this->getUploadPath($folder);
        if (file_exists($path.$filename)) {
            unlink($path.$filename);
        }
    }
    
    public function loadSpreadSheet($filename, $folder = null) {
        $upload = new UploadFile();
        
        $explode = explode('.', $filename);
        $inputFileType = ucfirst($explode[count($explode)-1]);
        $path = /*Yii::getAlias('@app').'/web'.*/ $upload->getUploadPath($folder).$filename;

        $reader = IOFactory::createReader($inputFileType);
        $spreadsheet = $reader->load($path);
        $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        
        return $data;
    }
    
}