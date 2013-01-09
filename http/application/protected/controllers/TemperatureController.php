<?php

class TemperatureController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

        public $defaultAction='admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
//			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Temperature;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Temperature']))
		{
			$model->attributes=$_POST['Temperature'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Temperature']))
		{
			$model->attributes=$_POST['Temperature'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Temperature');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Temperature('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Temperature']))
			$model->attributes=$_GET['Temperature'];

                $graph=new Temperature('listforgraph');
                $graph->unsetAttributes();  // clear any default values
                if(isset($_GET['Temperature']))
                        $model->attributes=$_GET['Temperature'];

//
            $this->render('admin',array(
                    'graph'=>$graph,
                        'model'=>$model,
            ));

/*

///
        $criteria=new CDbCriteria;
        $criteria->addCondition('createDate > datetime(\'now\', \'-1 hour\', \'localtime\')');

        $dataProvider=new CActiveDataProvider('Temperature',
            array(
                'criteria'=>$criteria,
            )
        );

 //       //json formatted ajax response to request
 //       if(isset($_GET['json']) && $_GET['json'] == 1){
 //           $count = Temperature::model()->count();
 //           for($i=1; $i<=$count; $i++){
 //               $data = Temperature::model()->findByPk($i);
 //               $data->data += rand(-10,10);
 //               $data->save();
 //           }
 //           echo CJSON::encode($dataProvider->getData());
 //       }else{
            $this->render('admin',array(
                    'dataProvider'=>$dataProvider,
			'model'=>$model,
            ));
//        }
///

//		$this->render('admin',array(
//			'model'=>$model,
//                    'dataProvider'=>$dataProvider,
//		));
*/

	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Temperature the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Temperature::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Temperature $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='temperature-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /**
    * a combine view of highcharts
    */
    public function actionChartView()
    {
 
        $criteria=new CDbCriteria;
        $dataProvider=new CActiveDataProvider('Temperature',
            array(
                'criteria'=>$criteria,
            )
        );
 
        //json formatted ajax response to request
        if(isset($_GET['json']) && $_GET['json'] == 1){
            $count = Temperature::model()->count();
            for($i=1; $i<=$count; $i++){
                $data = Temperature::model()->findByPk($i);
                $data->data += rand(-10,10);
                $data->save();
            }
            echo CJSON::encode($dataProvider->getData());
        }else{
            $this->render('admin',array(
                    'dataProvider'=>$dataProvider,
            ));
        }
 
    }

}
