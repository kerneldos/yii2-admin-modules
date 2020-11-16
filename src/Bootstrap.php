<?php


namespace kerneldos\extmodule;


use kerneldos\extmodule\models\Module;
use yii\base\Application;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface {
    public $id = 'admin';

    /**
     * @inheritDoc
     * @throws \yii\base\InvalidConfigException
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\console\Application) {
            return false;
        }

        $hasInstance = false;
        foreach ($app->getModules() as $id => $module) {
            $obj = \Yii::createObject($module);

            if ($obj instanceof \kerneldos\extmodule\Module) {
                $hasInstance = true;
                $this->id = $id;
                break;
            }
        }

        if (!$hasInstance) {
            $app->setModule($this->id, ['class' => 'kerneldos\extmodule\Module']);
        }

        $modules = Module::find()
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