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
 * @property string $sexo
 * @property string $fecha_nacimiento
 * @property string $celular
 * @property string $domicilio
 * @property integer $id_localidad
 * @property integer $id_carrera
 */
class Usuario extends CActiveRecord
{
    public $esAdmin;
    public $id_provincia;
    public $password;
    public $passwordNew;
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
                    //generales
                        array('dni, nombre, apellido, domicilio, id_localidad, id_provincia, id_carrera, sexo, celular, email, fecha_nacimiento', 'required'),
                        array('dni', 'numerical', 'integerOnly'=>true, 'min'=>5),
                        array('dni', 'length', 'min'=>5, 'max'=>9),
                        array('id_localidad, id_carrera, id_provincia', 'numerical', 'integerOnly'=>true),
                        array('nombre, apellido, email, hased_paswword', 'length', 'max'=>50),
                        array('email','email'),
                        array('sexo', 'length', 'max'=>9),
                        array('estado', 'length', 'max'=>13),
                        array('celular, domicilio', 'length', 'max'=>100),
                    
                    //USUARIO_actionCreate
                        array('dni, nombre, apellido', 'required', 'on'=>'USUARIO_actionCreate'),
                        array('dni', 'unique','message'=>'El DNI ya existe', 'on'=>'USUARIO_actionCreate'),
                        
                    
                    //SITE_actionActivarUsuario
                        array('password, passwordAgain', 'required', 'on'=>'SITE_actionActivarUsuario'),
                        array('fecha_nacimiento', 'type', 'type' => 'date', 'message' => '{attribute}: El formato de fecha es incorrecto: dd/mm/aaaa', 'dateFormat' => 'dd/MM/yyyy'),
                        array('password','compare','compareAttribute'=>'passwordAgain','operator'=>'==','message'=>'Las contraseñas no coinciden', 'on'=>'SITE_actionActivarUsuario'),
                    
//                    SITE_actionOlvideMiContrasenia_true
                        array('password, passwordAgain, passwordNew', 'required', 'on'=>'SITE_actionOlvideMiContrasenia_true'),
//                        
//			                        
//                        array('email', 'unique','message'=>'El email ingresado ya se encuentra almacenado'),
//			
                        
                        
			array('last_login, created, last_update, fecha_nacimiento', 'safe'),
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
                    'carrera'=>array(self::BELONGS_TO, 'Carrera', 'id_carrera'),
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
                        'passwordNew' => 'Nueva contraseña',
                        'sexo' => 'Sexo',
                        'celular' => 'Celular',
			'domicilio' => 'Domicilio',
			'id_localidad' => 'Localidad',
                        'id_provincia' => 'Provincia',
			'id_carrera' => 'Carrera',
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
                $criteria->compare('sexo',$this->sexo,true);
		$criteria->compare('fecha_nacimiento',$this->fecha_nacimiento,true);
		$criteria->compare('celular',$this->celular,true);
		$criteria->compare('domicilio',$this->domicilio,true);
		$criteria->compare('id_localidad',$this->id_localidad);
		$criteria->compare('id_carrera',$this->id_carrera);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => array(
                            'defaultOrder' => 'estado ASC, apellido ASC',
                            ), 
		));
	}

	/**
	 * Retorna si el email ya se encuentra almacenado en la BD	 
	 * @param string $email email a buscar
	 * @return Boolean
	 */
        public function validateUniqueEmail($email)
        {
            if(Usuario::model()->find('email = :email', array(':email'=>$email)) == null) return true;
            return false;
        }
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getDomicilioCompleto()
        {
            $localidad = Localidad::model()->findByPk($this->id_localidad);
            $provincia = Provincia::model()->findByPk($localidad{'id_provincia'});
            return $this->domicilio . ' - ' . $localidad{'localidad'} . '(' . $provincia{'provincia'} .')';
        }
        public function getNombreCarrera()
        {
            $carrera = Carrera::model()->findByPk($this->id_carrera);
            return $carrera{'plan'} . " - " . $carrera{'nombre'};
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
        
                // NOT SURE RUN PLEASE HELP ME -> 
        	//$from=DateTime::createFromFormat('d/m/Y',$this->fecha_nacimiento);
        	//$this->fecha_nacimiento=$from->format('Y-m-d');
        
        return parent::beforeSave();
    }

    public function beforeDelete () {
		$userId=0;
		if(null!=Yii::app()->user->id) $userId=(int)Yii::app()->user->id;
                                
        return false;
    }

    public function afterFind()    {
         // NOT SURE RUN PLEASE HELP ME -> 
        	//$from=DateTime::createFromFormat('Y-m-d',$this->fecha_nacimiento);
        	//$this->fecha_nacimiento=$from->format('d/m/Y');
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
