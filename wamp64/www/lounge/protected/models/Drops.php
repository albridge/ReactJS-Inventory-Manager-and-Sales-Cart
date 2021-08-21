<?php

/**
 * This is the model class for table "drops".
 *
 * The followings are the available columns in table 'drops':
 * @property integer $id
 * @property string $barcode
 * @property integer $quantity
 * @property string $product_name
 * @property integer $staff
 * @property integer $shop_id
 * @property double $received
 * @property double $issued
 * @property integer $item_id
 * @property string $created_at
 * @property string $updated_at
 */
class Drops extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Drops the static model class
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
		return 'drops';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	// public function rules()
	// {
	// 	// NOTE: you should only define rules for those attributes that
	// 	// will receive user inputs.
	// 	return array(
	// 		array('barcode, quantity, product_name, shop_id, item_id', 'required'),
	// 		array('quantity, staff, shop_id, item_id', 'numerical', 'integerOnly'=>true),
	// 		array('received, issued', 'numerical'),
	// 		array('barcode, product_name', 'length', 'max'=>200),
	// 		array('updated_at', 'safe'),
	// 		// The following rule is used by search().
	// 		// Please remove those attributes that should not be searched.
	// 		array('id, barcode, quantity, product_name, staff, shop_id, received, issued, item_id, created_at, updated_at', 'safe', 'on'=>'search'),
	// 	);
	// }

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
			'barcode' => 'Barcode',
			'quantity' => 'Quantity',
			'product_name' => 'Product Name',
			'staff' => 'Staff',
			'shop_id' => 'Shop',
			'received' => 'Received',
			'issued' => 'Issued',
			'item_id' => 'Item',
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
		$criteria->compare('barcode',$this->barcode,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('product_name',$this->product_name,true);
		$criteria->compare('staff',$this->staff);
		$criteria->compare('shop_id',$this->shop_id);
		$criteria->compare('received',$this->received);
		$criteria->compare('issued',$this->issued);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}