<?php


use yii\grid\GridView;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'd1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7',
    ],
]);


