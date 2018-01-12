<?php

namespace app\controllers;

use Yii;
use app\models\Roleuser;
use app\models\RoleuserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Rolepcu;

/**
 * RoleuserController implements the CRUD actions for Roleuser model.
 */
class RoleuserController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Roleuser models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new RoleuserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Roleuser model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($userid) {
        $data['user'] = \dektrium\user\models\User::findOne(['id' => $userid]);
        $data['roleuser'] = Roleuser::findOne(['user_id' => $userid]);
        $data['rolepcu'] = Rolepcu::findAll(['groupid' => $data['roleuser']['group_id']]);
        $data['userid'] = $userid;
        return $this->render('view', $data);
    }

    /**
     * Creates a new Roleuser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCheck($userid) {
        $check = Roleuser::findOne(['user_id' => $userid]);
        if ($check['user_id'] != "") {
            //$this->actionUpdate($check['id']);
            $this->redirect(['roleuser/update', 'id' => $check['id']]);
        } else {
            //$this->actionCreate($userid);
            $this->redirect(['roleuser/create', 'userid' => $userid]);
        }
    }

    public function actionCreate($userid) {
        $model = new Roleuser();
        $user = \dektrium\user\models\User::findOne(['id' => $userid]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'userid' => $userid,
                    'model' => $model,
                    'user' => $user
        ]);
    }

    /**
     * Updates an existing Roleuser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $user = \dektrium\user\models\User::findOne(['id' => $model->user_id]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
                    'user' => $user
        ]);
    }

    /**
     * Deletes an existing Roleuser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Roleuser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Roleuser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Roleuser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
