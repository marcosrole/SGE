<?php

/**
 * This is the model class for table "token".
 *
 * The followings are the available columns in table 'token':
 * @property string $id
 * @property string $accion
 * @property string $identity
 * @property string $token
 * @property string $informacion
 * @property string $expire_time
 */
class Token extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
         
        public $secretKey = 'SGE2017';
    
	public function tableName()
	{
		return 'token';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('identity', 'required'),
			array('accion', 'length', 'max'=>100),
			array('identity, token', 'length', 'max'=>32),
			array('expire_time', 'length', 'max'=>10),
			array('informacion', 'safe'),
			/*
			//Example username
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u',
                 'message'=>'Username can contain only alphanumeric 
                             characters and hyphens(-).'),
          	array('username','unique'),
          	*/
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, accion, identity, token, informacion, expire_time', 'safe', 'on'=>'search'),
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
			'accion' => 'Accion',
			'identity' => 'Identity',
			'token' => 'Token',
			'informacion' => 'Informacion',
			'expire_time' => 'Expire Time',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('accion',$this->accion,true);
		$criteria->compare('identity',$this->identity,true);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('informacion',$this->informacion,true);
		$criteria->compare('expire_time',$this->expire_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Token the static model class
	 */
        
         /**
     * Create token
     * @param string $accion 
     * @param int $duration 
     * @param int $informacion 
     * @return boolean
     */
    public function createToken($accion, $duration = 0, $informacion = null)
    {
        $identityKey = $this->createIdentityKey($accion);
        $this->deleteByIdentityKey($accion, $identityKey);
        $tokenKey = $this->createTokenKey($identityKey);
        $expireTime = $duration > 0 ? $duration + time() : 0;
        $token = $this->saveToken($accion, $identityKey, $tokenKey, $expireTime, serialize($informacion));
        return is_string($token) ? $token : false;
    }

    /**
     * Token Validator
     * @param string $accion 
     * @param string $token 
     * @param var $informacion 
     * @param boolean $delete 
     * @return boolean
     */
    public function validateToken($token,  $delete = true)
    {
        $record = $this->findToken($token);
        if(!$record instanceof Token || $record->token != $token || ($record->expire_time > 0 && $record->expire_time < time()))
        return false;
        
        if ($delete)
        $this->deleteByTokenKey($token);
        return true;
    }

    /**
     * Create a Identity key
     * @param string $accion 
     * @return string
     */
    protected function createIdentityKey($accion)
    {
        return md5($accion);
    }

    /**
     * Create a token
     * @param string $identityKey 
     * @return string
     */
    protected function createTokenKey($identityKey)
    {
        return md5($identityKey.$this->secretKey.time());
    }

    /**
     * Save token
     * @param string $accion 
     * @param string $identityKey
     * @param string $tokenKey 
     * @param int $expireTime
     * @param string $informacion 
     * @return boolean
     */
    protected function saveToken($accion, $identityKey, $tokenKey, $expireTime, $informacion = null)
    {
                
        $token = new Token();
        $token->accion = $accion;
        $token->identity = $identityKey;
        $token->token = $tokenKey;
        $token->expire_time = $expireTime;
        $token->informacion = $informacion;
        return $token->save() ? $tokenKey : false;
        
    }

    /**
     * 从数据库中取出令牌的model
     * @param string $accion 令牌类型名
     * @param string $token 令牌字符串
     * @return TokenRecord
     */
    protected function findToken($token)
    {
//        return Token::model()->find('accion = :accion AND token = :token', array(':accion'=>$accion, 'token'=>$token));
        return Token::model()->find('token = :token', array('token'=>$token));
    }

    /**
     * delele by token key
     * @param string $accion
     * @param string $identityKey
     * @return boolean
     */
    protected function deleteByIdentityKey($accion, $identityKey)
    {
        return Token::model()->deleteAll('accion = :accion AND identity = :identity', array(':accion'=>$accion, ':identity'=>$identityKey));
    }

    /**
     * delele by token key
     * @param string $accion
     * @param string $tokenKey
     * @return boolean
     */
    protected function deleteByTokenKey($tokenKey)
    {
//        return Token::model()->deleteAll('accion = :accion AND token = :token', array(':accion'=>$accion, ':token'=>$tokenKey));
        return Token::model()->deleteAll('token = :token', array(':token'=>$tokenKey));
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
