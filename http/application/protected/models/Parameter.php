<?php

/**
 * This is the model class for table "parameter".
 *
 * The followings are the available columns in table 'parameter':
 * @property integer $id
 * @property string $name
 * @property string $value
 */
class Parameter extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Parameter the static model class
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
		return 'parameter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, value', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, value', 'safe', 'on'=>'search'),
			array('name, value', 'required'),
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
			'name' => 'Name',
			'value' => 'Value',
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

//		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	// Retrieve a parameter value
        public function getParameter($name)
        {
//                $model=Parameter::model()->findByAttributes(array('name'=>$name));
//                if($model===null)
//                {
//                        throw new CHttpException(404,'The requested page does not exist.');
//                }
//                return $model->value;

                $criteria=new CDbCriteria;
		$criteria->select='value'; 
                $criteria->compare('name',$name);

                $dataProvider = new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
		$row = $dataProvider->getData();
//		return $dataProvider->getData()->value;
		return $row['id'];
//return Yii::app()->params['adminEmail'];

        }

}
