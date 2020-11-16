<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace kerneldos\extmodule\generators\module;

use yii\gii\CodeFile;
use yii\helpers\StringHelper;

/**
 * This generator will generate the skeleton code needed by a module.
 *
 * @property string $controllerNamespace The controller namespace of the module. This property is read-only.
 * @property bool $modulePath The directory that contains the module class. This property is read-only.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\generators\module\Generator {
    public $bootstrap;
    public $default;

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'Extend Module Generator';
    }

    public function rules() {
        return array_merge(parent::rules(), [
            [['bootstrap', 'default'], 'boolean'],
            [['bootstrap', 'default'], 'default', 'value' => false],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function generate() {
        $modulePath = $this->getModulePath();

        $files = [
            [
                'path'    => $modulePath . '/' . StringHelper::basename($this->moduleClass) . '.php',
                'content' => $this->render("module.php"),
            ],
            [
                'path'    => $modulePath . '/controllers/backend/DefaultController.php',
                'content' => $this->render("controller.php", ['template' => 'backend']),
            ],
            [
                'path'    => $modulePath . '/controllers/frontend/DefaultController.php',
                'content' => $this->render("controller.php", ['template' => 'frontend']),
            ],
            [
                'path'    => $modulePath . '/views/backend/default/index.php',
                'content' => $this->render("view.php"),
            ],
            [
                'path'    => $modulePath . '/views/frontend/default/index.php',
                'content' => $this->render("view.php"),
            ],
            [
                'path'    => $modulePath . '/config/config.php',
                'content' => $this->render("config.php"),
            ],
        ];

        $generate = [];
        foreach ($files as $file) {
            $generate[] = new CodeFile($file['path'], $file['content']);
        }

        return $generate;
    }
}
