<?php

namespace app\modules\dispatcher\components;

use yii\base\Object;

class Dispatcher extends Object
{
    /**
     * @var \app\modules\dispatcher\Module
     */
    private $_module;

    public $module = 'dispatcher';

    /**
     * Dispatcher constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->_module = \Yii::$app->getModule($this->module);
    }

    /**
     * Get modules by layout
     *
     * @param $layout
     * @param array $positions
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function modules($layout, array $positions = [])
    {
        return $this->_module->run($layout, $positions);
    }
}