<?php

/**
 * This is the model class for table "temperature".
 *
 * The followings are the available columns in table 'temperature':
 * @property integer $id
 * @property integer $locationId
 * @property double $value
 * @property string $createDate
 *
 * The followings are the available model relations:
 * @property Location $location
 */
class Temperature extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Temperature the static model class
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
		return 'temperature';
	}

	private $_tempLocation = null;
	public function getTempLocation()
	{
	    if ($this->_tempLocation === null && $this->location !== null)
	    {
	        $this->_tempLocation = $this->location->location;
	    }
	    return $this->_tempLocation;
	}
	public function setTempLocation($value)
	{
	    $this->_tempLocation = $value;
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('value, createDate', 'required'),
			array('locationId', 'numerical', 'integerOnly'=>true),
			array('value', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, locationId, value, createDate, tempLocation', 'safe', 'on'=>'search'),
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
			'location' => array(self::BELONGS_TO, 'Location', 'locationId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'locationId' => 'Location',
			'tempLocation' => 'Location',
			'value' => 'Value',
			'createDate' => 'Timestamp',
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
		$criteria->with = "location"; // Make sure you query with the post table.

		$criteria->compare('id',$this->id);
		$criteria->compare('locationId',$this->locationId);
		$criteria->compare('value',$this->value);
		$criteria->compare('createDate',$this->createDate,true);
		$criteria->compare('location.location', $this->tempLocation,true);

		$sort = new CSort();
		$sort->defaultOrder='createDate DESC';
		$sort->attributes = array(
			'tempLocation'=>array(
			        'asc'=>'location.location',
			        'desc'=>'location.location desc',
			),
			'*',
		);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));

	}

}
