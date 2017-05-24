<?php

/**
 * This is the model class for table "inscripcionmateria".
 *
 * The followings are the available columns in table 'inscripcionmateria':
 * @property integer $id
 * @property integer $id_usuario
 * @property integer $id_materia
 * @property integer $id_mesa
 * @property string $ticket
 * @property string $created
 * @property string $last_update
 */
class Inscripcionmateria extends CActiveRecord
{
	public $usuario_nombre;
        public $usuario_apellido;
        public $usuario_email;
        public $usuario_dni;
        public $materia_nombre;
        public $fullPeriodo;
        public $fullNombre;
        
        
        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'inscripcionmateria';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, id_materia, id_mesa, ticket', 'required'),
			array('id_usuario, id_materia, id_mesa', 'numerical', 'integerOnly'=>true),
			array('ticket', 'length', 'max'=>20),
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
			array('id, id_usuario,id_materia,usuario_nombre, usuario_dni, usuario_apellido, materia_nombre,fullPeriodo, fullNombre, id_mesa, ticket, last_update', 'safe', 'on'=>'search'),
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
                    'materia' => array(self::BELONGS_TO, 'materia', 'id_materia'),
                    'mesa' => array(self::BELONGS_TO, 'mesa', 'id_mesa'), 
                    'usuario' => array(self::BELONGS_TO, 'usuario', 'id_usuario'), 
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_usuario' => 'Id Usuario',
			'id_materia' => 'Id Materia',
			'id_mesa' => 'Id Mesa',
			'ticket' => 'Ticket',
			'created' => 'Created',
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
                $criteria->together = true;
                 $criteria->with = array(
                    'usuario' => array('alias'=> 'usuario', 'together' => true, ),
                    'materia' => array('alias'=> 'materia', 'together' => true, ),
                    'mesa' => array('alias'=> 'mesa', 'together' => true, ),
                );
                 
		$criteria->compare('id',$this->id);
                
                if(Yii::app()->user->getState('rolUsuario') == "admin"){
                    $criteria->compare('id_usuario',$this->id_usuario);
                }else{
                    $criteria->compare('id_usuario',Yii::app()->user->getId());
                }
                
		
		$criteria->compare('id_materia',$this->id_materia);
		$criteria->compare('id_mesa',$this->id_mesa);
		$criteria->compare('ticket',$this->ticket,true);
		$criteria->compare('t.created',$this->created,true);
		$criteria->compare('last_update',$this->last_update,true);
                
                
                $criteria->addSearchCondition('concat(usuario.nombre, " ", usuario.apellido)',$this->fullNombre,true);
                $criteria->addSearchCondition('usuario.email',$this->usuario_email,true);
                $criteria->addSearchCondition('usuario.dni',$this->usuario_dni,true);
                $criteria->addSearchCondition('materia.nombre',$this->materia_nombre,true);
                $criteria->addSearchCondition('mesa.periodo',$this->fullPeriodo,true);
                
		return new CActiveDataProvider($this, array(
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
                            'materia_nombre'=>array(
                                'asc'=>'materia.nombre',
                                'desc'=>'materia.nombre DESC',
                            ),
                            'mesa_periodo'=>array(
                                'asc'=>'mesa.periodo',
                                'desc'=>'mesa.periodo DESC',
                            ),                            
                        ),
                        'defaultOrder' => array(
                            'created' => CSort::SORT_ASC,
                        ),
                    ),
		));
	}
        
        

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Inscripcionmateria the static model class
	 */
        
         public function getFullPeriodo()
        {
                $Mesa = Mesa::model()->findByPk($this->id_mesa);
                return $Mesa{'periodo'} . ' ' . $Mesa{'anio'};
        }
        
         public function getFullNombre()
        {
                $usuario = Usuario::model()->findByPk($this->id_usuario);
                return $usuario{'apellido'} . " " . $usuario{'nombre'};
        }
        
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
