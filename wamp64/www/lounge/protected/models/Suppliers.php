<?php

/**
 * This is the model class for table "suppliers".
 *
 * The followings are the available columns in table 'suppliers':
 * @property integer $id
 * @property string $company_name
 * @property string $company_code
 * @property string $contact_name
 * @property integer $telephone
 * @property string $email
 * @property integer $account_number
 * @property integer $staff
 * @property string $created_at
 * @property string $updated_at
 */
class Suppliers extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Suppliers the static model class
	 */
	 public $bankname;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'suppliers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_name, company_code, contact_name', 'required'),
			array('telephone, account_number, staff', 'numerical', 'integerOnly'=>true),
			array('company_name,bankname', 'length', 'max'=>250),
			array('company_code, contact_name', 'length', 'max'=>200),
			array('email', 'length', 'max'=>150),
			array('updated_at', 'safe'),
			array('company_code','unique','message'=>'{attribute}:{value} already exists!'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, company_name, company_code, contact_name, telephone, email, account_number, staff, created_at, updated_at, bankname', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'company_name' => 'Company Name',
			'company_code' => 'Company Code',
			'contact_name' => 'Contact Name',
			'telephone' => 'Telephone',
			'email' => 'Email',
			'account_number' => 'Account Number',
			'staff' => 'Staff',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('company_code',$this->company_code,true);
		$criteria->compare('contact_name',$this->contact_name,true);
		$criteria->compare('telephone',$this->telephone);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('account_number',$this->account_number);
		$criteria->compare('staff',$this->staff);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}