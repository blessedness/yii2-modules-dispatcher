<?php

namespace app\modules\dispatcher\models;

use Yii;

/**
 * This is the model class for table "{{%layout_module}}".
 *
 * @property integer $id
 * @property integer $layout_id
 * @property string $module
 * @property integer $status
 * @property string $position
 * @property integer $sort_order
 */
class LayoutModule extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%layout_module}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['layout_id', 'module', 'position'], 'required'],
            [['layout_id', 'status', 'sort_order'], 'integer'],
            [['module'], 'string', 'max' => 150],
            [['position'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'layout_id' => 'Layout ID',
            'module' => 'Module',
            'status' => 'Status',
            'position' => 'Position',
            'sort_order' => 'Sort Order',
        ];
    }
}
