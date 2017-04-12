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
                        array('allow',  // a todos los usuarios
				'actions'=>array('login','EnviarMailActivacion'),
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
        
        
        public function actionEnviarMailActivacion()
	{
		$idUserLogin = Yii::app()->user->getId(); 
                $userLogin = Usuario::model()->findByPk($idUserLogin);
                $userLogin{'email'}="";
                $userLogin{'dni'}="";
                
                if(isset($_POST['Usuario'])){
                    $userLoginTemp = Usuario::model()->findByPk($idUserLogin);                   
                    //Verifico el DNI si es igual al Loggueado
                    if($_POST['Usuario']['dni']!=$userLoginTemp{'dni'}){
                        Yii::app()->user->setFlash('error', "El DNI ingresado es incorrecto");
                        $this->redirect(array('EnviarMailActivacion'));
                    }
                    
                    //Valido el e-mail
                    if(!filter_var($_POST['Usuario']['email'], FILTER_VALIDATE_EMAIL)){
                        Yii::app()->user->setFlash('error', "El e-mail ingresado no es válido");
                        $this->redirect(array('EnviarMailActivacion'));
                    }
                    
                    //Genero el token
                    $token = Token::model()->createToken('activarCliente', 172800, array('idUsr'=>$userLogin{'id'}));
                    
                    //EnvioEmail
                    // TODO: Hacer envio de email
                    
                    //Vuelvo al Login
                    Yii::app()->user->setFlash('success', "Se ha enviado un mail a " . $_POST['Usuario']['email']);
                    $this->redirect(array('login'));
                }
                
                $this->render('enviarMailActivacion',array('model'=>$userLogin));
        }

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;              
                
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			$identity = new UserIdentity($model->username,(crypt($model->password,'SGE2017')));
                        
                        if($identity->authenticate()){
                            Yii::app()->user->login($identity); 
                            $usuarioCorrecto = Usuario::model()->findByAttributes(array('dni'=>$model{'username'}));
                            
                            if($usuarioCorrecto{'estado'}=='DESHABILITADO'){
                                $this->redirect(array('enviarMailActivacion'));
                            }
                            
                            if($usuarioCorrecto{'estado'}=='BLOQEUADO'){
                                Yii::app()->user->setFlash('error', "El usuario se encuentra bloqueado");
                                $this->redirect(array('login'));
                            }
                            
                            $usuarioCorrecto{'last_login'} = date('Y-m-d H:i:s');
                            if(!$usuarioCorrecto->save()){ 
                                 Yii::log('actionLogin', "ERROR", '');
                                 Yii::app()->user->setFlash('error', "{$e->getMessage()}");
                            }
                            $this->redirect(Yii::app()->user->returnUrl);
                        }else{
                            Yii::app()->user->setFlash('error', "Usuario o contraseña inválido");
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
}