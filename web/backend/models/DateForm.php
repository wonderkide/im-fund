<?php

namespace backend\models;

use Yii;
use yii\base\Model;

class DateForm extends Model
{
    public $date;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            ['date', 'safe'],
        ];
    }

}
