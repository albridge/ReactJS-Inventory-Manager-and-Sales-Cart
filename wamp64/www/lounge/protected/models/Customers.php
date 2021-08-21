<?php

/**
 * This is the model class for table "customers".
 *
 * The followings are the available columns in table 'customers':
 * @property integer $id
 * @property string $cname
 * @property string $caddress
 * @property string $cemail
 * @property string $cphone1
 * @property string $cphone2
 */
class Customers extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Customers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'customers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cname', 'required'),
			array('cname, caddress', 'length', 'max'=>250),
			array('cemail', 'length', 'max'=>100),
			array('cphone1, cphone2', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cname, caddress, cemail, cphone1, cphone2', 'safe', 'on'=>'search'),
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
			'cname' => 'Name',
			'caddress' => 'Address',
			'cemail' => 'Email',
			'cphone1' => 'Phone1',
			'cphone2' => 'Phone2',
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
		$criteria->compare('cname',$this->cname,true);
		$criteria->compare('caddress',$this->caddress,true);
		$criteria->compare('cemail',$this->cemail,true);
		$criteria->compare('cphone1',$this->cphone1,true);
		$criteria->compare('cphone2',$this->cphone2,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getCustomer($id)
	{
		$name=Customers::model()->findByPk($id);
		return ucwords($name->cname);
	}
}