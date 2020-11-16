<?php

namespace kerneldos\extmodule\models;

use yii\db\Expression;

/**
 * This is the model class for table "module".
 *
 * @property int $id
 * @property string $name
 * @property string $class
 * @property int|null $is_active
 * @property int|null $is_bootstrap
 * @property int|null $is_main
 * @property string $created_at
 * @property string $updated_at
 */
class Module extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%module}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            [
                'class' => 'yii\behaviors\TimestampBehavior',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'class', 'created_at', 'updated_at'], 'required'],
            [['is_active', 'is_bootstrap', 'is_main'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'class'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['class'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'class' => 'Class',
            'is_active' => 'Is Active',
            'is_bootstrap' => 'Is Bootstrap',
            'is_main' => 'Is Main',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
