<?php

/**
 * @var $leftItems array
 * */
/* @var $this yii\web\View */

use app\widgets\SideMenu as Menu;


?>

<aside class="sidebar" id="side-nav">

    <?php
    try {
        echo Menu::widget([
            'activateParents' => true,
            'encodeLabels' => false,
            'options' => [
                'class' => 'sidebar-nav'
            ],
            'items' => $leftItems,
        ]);
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>

</aside>