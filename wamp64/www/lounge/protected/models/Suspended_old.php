<?php

/**
 * This is the model class for table "suspended".
 *
 * The followings are the available columns in table 'suspended':
 * @property string $name
 * @property integer $quantity
 * @property double $price
 * @property double $total
 * @property string $cart_id
 * @property integer $saletype
 * @property string $payment_type
 * @property integer $customer_id
 * @property integer $staff
 * @property double $tax
 * @property double $discount
 * @property string $created_at
 * @property string $updated_at
 * @property integer $item_id
 * @property integer $id
 */
class Suspended extends CActiveRecord implements IECartPosition
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Suspended the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getId(){
        return $this->id;
    }

    public function getPrice(){
        return $this->price;
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'suspended';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, quantity, price, total, cart_id, saletype, payment_type, staff, id', 'required'),
			array('quantity, saletype, customer_id, staff, id', 'numerical', 'integerOnly'=>true),
			array('price, total, tax, discount', 'numerical'),
			array('name', 'length', 'max'=>250),
			array('cart_id', 'length', 'max'=>200),
			array('payment_type', 'length', 'max'=>8),
			array('updated_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, quantity, price, total, cart_id, saletype, payment_type, customer_id, staff, tax, discount, created_at, updated_at, item_id, id', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'quantity' => 'Quantity',
			'price' => 'Price',
			'total' => 'Total',
			'cart_id' => 'Cart',
			'saletype' => 'Saletype',
			'payment_type' => 'Payment Type',
			'customer_id' => 'Customer',
			'staff' => 'Staff',
			'tax' => 'Tax',
			'discount' => 'Discount',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'item_id' => 'Item',
			'id' => 'ID',
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

		$criteria->compare('name',$this->name,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('price',$this->price);
		$criteria->compare('total',$this->total);
		$criteria->compare('cart_id',$this->cart_id,true);
		$criteria->compare('saletype',$this->saletype);
		$criteria->compare('payment_type',$this->payment_type,true);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('staff',$this->staff);
		$criteria->compare('tax',$this->tax);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}