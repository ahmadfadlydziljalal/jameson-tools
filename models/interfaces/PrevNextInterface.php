<?php

namespace app\models\interfaces;

interface PrevNextInterface
{
    public function getPrevious();

    public function getNext();
}