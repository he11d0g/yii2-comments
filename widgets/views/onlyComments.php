<?php
use yii\widgets\ListView;

 echo ListView::widget([
    'dataProvider' => $comments,
    'itemView' => '_oneComment',
    'summary' => false
]);

