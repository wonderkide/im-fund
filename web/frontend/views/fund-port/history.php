<?php
use yii\bootstrap4\Tabs;

$this->title = 'ประวัติ  : ' . $port->name;
$this->params['breadcrumbs'][] = ['label' => $port->name, 'url' => ['/fund-port/detail', 'id' => $port->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php
echo Tabs::widget([
    'items' => [
        [
            'label' => 'รายวัน',
            'content' => $this->render('_history_tab', ['history' => $history['d'], 'port' => $port]),
            'active' => true
        ],
        [
            'label' => 'รายเดือน',
            'content' => $this->render('_history_tab', ['history' => $history['m'], 'port' => $port]),
            //'headerOptions' => [...],
            //'options' => ['id' => 'myveryownID'],
        ],
        [
            'label' => 'รายปี',
            'content' => $this->render('_history_tab', ['history' => $history['y'], 'port' => $port]),
        ],
    ],
]);
?>


