<?php

/**
 * This is the model class for table "suspended".
 *
 * The followings are the available columns in table 'suspended':
 * @property integer $item_id
 * @property integer $id
 * @property string $created_at
 * @property string $name
 * @property double $quantity
 * @property double $supply_price
 * @property double $price
 * @property double $total
 * @property string $cart_id
 * @property string $payment_type
 * @property integer $customer_id
 * @property integer $staff
 * @property double $tax
 * @property double $discount
 * @property string $updated_at
 * @property integer $supplier
 * @property string $photo
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
			//array('id, created_at, name, quantity, supply_price, total, cart_id, payment_type, staff, supplier', 'required'),
			array('name, quantity, price', 'required'),
			array('id, customer_id, staff, supplier', 'numerical', 'integerOnly'=>true),
			array('supply_price, price, total, tax, discount, quantity', 'numerical'),
			array('name', 'length', 'max'=>250),
			array('cart_id', 'length', 'max'=>200),
			array('payment_type', 'length', 'max'=>8),
			array('photo', 'length', 'max'=>100),
			array('updated_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('item_id, id, created_at, name, quantity, supply_price, price, total, cart_id, payment_type, customer_id, staff, tax, discount, updated_at, supplier, photo', 'safe', 'on'=>'search'),
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
			'item_id' => 'Item',
			'id' => 'ID',
			'created_at' => 'Created At',
			'name' => 'Name',
			'quantity' => 'Quantity',
			'supply_price' => 'Supply Price',
			'price' => 'Price',
			'total' => 'Total',
			'cart_id' => 'Cart',
			'payment_type' => 'Payment Type',
			'customer_id' => 'Customer',
			'staff' => 'Staff',
			'tax' => 'Tax',
			'discount' => 'Discount',
			'updated_at' => 'Updated At',
			'supplier' => 'Supplier',
			'photo' => 'Photo',
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

		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('id',$this->id);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('supply_price',$this->supply_price);
		$criteria->compare('price',$this->price);
		$criteria->compare('total',$this->total);
		$criteria->compare('cart_id',$this->cart_id,true);
		$criteria->compare('payment_type',$this->payment_type,true);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('staff',$this->staff);
		$criteria->compare('tax',$this->tax);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('supplier',$this->supplier);
		$criteria->compare('photo',$this->photo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}