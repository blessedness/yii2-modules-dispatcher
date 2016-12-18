<?php

namespace app\modules\dispatcher\catalog\test\controllers;

use app\modules\dispatcher\components\Controller;

/**
 * Default controller for the `test` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\ViewNotFoundException
     * @throws \yii\base\InvalidCallException
     */
    public function index()
    {
        return $this->render('index');
    }
}
