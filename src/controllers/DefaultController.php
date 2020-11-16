<?php

namespace kerneldos\extmodule\controllers;

use kerneldos\extmodule\generators\module\Generator;
use kerneldos\extmodule\models\Module;

use Yii;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller {
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Module models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Module::find()->indexBy('id'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Module model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Module model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Module();

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            $generator = new Generator([
                'moduleID' => $model->name,
                'moduleClass' => $model->class,
                'bootstrap' => $model->is_bootstrap,
                'default' => $model->is_main,
            ]);

            if ($generator->validate()) {
                $files = $generator->generate();
                $results = '';
                $answers = [];

                if ( !empty($files) ) {
                    foreach ($files as $file) {
                        $answers[$file->id] = true;
                    }
                    $generator->save($files, $answers, $results);
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Module model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Module model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\base\ErrorException
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $moduleName = $model->name;

        if ( $model->delete() ) {
            FileHelper::removeDirectory(Yii::getAlias('@app/modules/' . $moduleName));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Module model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Module the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Module::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
