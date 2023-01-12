<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class NoteForm extends Model
{
    public $note;

    public function rules()
    {
        return [
            //['note', 'trim'],
            ['note', 'string'],
        ];
    }
}
