<?php

class UserIdentity extends CUserIdentity
{	
              
	public function authenticate()
	{
            $usernameIngresado = $this->username; //username es el DNI
            $password_hasedIngresado = $this->password;
            
            $user = Usuario::model()->findByAttributes(array('dni'=>$usernameIngresado));
                        
            if($user{'dni'}!=$usernameIngresado)
                    $this->errorCode=self::ERROR_USERNAME_INVALID;
            elseif($user{'hased_paswword'}!=$password_hasedIngresado)
                    $this->errorCode=self::ERROR_PASSWORD_INVALID;
            else
                    $this->errorCode=self::ERROR_NONE;
            return !$this->errorCode;
	}
        
        public function setDatos(){
            $user = Usuario::model()->findByAttributes(array('dni'=>$usernameIngresado));
            $this->setState('last_login',$usuario->last_login);
//            $this->setState('rol',$info_usuario->perfil);
        }
        
        
}