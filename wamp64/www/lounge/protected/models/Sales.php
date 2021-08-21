<?php

/**
 * This is the model class for table "sales".
 *
 * The followings are the available columns in table 'sales':
 * @property string $id
 * @property integer $item_id
 * @property string $item_name
 * @property double $qty
 * @property double $supply_price
 * @property double $unit_price
 * @property double $total
 * @property string $transaction_id
 * @property string $payment_type
 * @property integer $customer_id
 * @property integer $staff
 * @property double $tax
 * @property double $discount
 * @property double $tendered
 * @property double $balance
 * @property integer $supplier
 * @property double $sale_balance
 * @property double $item_discount
 * @property double $amount_paid
 * @property integer $shop_id
 * @property string $created_at
 * @property string $updated_at
 */
class Sales extends CActiveRecord
{
	public $refund;
	public $table_number;
	public $closed;
	public $category;
	

	public $print;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Sales the static model class
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
		return 'sales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('item_id, item_name, qty, unit_price, total, transaction_id, payment_type, staff, amount_paid, shop_id, created_at', 'required'),
			array('item_id, item_name, qty, unit_price, total, category', 'required'),
			array('item_id, customer_id, staff, supplier, shop_id, print', 'numerical', 'integerOnly'=>true),
			array('qty, supply_price, unit_price, total, tax, discount, tendered, balance, sale_balance, item_discount, amount_paid, refund, closed, category', 'numerical'),
			array('item_name', 'length', 'max'=>250),
			array('transaction_id', 'length', 'max'=>200),
			array('table_number', 'length', 'max'=>100),
			array('payment_type', 'length', 'max'=>17),
			array('updated_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, item_id, item_name, qty, supply_price, unit_price, total, transaction_id, payment_type, customer_id, staff, tax, discount, tendered, balance, supplier, sale_balance, item_discount, amount_paid, shop_id, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'item_id' => 'Item',
			'item_name' => 'Item Name',
			'qty' => 'Qty',
			'supply_price' => 'Supply Price',
			'unit_price' => 'Unit Price',
			'total' => 'Total',
			'transaction_id' => 'Transaction',
			'payment_type' => 'Payment Type',
			'customer_id' => 'Customer',
			'staff' => 'Staff',
			'tax' => 'Tax',
			'discount' => 'Discount',
			'tendered' => 'Tendered',
			'balance' => 'Balance',
			'supplier' => 'Supplier',
			'sale_balance' => 'Sale Balance',
			'item_discount' => 'Item Discount',
			'amount_paid' => 'Amount Paid',
			'shop_id' => 'Shop',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('item_name',$this->item_name,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('supply_price',$this->supply_price);
		$criteria->compare('unit_price',$this->unit_price);
		$criteria->compare('total',$this->total);
		$criteria->compare('transaction_id',$this->transaction_id,true);
		$criteria->compare('payment_type',$this->payment_type,true);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('staff',$this->staff);
		$criteria->compare('tax',$this->tax);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('tendered',$this->tendered);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('supplier',$this->supplier);
		$criteria->compare('sale_balance',$this->sale_balance);
		$criteria->compare('item_discount',$this->item_discount);
		$criteria->compare('amount_paid',$this->amount_paid);
		$criteria->compare('shop_id',$this->shop_id);
		$criteria->compare('shop_id',$this->category);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}