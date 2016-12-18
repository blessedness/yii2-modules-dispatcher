<?php

namespace app\modules\dispatcher;

use app\modules\dispatcher\components\Controller;
use app\modules\dispatcher\models\LayoutModule;

/**
 *
 * Class Module
 * @package app\modules\dispatcher\components
 *
 */
class BasicModule extends \yii\base\Module
{
    const POSITION_HEADER = 'header';
    const POSITION_FOOTER = 'footer';
    const POSITION_LEFT = 'left';
    const POSITION_RIGHT = 'right';

    /**
     * @var array of positions
     */
    static protected $positions = [
        self::POSITION_HEADER,
        self::POSITION_FOOTER,
        self::POSITION_LEFT,
        self::POSITION_RIGHT,
    ];

    /**
     * @var string controller name
     */
    public $defaultControllerName = 'DefaultController';

    /**
     * @var string dir of modules catalog
     */
    public $modulesDir = 'catalog';

    /**
     * @var string modules namespace
     */
    private $_modulesNamespace;

    /**
     * @var string absolute path to modules dir
     */
    public $modulePath;

    /**
     *
     * @throws \yii\base\InvalidParamException
     */
    public function init()
    {
        parent::init();

        $this->_setModuleVariables();

        $this->loadModules();
    }

    /**
     * Load modules from directory by path
     * @throws \yii\base\InvalidParamException
     */
    protected function loadModules()
    {
        $handle = opendir($this->modulePath);

        while (($dir = readdir($handle)) !== false) {
            if ($dir === '.' || $dir === '..') {
                continue;
            }

            $class = $this->_modulesNamespace . '\\' . $dir . '\\Module';

            if (class_exists($class)) {
                $this->modules = [
                    $dir => [
                        'class' => $class,
                    ],
                ];
            }
        }

        closedir($handle);
    }

    /**
     * @param $layout
     * @param array $positions
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function run($layout, array $positions = [])
    {
        $model = $this->findModel($layout, $positions);

        $data = [];

        foreach ($model as $item) {
            if ($controller = $this->findModuleController($item['module'])) {
                $data[$item['position']][] = \Yii::createObject($controller, [$item['module'], $this])->index();
            }
        }

        return $data;
    }

    /**
     * @param $layout_id
     * @param array $positions
     * @return array|\yii\db\ActiveRecord[]
     * @internal param $layout
     */
    public function findModel($layout_id, array $positions = [])
    {
        if (empty($positions)) {
            $positions = self::$positions;
        }

        return LayoutModule::find()
            ->where([
                'layout_id' => $layout_id,
                'position' => $positions,
                'status' => LayoutModule::STATUS_ACTIVE,
            ])->orderBy([
                'sort_order' => SORT_ASC
            ])->asArray()->all();
    }

    /**
     * @param $name
     * @return null|string
     */
    public function findModuleController($name)
    {
        $className = $this->_modulesNamespace . '\\' . $name . '\controllers\\' . $this->defaultControllerName;

        return is_subclass_of($className, Controller::class) ? $className : null;
    }

    /**
     * Set modules namespace and path
     */
    private function _setModuleVariables()
    {
        $class = new \ReflectionClass($this);
        $this->_modulesNamespace = $class->getNamespaceName() . '\\' . $this->modulesDir;
        $this->modulePath = dirname($class->getFileName()) . DIRECTORY_SEPARATOR . $this->modulesDir;
    }
}