<?php

class SiteController extends Controller
{
    
        public function filters()
	{
		return array(
						
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
						
		);
	}
        
        
	public function accessRules()
	{
             
//            if( Yii::app()->user->getState('rol') == "admin"){ 
//                 $arr =array('admin','view');   // give all access to admin
//            }else if( Yii::app()->user->getState('rol') =="alumno"){
//                    $arr =array('index','staff','staffcalendar','update');   // give all access to staff
//                }else{
//                    $arr = array('');          //  no access to other user
//                  }
                
            return array(  
                        array('allow',
                            'controllers'=>array('site'),
                            'actions'=>array('error'),
                        ),
                        array('allow',  // a todos los usuarios
				'actions'=>array('login','EnviarMailActivacion','ActivarUsuario','OlvideMiContrasenia'),
				'users'=>array('*'),
			),  
                        array('allow', 
                                'actions'=>array('index','contact','logout'),
                                'users'=>array('@'),
                        ),
//                        array('allow', 
//                                'actions'=>$arr,
//                                'users'=>array('@'),
//                        ),                                                
                        array('deny',  // deny all users
                                'users'=>array('*'),
                        ),
                        array('booster.filters.BootstrapFilter - delete')
                );
	}
        
       
    
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
                
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}
        
        
        public function actionActivarUsuario($tokenParam)
	{
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            //Verifico token 
            if(!Token::model()->validateToken($tokenParam, false)){
                Yii::app()->user->setFlash('error', "El token no existe");
                $this->redirect(array('login'));
            }
            $Usuario = new Usuario();
            $Usuario->unsetAttributes();
            $Usuario->scenario = 'SITE_actionActivarUsuario';
            
            //Busco el id del usuario por el token
            $token = Token::model()->findByAttributes(array('token'=>$tokenParam));
            $idUser = unserialize($token{'informacion'});
            $idUser = $idUser['idUsr'];
            $Usuario = Usuario::model()->findByPk($idUser);
            
             if(isset($_POST['Usuario'])){
                 
                $UsuarioActualizado = $Usuario;
                $UsuarioActualizado->password=$_POST['Usuario']['password'];
                $UsuarioActualizado->passwordAgain=$_POST['Usuario']['passwordAgain'];
                $UsuarioActualizado->hased_paswword= crypt($_POST['Usuario']['password'],'SGE2017');
                $UsuarioActualizado->celular=$_POST['Usuario']['celular'];
                $UsuarioActualizado->id_carrera = $_POST['Usuario']['id_carrera'];
                $UsuarioActualizado->id_provincia = $_POST['Usuario']['id_provincia'];
                $UsuarioActualizado->id_localidad = $_POST['Usuario']['id_localidad'];
                $UsuarioActualizado->sexo = $_POST['Usuario']['sexo'];
                $UsuarioActualizado->domicilio = $_POST['Usuario']['domicilio'];
                $UsuarioActualizado->fecha_nacimiento = $_POST['Usuario']['fecha_nacimiento'];
                $UsuarioActualizado->estado="ACTIVO";
                $UsuarioActualizado->scenario = 'SITE_actionActivarUsuario';
                $UsuarioActualizado->last_login = date('Y-m-d H:i:s'); 
                $UsuarioActualizado->last_update = date('Y-m-d H:i:s'); 
                
                if($UsuarioActualizado->validate()){
                    $UsuarioActualizado->fecha_nacimiento = DateTime::createFromFormat('d/m/Y', $_POST['Usuario']['fecha_nacimiento'])->format('Y-m-d');
                    $UsuarioActualizado->save(false);
                    Token::model()->validateToken($tokenParam, true);
                    Yii::app()->user->setFlash('success', $UsuarioActualizado{'nombre'} . ", tu usuario ha sido activado con éxito.");                    
                    $this->redirect(array('login'));
                }else{ 
                     $Usuario = $UsuarioActualizado;
                 }                
             }     
            
            $this->render('activarUsuario',array('model'=>$Usuario));
        }
        
        public function actionOlvideMiContrasenia($token = null){
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $model = new Usuario();
            $model{'email'}="";
            $flagConToken = false;
            
            if($token == NULL){
                    if(isset($_POST['Usuario'])){
                        $usuario = Usuario::model()->findByAttributes(array('dni'=>$_POST['Usuario']['dni']));

                        //Valido el dni
                        if($usuario==NULL){
                            Yii::app()->user->setFlash('error', 'El DNI ingresado es incorrecto');
                            $this->redirect('olvideMiContrasenia',array('model'=>$model,'flagConToken'=>$flagConToken));
                        }

                        //Valido el email ingresado
                        if(strtoupper($_POST['Usuario']['email']) != strtoupper($usuario{'email'})){
                            Yii::app()->user->setFlash('error', 'El usuario no posee asociado el email ingresado');
                            $this->redirect('olvideMiContrasenia',array('model'=>$model,'flagConToken'=>$flagConToken));
                        }

                         //Genero el token
                        $NombreToken = "activarUsuario" . $usuario{'id'};
                        $token = Token::model()->createToken($NombreToken, 21600, array('idUsr'=>$usuario{'id'}));
                        
                        //EnvioEmail
                        if($this->enviarMail('recuperarPasswordMail',$token,'Recuperar contraseña',$_POST['Usuario']['email'])){
                            Yii::app()->user->setFlash('success', "Se ha enviado un mail a " . $_POST['Usuario']['email']);
                        }else{
                            Yii::app()->user->setFlash('error','Error al enviar el email: '.$this->enviarMail()->getError());
                        }
                        //Vuelvo al Login                        
                        $this->redirect(array('login'));
                    } 
                    
                    $this->render('olvideMiContrasenia',array('model'=>$model, 'flagConToken'=>$flagConToken));
                    
            }else{
                    $flagConToken = true;
                    //Verifico token 
                    if(!Token::model()->validateToken($token, false)){
                        Yii::app()->user->setFlash('error', "El token no existe");
                        $this->redirect(array('login'));
                    }
                    
                    //Busco el id del usuario por el token
                    $token = Token::model()->findByAttributes(array('token'=>$token));
                    $idUser = unserialize($token{'informacion'});
                    $idUser = $idUser['idUsr'];
                    $Usuario = Usuario::model()->findByPk($idUser);
                    if(isset($_POST['Usuario'])){
                        $passwordNew = $_POST['Usuario']['passwordNew'];
                        $passwordNewAgain = $_POST['Usuario']['passwordAgain'];
                        
                                                
                        //Verifico nuevo password y el re-intento de password
                        if($passwordNew != $passwordNewAgain){
                            Yii::app()->user->setFlash('error', 'La nueva contraseña no coincide');
                            $this->redirect('olvideMiContrasenia?token=' . $token{'token'},array('model'=>$model,'flagConToken'=>$flagConToken));
                        }
                        
                        
                        $Usuario->scenario = 'SITE_actionOlvideMiContrasenia_true';
                        
                        //Guardo nueva contraseña
                        $Usuario{'hased_paswword'} = crypt($passwordNew,'SGE2017');
                        if($Usuario->save(false)){
                            Yii::app()->user->setFlash('success', "Se ha actualizado su contraseña");
                             $this->redirect(array('login'));
                        }
                        
                    }
                    
                    $this->render('olvideMiContrasenia',array('model'=>$model, 'flagConToken'=>$flagConToken));
            }    

            
            
        }
        
        public function actionEnviarMailActivacion()
	{
                date_default_timezone_set('America/Argentina/Buenos_Aires');
		$user = new Usuario();
                $user{'email'}="";
                
                
                if(isset($_POST['Usuario'])){
                    $userLoginTemp = Usuario::model()->findByAttributes(array('dni'=>$_POST['Usuario']['dni']));                   
                    //Verifico si el usuario existe
                    if($userLoginTemp==NULL){
                        Yii::app()->user->setFlash('error', "El DNI ingresado es incorrecto");
                        $this->redirect(array('EnviarMailActivacion'));
                    }
                    
                    //Valido el e-mail
                    if(!filter_var($_POST['Usuario']['email'], FILTER_VALIDATE_EMAIL)){
                        Yii::app()->user->setFlash('error', "El e-mail ingresado no es válido");
                        $this->redirect(array('EnviarMailActivacion'));
                    }
                    
                    //Verifico que el usuario se encuentre DESHABILITADO
                    if($userLoginTemp{'estado'}=='ACTIVO' || $userLoginTemp{'estado'}=='BLOQUEADO'){
                        Yii::app()->user->setFlash('error', "El usuario ya se encuentra activo");
                        $this->redirect(array('EnviarMailActivacion'));
                    }
                    
                    
                    //Guardo el mail en el usuario
                    $userLoginTemp->email=$_POST['Usuario']['email'];
                    $userLoginTemp->save(false);
                    //Genero el token
                    $NombreToken = "activarUsuario" . $userLoginTemp{'id'};
                    $token = Token::model()->createToken($NombreToken, 21600, array('idUsr'=>$userLoginTemp{'id'}));

                    
                    //EnvioEmail
                    if($this->enviarMail('activarUsuarioMail',$token,'Activación de usuario',$_POST['Usuario']['email'])){
                        Yii::app()->user->setFlash('success', "Se ha enviado un mail a " . $_POST['Usuario']['email']);
                    }else{
                        Yii::app()->user->setFlash('error','Error al enviar el email: '.$this->enviarMail()->getError());
                    }
                    //Vuelvo al Login
                   
                    $this->redirect(array('login'));
                    
                }
                
                $this->render('enviarMailActivacion',array('model'=>$user,));
        }

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;    
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			$identity = new UserIdentity($model->username,(crypt($model->password,'SGE2017')));
                        switch ($identity->authenticate()) {
                            case 0:
                                Yii::app()->user->login($identity); 
                                $usuarioCorrecto = Usuario::model()->findByAttributes(array('dni'=>$model{'username'}));
                                $usuarioCorrecto{'last_login'} = date('Y-m-d H:i:s');
                                if(!$usuarioCorrecto->save(false)){ 
                                     Yii::log('actionLogin', "ERROR", '');
                                     Yii::app()->user->setFlash('error', Yii::app()->properties->msgERROR_INTERNO);
                                }
                                $this->redirect(Yii::app()->user->returnUrl);
                                
                                break;
                            case 1:
                                Yii::app()->user->setFlash('error', "Usuario o contraseña inválido");
                                break;
                            case 2:
                                Yii::app()->user->setFlash('error', "Usuario o contraseña inválido");
                                break;
                            case 3:
                                Yii::app()->user->setFlash('error', "El usuario se encuentra bloqueado");
                                break;
                            case 40:
                                $this->redirect(array('enviarMailActivacion'));
                                break;
                        }                       	
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
        
        public function enviarMail($view, $token, $subject, $to){
            $mail = new YiiMailer($view, array('message' => "", 'token' => $token));
            $mail->IsSMTP();                 
            $mail->setFrom(Yii::app()->params['paramName'], 'Sistema de Gestion del Estudiante');
            $mail->setTo($to);
            $mail->setSubject($subject);
            return $mail->send();
        }
}