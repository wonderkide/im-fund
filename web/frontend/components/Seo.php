<?php
namespace app\components;

use Yii;
use yii\base\Component;
use app\models\UrlModel;
use app\models\ContentModel;

class Seo extends Component {

    public function init() {
        parent::init();
    }

    public function loadUrl() {
        $model = UrlModel::find()->all();
        foreach ($model as $url) {
            $rule[$url->url] = $url->realpath;
        }
        Yii::$app->urlManager->rules = array_merge(Yii::$app->urlManager->rules, $rule);
        Yii::$app->urlManager->init();
    }

    public function getUrl($url) {
        if($url == '/'){
            return '/';
        }
        $model = UrlModel::find()->where(['realpath' => $url])->one();
        if (!empty($model)) {
            return '/' . $model->url;
        }
        return '/' . $url;
    }

    public function setUrlMetaTag() {
        $url = Yii::$app->controller->id . '/' . Yii::$app->controller->action->id;
        
        $title = Yii::$app->params['defaultTitle'];
        $description = Yii::$app->params['defaultPageDescription'];
        $keywords = Yii::$app->params['defaultPageKeywords'];
        
        $model_title = ContentModel::find()->where(['type' => 'title'])->one();
        if($model_title){
            $title = $model_title->content;
        }
        $model_keywords = ContentModel::find()->where(['type' => 'keywords'])->one();
        if($model_keywords){
            $keywords = $model_keywords->content;
        }
        $model_description = ContentModel::find()->where(['type' => 'description'])->one();
        if($model_description){
            $description = $model_description->content;
        }
        
        $model = UrlModel::find()->where(['realpath' => $url])->one();
        if (!empty($model)) {
            if (!empty($model->description)) {
                $description = $model->description;
            }
            if (!empty($model->keywords)) {
                $keywords = $model->keywords;
            }
            if (!empty($model->pagetitle)) {
                $title = $model->pagetitle;
            }
        }

        if (!empty($description)) {
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => $description
            ]);
        }
        if (!empty($keywords)) {
            Yii::$app->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $keywords
            ]);
        }

        return $title;
    }

    public static function formatMetaDescription($string) {

        return iconv_substr(trim(preg_replace('/\s\s+/', ' ', str_replace('&nbsp;', ' ', strip_tags(CHtml::decode($string))))), 0, 200, 'utf-8');
    }

    public static function formatUrl($str, $sep = '-') {
        $res = strtolower($str);
        $res = str_replace(array('$', '&', '+', ',', '/', ':', ';', '=', '?', '@'
            , '"', '<', '>', '#', '%', '{', '}', '|', '\\', '^', '~', '[', ']', '`'), '', $res);
        $res = preg_replace('/[[:space:]]+/', $sep, $res);

        return trim($res, $sep);
    }

    public static function getListStaticSitemap() {
        $list = array();
        $models = Sitemap::model()->findAllByAttributes(array('active' => '1'));
        foreach ($models as $model) {
            $oneSitemap = array();
            $oneSitemap['loc'] = Yii::app()->createAbsoluteUrl($model['loc']);
            if (!empty($model['frequency'])) {
                $oneSitemap['frequency'] = $model['frequency'];
            }
            if (!empty($model['priority'])) {
                $oneSitemap['priority'] = $model['priority'];
            }

            $list[] = $oneSitemap;
        }

        return $list;
    }

    public function handleRequest($request) {
        
    }

}
