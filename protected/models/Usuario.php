<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $id
 * @property string $nombre
 * @property string $apellido
 * @property string $dni
 * @property string $email
 * @property string $estado
 * @property string $hased_paswword
 * @property string $last_login
 * @property string $created
 * @property string $last_update
 */
class Usuario extends CActiveRecord
{
    public $esAdmin;
    public $password;
    public $passwordAgain;
    public function tableName()
	{
		return 'usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('password, passwordAgain', 'required', 'on'=>'activarUsuarioSite'),
			array('nombre, apellido, dni, email, hased_paswword', 'required'),
                        array('password','compare','compareAttribute'=>'passwordAgain','operator'=>'==','message'=>'Las contraseñas no coinciden', 'on'=>'activarUsuarioSite'),
			array('nombre, apellido, dni, email, hased_paswword', 'length', 'max'=>20),
                        array('dni', 'unique','message'=>'El DNI ya existe'),
                        array('email', 'unique','message'=>'El email ingresado ya se encuentra almacenado', 'on'=>'create'),
                        array('dni', 'numerical', 'integerOnly'=>true),
			array('estado', 'length', 'max'=>13),
			array('last_login, created, last_update', 'safe'),
			/*
			//Example username
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u',
                 'message'=>'Username can contain only alphanumeric 
                             characters and hyphens(-).'),
          	array('username','unique'),
          	*/
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, apellido, dni, email, estado, hased_paswword, last_login, created, last_update', 'safe', 'on'=>'search'),
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
			'nombre' => 'Nombre',
			'apellido' => 'Apellido',
			'dni' => 'DNI',
			'email' => 'E-mail',
			'estado' => 'Estado',
			'hased_paswword' => 'Hased Paswword',
			'last_login' => 'Last Login',
			'created' => 'Created',
			'last_update' => 'Last Update',
                        'password' => 'Contraseña',
                        'passwordAgain' => 'Confirmacion de contraseña',
                        $this->esAdmin => 'esAdmin'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('apellido',$this->apellido,true);
		$criteria->compare('dni',$this->dni,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('hased_paswword',$this->hased_paswword,true);
		$criteria->compare('last_login',$this->last_login,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('last_update',$this->last_update,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave() 
    {
        $userId=0;
		if(null!=Yii::app()->user->id) $userId=(int)Yii::app()->user->id;
		
		if($this->isNewRecord)
        {           
             $this->created=new CDbExpression('NOW()'); 
            						
        }else{
                        						
        }

        
        return parent::beforeSave();
    }

    public function beforeDelete () {
		$userId=0;
		if(null!=Yii::app()->user->id) $userId=(int)Yii::app()->user->id;
                                
        return false;
    }

    public function afterFind()    {
         
        parent::afterFind();
    }
	
		
	public function defaultScope()
    {
    	/*
    	//Example Scope
    	return array(
	        'condition'=>"deleted IS NULL ",
            'order'=>'create_time DESC',
            'limit'=>5,
        );
        */
        $scope=array();

        
        return $scope;
    }
}
