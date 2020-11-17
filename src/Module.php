<?php


namespace kerneldos\extmodule;

use yii\base\Application;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $id = 'admin';

    /**
     * {@inheritdoc}
     */
    public $layout = 'admin';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'kerneldos\extmodule\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
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
     * @inheritDoc
     * @throws \yii\base\InvalidConfigException
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\console\Application) {
            return;
        }

        $hasInstance = false;
        foreach ($app->getModules() as $id => $module) {
            $obj = \Yii::createObject($module);

            if ($obj instanceof $this) {
                $hasInstance = true;
                $this->id = $id;
                break;
            }
        }

        if (!$hasInstance) {
            $app->setModule($this->id, ['class' => 'kerneldos\extmodule\Module']);
        }

        $modules = \kerneldos\extmodule\models\Module::find()
            ->where(['is_active' => true])
            ->indexBy('name')
            ->asArray()
            ->all();

        $baseNamespace = 'app\\modules';
        $frontendNamespace = 'controllers\\frontend';
        $backendNamespace = 'controllers\\backend';

        foreach ($modules as $name => $module) {
            $app->setModule($name, [
                'class' => $module['class'],
                'controllerNamespace' => join('\\', [$baseNamespace, $name, $frontendNamespace]),
                'viewPath' => "@app/modules/$name/views/frontend",
            ]);
            $app->getModule($this->id)->setModule($name, [
                'class' => $module['class'],
                'controllerNamespace' => join('\\', [$baseNamespace, $name, $backendNamespace]),
                'viewPath' => "@app/modules/$name/views/backend",
            ]);

            if ($module['is_bootstrap']) {
                $app->bootstrap[] = $name;
            }

            if ($module['is_main']) {
                $app->getUrlManager()->addRules(['' => $name], false);
            }

            $app->view->params['menuItems'][] = [
                'label' => ucwords($name),
                'url' => "/$this->id/$name",
            ];
        }

        $this->setUrlRules($app);
    }

    /**
     * @param Application $app
     */
    protected function setUrlRules($app)
    {
        $app->getUrlManager()->addRules([
            [
                'class' => 'yii\web\GroupUrlRule',
                'prefix' => $this->id,
                'rules' => [
                    '' => 'default/index',

                    '<_a:create>'                   => 'default/<_a>',
                    '<_a:view|update|delete>/<id>'  => 'default/<_a>',

                    '<module>/<_a:view|update|delete>/<id>' => '<module>/default/<_a>',

                    '<module>'                          => '<module>/default/index',
                    '<module>/<controller>'             => '<module>/<controller>/index',
                    '<module>/<controller>/<action>'    => '<module>/<controller>/<action>',
                ],
            ],

            '<module>'                          => '<module>/default/index',
            '<module>/<controller>'             => '<module>/<controller>/index',
            '<module>/<controller>/<action>'    => '<module>/<controller>/<action>',
        ]);
    }
}
