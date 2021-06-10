<?php
namespace app\components;

use yii\web\UrlRuleInterface;
use yii\base\Object;
use app\models\UrlModel;

class UrlRules extends Object implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params)
    {
        //var_dump($manager);exit();
        /*if ($route === 'car/index') {
            if (isset($params['manufacturer'], $params['model'])) {
                return $params['manufacturer'] . '/' . $params['model'];
            } elseif (isset($params['manufacturer'])) {
                return $params['manufacturer'];
            }
        }*/
        return false;  // this rule does not apply
    }

    public function parseRequest($manager, $request)
    {
        
        //var_dump($this->getRealpath($request->getPathInfo()));exit();
        //var_dump($request->getPathInfo());exit();
        return [$this->getRealpath($request->getPathInfo()),[]];

        /*$pathInfo = $request->getPathInfo();
        if (preg_match('%^(\w+)(/(\w+))?$%', $pathInfo, $matches)) {
            // check $matches[1] and $matches[3] to see
            // if they match a manufacturer and a model in the database
            // If so, set $params['manufacturer'] and/or $params['model']
            // and return ['car/index', $params]
        }
        return false;  // this rule does not apply*/
    }
    public function getRealpath($url) {
        $find = substr($url, -1);
        if($find == '/'){
            $url = str_replace("/","", $url);
        }
        $model = UrlModel::find()->where(['url' => $url])->one();
        if (!empty($model)) {
            return $model->realpath;
        }
        return $url;
    }
}