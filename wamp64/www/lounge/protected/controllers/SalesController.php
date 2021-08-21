<?php

class SalesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('merge','split','ids','do_merge'),
				'roles'=>array('cashier'),
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
		$model=new Sales;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Sales']))
		{
			$model->attributes=$_POST['Sales'];
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

		if(isset($_POST['Sales']))
		{
			$model->attributes=$_POST['Sales'];
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
		die;
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
		$dataProvider=new CActiveDataProvider('Sales');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Sales('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Sales']))
			$model->attributes=$_GET['Sales'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Sales the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Sales::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Sales $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sales-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	public function actionMerge()
	{
		
		
		
		$this->layout='column1';
		$criteria = new CDbCriteria();
		$criteria->group='transaction_id';

		$sales=Salesx::model()->findAll($criteria);
		$this->render('merge',array('sales'=>$sales));

		
	}


	public function actionSplit()
	{
		$this->render('split');
	}

	public function actionIds()
	{
		$ids=$_POST['ids'];
		$tids=ltrim($ids,',');
		$plode=explode(',', $tids);
		foreach($plode as $lode)
		{ 

	echo CHtml::button($lode, array('class'=>'btn btn-primary','style'=>'font-size:2em; padding:10px; margin-bottom:5px;'));
			


			
		}
	}


	public function actionDo_merge()
	{
		$ids=$_POST['ids'];
		$tids=ltrim($ids,',');
		$plode=explode(',', $tids);
		$code=array_unique($plode);
		
		$sum=0;
		$crow=array();
		$d=0;

		foreach($code as $id)
		{
			$tab=Salesx::model()->findAll('transaction_id=:k',array(':k'=>$id));
			foreach($tab as $ta)
			{
				$sum+=$ta->qty*$ta->unit_price;
				$balance+=$sum;
			}
			//$crow[$d]=$tab[0]->sale_balance;
			$kit+=$tab[0]->sale_balance;
			$apay+=$tab[0]->amount_paid;
			$d++;
		}

		

		foreach($code as $idx)
		{
			$tabx=Salesx::model()->findAll('transaction_id=:k2',array(':k2'=>$idx));
			foreach($tabx as $tax)
			{
				$tax->total=$sum;
				$tax->save();
			}
		}

		
		$lead=$code[0];
		$new_use=Salesx::model()->find('transaction_id=:p',array(':p'=>$lead));

		$new_table=$new_use->table_number;
		$new_staff=$new_use->staff;

		foreach($code as $vet)
		{
			$tabc=Salesx::model()->findAll('transaction_id=:k3',array(':k3'=>$vet));
			foreach($tabc as $to){
			$to->transaction_id=$lead;
			$to->sale_balance=$kit;
			$to->amount_paid=$apay;
			$to->tendered=$apay;
			$to->table_number=$new_table;
			$to->staff=$new_staff;
			$to->save();
		}
		}



	}
}
