<?php

/**
 * This is the model class for table "usuario_rol".
 *
 * The followings are the available columns in table 'usuario_rol':
 * @property integer $id
 * @property string $id_rol
 * @property integer $id_usuario
 * @property string $created
 * @property string $last_update
 */
class UsuarioRol extends CActiveRecord
{
	public $usuario_nombre;
        public $usuario_apellido;
        public $usuario_email;
        public $usuario_dni;
        public $rol_nombre;
        public $isAdmin;
        
	public function tableName()
	{
		return 'usuario_rol';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rol, id_usuario', 'required'),
			array('id_usuario', 'numerical', 'integerOnly'=>true),
			array('id_rol', 'length', 'max'=>10),
			array('created, last_update', 'safe'),
			/*
			//Example username
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u',
                 'message'=>'Username can contain only alphanumeric 
                             characters and hyphens(-).'),
          	array('username','unique'),
          	*/
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rol, id_usuario, created, last_update, rol_nombre, usuario_dni, usuario_nombre, usuario_apellido, usuario_email', 'safe', 'on'=>'search'),
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
                        'usuario' => array(self::BELONGS_TO, 'usuario', 'id_usuario'),
                        'rol' => array(self::BELONGS_TO, 'rol', 'id_rol'),                        
                );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_rol' => 'Id Rol',
			'id_usuario' => 'Id Usuario',
			'created' => 'Created',
                        'usuario_nombre' => 'Nombre',
                        'usuario_apellido' => 'Apellido',
                        'usuario_dni' => 'DNI',
                        'rol_nombre' => 'Rol',                        
                        'isAdmin' => '',
			'last_update' => 'Last Update',
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
                $criteria->with = array('usuario', 'rol'); 
                
		$criteria->compare('id',$this->id);
		$criteria->compare('id_rol',$this->id_rol,true);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('created',$this->created,true);
                $criteria->compare('last_update',$this->last_update,true);
                $criteria->addSearchCondition('usuario.nombre',$this->usuario_nombre,true);
                $criteria->addSearchCondition('usuario.apellido',$this->usuario_apellido,true);
                $criteria->addSearchCondition('usuario.email',$this->usuario_email,true);
                $criteria->addSearchCondition('usuario.dni',$this->usuario_dni,true);
                $criteria->addSearchCondition('rol.nombre',$this->rol_nombre,true);
		
                

                return new CActiveDataProvider( $this, array(
                    'criteria'=>$criteria,
                    'sort'=>array(
                        'attributes'=>array(
                            'usuario_nombre'=>array(
                                'asc'=>'usuario.nombre',
                                'desc'=>'usuario.nombre DESC',
                            ),
                            'usuario_apellido'=>array(
                                'asc'=>'usuario.apellido',
                                'desc'=>'usuario.apellido DESC',
                            ),
                            'usuario_email'=>array(
                                'asc'=>'usuario.email',
                                'desc'=>'usuario.email DESC',
                            ),
                            'usuario_dni'=>array(
                                'asc'=>'usuario.dni',
                                'desc'=>'usuario.dni DESC',
                            ),
                            'rol_nombre'=>array(
                                'asc'=>'rol.nombre',
                                'desc'=>'rol.nombre DESC',
                            ),
                        ),
                        'defaultOrder' => array(
                            'rol.nombre' => CSort::SORT_ASC,
                        ),
                    ),
                ));         	
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsuarioRol the static model class
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
    
    public function getUsuario_nombre(){
        return $this->usuario_nombre;
    }
}
