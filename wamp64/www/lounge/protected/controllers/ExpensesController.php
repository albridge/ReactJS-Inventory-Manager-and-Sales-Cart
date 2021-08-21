<?php

class ExpensesController extends Controller
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
				'actions'=>array('create','update','statement'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'roles'=>array('admin','accounts'),
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
		$model=new Expenses;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Expenses']))
		{
			$model->attributes=$_POST['Expenses'];
			$model->shop_id=Yii::app()->user->shop_id;
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

		if(isset($_POST['Expenses']))
		{
			$model->attributes=$_POST['Expenses'];
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
		$dataProvider=new CActiveDataProvider('Expenses');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Expenses('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Expenses']))
			$model->attributes=$_GET['Expenses'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Expenses the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Expenses::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Expenses $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='expenses-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionStatement()
	{
		$model=new Expenses();
		if(isset($_GET['Expenses'])){
				$model->attributes=$_GET['Expenses'];
				//var_dump($_GET['Expenses']); die;
				$date1=$_GET['Expenses']['date1'];
				$date2=$_GET['Expenses']['date2'];
				
						 //$sql_monthly="select SUBSTR(drop_date,6,2) as month, sum(amount) as amt from orders where SUBSTR(drop_date,1,4)='".$dyear."' group by SUBSTR(drop_date,6,2)";		
			//$monthly=Yii::app()->db->createCommand($sql_monthly)->queryAll();
			
		 $trans_sql="select sum(amount) from expenses where SUBSTR(created_at,1,10) between '".$date1."' and '".$date2."' and shop_id='".Yii::app()->user->shop_id."'";
		 $expense = Yii::app()->db->createCommand($trans_sql)->queryScalar();
		 
		 $income_sql="select sum(tendered) from sales where SUBSTR(created_at,1,10) between '".$date1."' and '".$date2."' and shop_id='".Yii::app()->user->shop_id."'";
		 $income = Yii::app()->db->createCommand($income_sql)->queryScalar(); 
		 
		 $unpaid_sql="select sum(sale_balance) from sales where SUBSTR(created_at,1,10) between '".$date1."' and '".$date2."' and sale_balance>0 and shop_id='".Yii::app()->user->shop_id."'";
		 $unpaid = Yii::app()->db->createCommand($unpaid_sql)->queryScalar(); 
		// echo $income.' '.$unpaid; echo "difference= ".(abs($unpaid)-$income); die;
		 //echo $unpaid; die;
		 $edetails_sql="select sum(amount) as amount, created_at, description, expense_type from expenses where SUBSTR(created_at,1,10) between '".$date1."' and '".$date2."' and shop_id='".Yii::app()->user->shop_id."' group by expense_type";
		 $expense_details = Yii::app()->db->createCommand($edetails_sql)->queryAll();
		 
		 
		 $idetails_sql="select tendered as amount_paid, item_name, qty, unit_price, created_at from sales where SUBSTR(created_at,1,10) between '".$date1."' and '".$date2."' group by transaction_id ";
		 $income_details = Yii::app()->db->createCommand($idetails_sql)->queryAll(); 
		 
		// $notpaid=(abs($unpaid)-$income);
		 $notpaid=$unpaid;
		}
		$this->render('statement',array(
			'model'=>$model,
			'income'=>$income,
			'expense'=>$expense,
			'notpaid'=>$notpaid,
			'date1'=>$date1,
			'date2'=>$date2,
			'income_details'=>$income_details,
			'expense_details'=>$expense_details,
			));	
	}
}
