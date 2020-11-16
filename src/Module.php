<?php


namespace kerneldos\extmodule;


class Module extends \yii\base\Module {
    public $layout = 'admin';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'kerneldos\extmodule\controllers';

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();

        if (($gii = \Yii::$app->getModule('gii')) !== null) {
            \Yii::configure($gii, [
                'generators' => [
                    'extModule' => 'kerneldos\extmodule\generators\module\Generator',
                ],
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action) {
        foreach ($this->getModules() as $name => $module) {
            \Yii::$app->view->params['menuItems'][] = [
                'label' => ucwords($name),
                'url' => "/$this->id/$name",
            ];
        }

        return parent::beforeAction($action);
    }
}
