<?php

namespace backend\modules\shoot\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use common\models\question\Question;
use common\models\shoot\ShootAppraiseTemplate;
use common\models\shoot\searchs\ShootAppraiseSearch;
/**
 * AppraiseController implements the CRUD actions for ShootAppraiseTemplate model.
 */
class AppraiseController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all ShootAppraiseTemplate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new \yii\data\ActiveDataProvider(
                [
                    'query' => ShootAppraiseTemplate::find()
                ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShootAppraiseTemplate model.
     * @param string $role_name
     * @param integer $q_id
     * @return mixed
     */
    public function actionView($role_name, $q_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($role_name, $q_id),
        ]);
    }

    /**
     * Creates a new ShootAppraiseTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShootAppraiseTemplate();
        $model->loadDefaultValues();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'roles' => $this->getRolesForSelect(),
                'questions' => $this->getQuestoinsForSelect(),
            ]);
        }
    }

    /**
     * Updates an existing ShootAppraiseTemplate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $role_name
     * @param integer $q_id
     * @return mixed
     */
    public function actionUpdate($role_name, $q_id)
    {
        $model = $this->findModel($role_name, $q_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'roles' => $this->getRolesForSelect(),
                'questions' => $this->getQuestoinsForSelect(),
            ]);
        }
    }

    /**
     * Deletes an existing ShootAppraiseTemplate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $role_name
     * @param integer $q_id
     * @return mixed
     */
    public function actionDelete($role_name, $q_id)
    {
        $this->findModel($role_name, $q_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ShootAppraiseTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $role_name
     * @param integer $q_id
     * @return ShootAppraiseTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($role_name, $q_id)
    {
        if (($model = ShootAppraiseTemplate::findOne(['role_name' => $role_name, 'q_id' => $q_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function getRolesForSelect()
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }
    
    protected function getQuestoinsForSelect()
    {
        return ArrayHelper::map(Question::find()->all(), 'id', 'title');
    }
}
