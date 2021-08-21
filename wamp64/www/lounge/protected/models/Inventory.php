<?php

/**
 * This is the model class for table "inventory".
 *
 * The followings are the available columns in table 'inventory':
 * @property integer $id
 * @property string $barcode
 * @property string $name
 * @property string $description
 * @property double $quantity
 * @property double $supply_price
 * @property integer $reorder
 * @property integer $staff
 * @property double $price
 * @property integer $category
 * @property integer $supplier
 * @property string $photo
 * @property double $single_item_discount
 * @property string $shelf_number
 * @property integer $shop_id
 * @property string $updated_at
 * @property string $created_at
 */
class Inventory extends CActiveRecord implements IECartPosition
{
	public $disco;
	public $is_countable;
	public $item_id;
	public $unit;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Inventory the static model class
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
		return 'inventory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, quantity, price, is_countable, category, unit', 'required'),
			array('reorder, staff, category, supplier, shop_id, item_id, unit', 'numerical', 'integerOnly'=>true),
			array('quantity, supply_price, price, single_item_discount, disco, is_countable', 'numerical'),
			array('barcode, shelf_number', 'length', 'max'=>200),
			//array('barcode','my_unique','on'=>'insert'),
			// array('barcode','unique'),
			// array('barcode','unique',
			// 	'caseSensitive'=>true,
			// 	'allowEmpty'=>true),
			array('name', 'length', 'max'=>250),
			array('photo', 'length', 'max'=>100),
			array('description, updated_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, barcode, name, description, quantity, supply_price, reorder, staff, price, category, supplier, photo, single_item_discount, shelf_number, shop_id, updated_at, created_at', 'safe', 'on'=>'search'),
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
			'barcode' => 'Product Code',
			'name' => 'Name',
			'description' => 'Description',
			'quantity' => 'Quantity',
			'supply_price' => 'Supply Price',
			'reorder' => 'Reorder',
			'staff' => 'Staff',
			'price' => 'Price',
			'category' => 'Category',
			'supplier' => 'Supplier',
			'photo' => 'Photo',
			'single_item_discount' => 'Single Item Discount',
			'shelf_number' => 'Shelf Number',
			'shop_id' => 'Shop',
			'updated_at' => 'Updated At',
			'created_at' => 'Created At',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('supply_price',$this->supply_price);
		$criteria->compare('reorder',$this->reorder);
		$criteria->compare('staff',$this->staff);
		$criteria->compare('price',$this->price);
		$criteria->compare('category',$this->category);
		$criteria->compare('supplier',$this->supplier);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('single_item_discount',$this->single_item_discount);
		$criteria->compare('shelf_number',$this->shelf_number,true);
		//$criteria->compare('shop_id',$this->shop_id);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('created_at',$this->created_at,true);

		if(Yii::app()->user->name=='admin'){
		$criteria->compare('shop_id',$this->shop_id);
		}else{
		$criteria->compare('shop_id',$this->rez(),true);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function rez()
	{
		$classs=User::model()->find('id=:p',array(':p'=>Yii::app()->user->id))->shop_id;
		return $classs;	//die($classs);
	}

	public function my_unique($attribute_name,$params)
	{
	    if(empty($this->barcode) || empty($this->shop_id))
	    {
	        $this->addError('barcode',
	        'Shop_id and product code fields must be filled');
	    }
	    $checked=Inventory::model()->find('barcode=:ba and shop_id=:sh',array(':ba'=>$this->barcode,':sh'=>$this->shop_id));
	    if($checked!=null)
	    {
	    	 $this->addError('barcode',
	        'A product with this barcode already exists in your store');
	    }
	    // else if(!empty($this->phoneno) && $this->stdcode=='')
		   //  {
		   //      $this->addError('stdcode','Please enter STD number');
		   //  }
		}
}