<?php

namespace app\controllers;

use Yii;
use app\models\Week;
use app\models\WeekSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Month;
/**
 * WeekController implements the CRUD actions for Week model.
 */
class WeekController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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
     * Lists all Week models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WeekSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Week model.
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
     * Creates a new Week model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Week();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Week model.
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
     * Deletes an existing Week model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Week model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Week the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Week::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSetweek(){
        $yearNow = date("Y");
        $sql = "SELECT MAX(year) as year FROM week";
        $rs = Yii::$app->db->createCommand($sql)->queryOne();
        if($rs['year'] > $yearNow || $rs['year'] == ""){
            $dateLastweek = $yearNow."-12-31";
            $sqlCountWeek = "SELECT WEEK('$dateLastweek') AS lastweek";

            $rss = Yii::$app->db->createCommand($sqlCountWeek)->queryOne();
            $lastweek = ($rss['lastweek'] + 1);
            for($i=1;$i<=$lastweek;$i++):
                $date = new \DateTime();
                $date->setISODate($yearNow,$i);
                $start = $date->format("Y-m-d");
                $date->setISODate($yearNow,$i,7);
                $end = $date->format("Y-m-d");

                //echo "สัปดาห์ที่".$i."ประกอบด้วยวันที่ : ".$start." - ".$end."<br/>";

                $columns = array(
                    'year' => $yearNow,
                    'datestart' => $start,
                    'dateend' => $end,
                    'week' => $i
                    );
                Yii::$app->db->createCommand()
                            ->insert("week",$columns)
                            ->execute();
            endfor;
        }
    }
}
