<?php

namespace app\widgets\prev_next_navigation;

use app\models\interfaces\PrevNextInterface;
use yii\base\InvalidArgumentException;
use yii\base\Widget;

class PrevNextNavigationWidget extends Widget
{

    public PrevNextInterface $model;
    public int $isPjax = 0;


    public function init()
    {
        parent::init();

        if (!$this->model) {
            throw new InvalidArgumentException('Model is required');
        }
    }

    public function run()
    {
        return $this->render('index', [
            'model' => $this->model,
            'isPjax' => $this->isPjax,
        ]);
    }

}