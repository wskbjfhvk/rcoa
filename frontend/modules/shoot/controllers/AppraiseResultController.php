<?php

namespace frontend\modules\shoot\controllers;

use Yii;
use common\models\shoot\ShootAppraiseResult;
use common\models\shoot\searchs\ShootAppraiseResultSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AppraiseResultController implements the CRUD actions for ShootAppraiseResult model.
 */
class AppraiseResultController extends Controller
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
     * Lists all ShootAppraiseResult models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShootAppraiseResultSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShootAppraiseResult model.
     * @param integer $b_id
     * @param integer $u_id
     * @return mixed
     */
    public function actionView($b_id, $u_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($b_id, $u_id),
        ]);
    }

    /**
     * Creates a new ShootAppraiseResult model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShootAppraiseResult();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'b_id' => $model->b_id, 'u_id' => $model->u_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ShootAppraiseResult model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $b_id
     * @param integer $u_id
     * @return mixed
     */
    public function actionUpdate($b_id, $u_id)
    {
        $model = $this->findModel($b_id, $u_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'b_id' => $model->b_id, 'u_id' => $model->u_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ShootAppraiseResult model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $b_id
     * @param integer $u_id
     * @return mixed
     */
    public function actionDelete($b_id, $u_id)
    {
        $this->findModel($b_id, $u_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ShootAppraiseResult model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $b_id
     * @param integer $u_id
     * @return ShootAppraiseResult the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($b_id, $u_id)
    {
        if (($model = ShootAppraiseResult::findOne(['b_id' => $b_id, 'u_id' => $u_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
