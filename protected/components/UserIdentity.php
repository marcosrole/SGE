<?php

class UserIdentity extends CUserIdentity
{	
        public  $_id;      
        public  $_fullName;
        
	public function authenticate()
	{
            $usernameIngresado = $this->username; //username es el DNI
            $password_hasedIngresado = $this->password;
            
            $user = Usuario::model()->findByAttributes(array('dni'=>$usernameIngresado));
                        
            if($user{'dni'}!=$usernameIngresado)
                    $this->errorCode=self::ERROR_USERNAME_INVALID;
            elseif($user{'hased_paswword'}!=$password_hasedIngresado)
                    $this->errorCode=self::ERROR_PASSWORD_INVALID;
            elseif($user{'estado'}=='BLOQUEADO')
                    $this->errorCode=self::ERROR_USUARIO_BLOQUEADO;
            else                    
                    $this->errorCode=self::ERROR_NONE;                    
            if($this->errorCode==self::ERROR_NONE){
                $this->_id = $user{'id'};  
                $this->_fullName=$user{'nombre'} . " " . $user{'apellido'};
                $this->setState('fullName',$user{'nombre'} . " " . $user{'apellido'});
                $UsuarioRol = UsuarioRol::model ()->findByAttributes (array('id_usuario'=>$user{'id'})); 
                
                if($UsuarioRol{'id_rol'}=='superadmin'){
                   $this->setState('rol', array('superadmin','admin','alumno')); 
                }
                if($UsuarioRol{'id_rol'}=='admin'){
                   $this->setState('rol', array('admin','alumno')); 
                }
                if($UsuarioRol{'id_rol'}=='alumno'){
                   $this->setState('rol', array('alumno')); 
                }
                
            }
                    
            return $this->errorCode;
	}
        
        public function setDatos(){
            $user = Usuario::model()->findByAttributes(array('dni'=>$usernameIngresado));
            $this->setState('last_login',$usuario->last_login);
//            $this->setState('rol',$info_usuario->perfil);
        }
        
        public function getId() {
            return $this->_id;
        }
        
        public function getFullName() {
            return $this->_fullName;
        }
        
        
}