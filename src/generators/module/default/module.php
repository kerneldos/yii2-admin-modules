<?php
/**
 * This is the template for generating a module class file.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */

$className = $generator->moduleClass;
$pos = strrpos($className, '\\');
$ns = ltrim(substr($className, 0, $pos), '\\');
$className = substr($className, $pos + 1);

echo "<?php\n";
?>

namespace <?= $ns ?>;

use yii\base\BootstrapInterface;
use yii\web\Application;

/**
 * <?= $generator->moduleID ?> module definition class
*/
class <?= $className ?> extends \yii\base\Module implements BootstrapInterface
{
    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        // TODO: Implement bootstrap() method.
    }

    /**
     * Initializes the module.
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        \Yii::configure($this, require __DIR__ . '/config/config.php');
    }
}
