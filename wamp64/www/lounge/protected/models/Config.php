<?php

/**
 * This is the model class for table "config".
 *
 * The followings are the available columns in table 'config':
 * @property integer $id
 * @property string $company_name
 * @property string $address
 * @property string $phone1
 * @property string $phone2
 * @property string $phone3
 * @property double $tax
 * @property double $discount
 * @property string $email
 * @property string $website
 * @property string $text1
 * @property string $text2
 * @property string $photo
 * @property integer $shop
 * @property integer $print_size
 */
class Config extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Config the static model class
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
		return 'config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_name, address, phone1', 'required'),
			array('shop, print_size', 'numerical', 'integerOnly'=>true),
			array('tax, discount', 'numerical'),
			array('phone1, phone2, phone3', 'length', 'max'=>35),
			array('email', 'length', 'max'=>50),
			array('website, photo', 'length', 'max'=>100),
			array('text1, text2', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, company_name, address, phone1, phone2, phone3, tax, discount, email, website, text1, text2, photo, shop, print_size', 'safe', 'on'=>'search'),
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
			'address' => 'Address',
			'phone1' => 'Phone1',
			'phone2' => 'Phone2',
			'phone3' => 'Phone3',
			'tax' => 'Tax',
			'discount' => 'Discount',
			'email' => 'Email',
			'website' => 'Website',
			'text1' => 'Text1',
			'text2' => 'Text2',
			'photo' => 'Photo',
			'shop' => 'Shop',
			'print_size' => 'Print Size',
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
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone1',$this->phone1,true);
		$criteria->compare('phone2',$this->phone2,true);
		$criteria->compare('phone3',$this->phone3,true);
		$criteria->compare('tax',$this->tax);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('text1',$this->text1,true);
		$criteria->compare('text2',$this->text2,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('shop',$this->shop);
		$criteria->compare('print_size',$this->print_size);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}