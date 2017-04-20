<?php

class UsuarioController extends Controller
{
	
	
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
		
	public $layout='//layouts/column1';		
		/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
						
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
						
		);
	}
	
		/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update',),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','export','import','editable','toggle','bloquear', 'SelectLocalidad'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
		
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		
		if(isset($_GET['asModal'])){
			$this->renderPartial('view',array(
				'model'=>$this->loadModel($id),
			));
		}
		else{
						
			$this->render('view',array(
				'model'=>$this->loadModel($id),
			));
			
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		date_default_timezone_set('America/Argentina/Buenos_Aires');		
		$model=new Usuario;
                
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Usuario']))
		{                    
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$messageType='warning';
				$message = "Se ha producido un error interno ";
                                $model->apellido=$_POST['Usuario']['apellido'];
                                $model->nombre=$_POST['Usuario']['nombre'];
                                $model->dni=$_POST['Usuario']['dni'];
                                
                                $model->email="null@null.com";
				$model->hased_paswword=crypt($model->dni,Yii::app()->properties->hashPassword); 
                                
                                //Pasan a ser NULL
                                $model->domicilio="-";
                                $model->id_localidad=1;
                                $model->id_provincia=1;
                                $model->id_carrera=1;
                                $model->sexo='Masculino';
                                $model->celular="-";
                                $model->fecha_nacimiento='29/04/1990';
                                
                                $model->scenario = 'USUARIO_actionCreate';
                                
				if($model->validate()){
                                    
                                    //Pasan a ser NULL
                                    $model->domicilio=NULL;
                                    $model->id_localidad=NULL;
                                    $model->id_provincia=NULL;
                                    $model->id_carrera=NULL;
                                    $model->sexo=NULL;
                                    $model->celular=NULL;
                                    $model->fecha_nacimiento=NULL;
                                    
                                        //Verifico si no existe otro usuario con el mismo DNI
                                        $usuarioAux = new Usuario();
                                        $usuarioAux = Usuario::model()->findAllByAttributes(array('dni'=>$model{'dni'}));
                                        if($usuarioAux==null){
                                             $model->save(false);
                                            
                                            $UsuarioRol = new UsuarioRol();
                                            $UsuarioRol->id_rol='alumno';
                                            $UsuarioRol->id_usuario=$model{'id'};
                                            $UsuarioRol->save();

                                            $messageType = 'success';
                                            $message = "Se ha guardado el usuario con éxito";
                                            $transaction->commit();
                                            Yii::log('Usuario guardado con exito', "INFO", '');
                                            Yii::app()->user->setFlash($messageType, $message);
                                            $this->redirect(array('create'));
                                        }else{
                                            $messageType = 'warning';
                                            $message = "Ya existe un usuario con el DNI: " . $model{'dni'};
                                            $transaction->rollBack();                                            
                                            Yii::app()->user->setFlash($messageType, $message);
                                        }
				}				
			}
			catch (Exception $e){
				$transaction->rollBack();
                                Yii::log('Usuario no guardado: ' + $e->getMessage(), "error", '');
				Yii::app()->user->setFlash('error', "{$e->getMessage()}");
				//$this->refresh();
			}
			
		}
              
                
//                require ('extensions/phpmailer/class.phpmailer.php');
//                $mail = new PHPMailer(); $mail->IsSMTP(); 
//                $mail->Host = 'smtp.gmail.com'; 
//                $mail->SMTPAuth = true;                
//                $mail->SMTPSecure = true; 
//                $mail->Username = 'marcosrole@gmail.com'; 
//                $mail->Port = 465; 
//                $mail->Password = 'vera2016'; 
//                $mail->SMTPKeepAlive = true;  
//                $mail->Mailer = "smtp"; 
//                $mail->IsSMTP(); // telling the class to use SMTP  
//                $mail->SMTPAuth   = true;  
//                $mail->CharSet = 'utf-8';  
//                $mail->SMTPDebug  = 0;
//                $mail->SetFrom('marcosrole@gmail.com', 'myname'); 
//                $mail->Subject = 'PHPMailer Test Subject via GMail, basic with authentication'; 
//                $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; 
//                $mail->MsgHTML('<h1>JUST A TEST!</h1>'); 
//                $mail->AddAddress('marcosrole@gmail.com', 'John Doe'); $mail->Send();
//                if($mail->Send()){
//                    Yii::app()->user->setFlash('error','Thank you for... as possible.');
//                }else{
//                    Yii::app()->user->setFlash('error',$mail->ErrorInfo);
//                }
//                
                

		$this->render('create',array(
			'model'=>$model,
					));
		
				
	}
        
        public function actionSelectLocalidad() {
             $id_provincia = (int) $_POST ['Usuario']['id_provincia'];
              $lista = CHtml::listData(Localidad::model()->findAll('id_provincia =:id_provincia', array(':id_provincia'=>$id_provincia)), 'id', 'localidad');
              
              echo CHtml::tag('option', array('value'=>''), '-- Seleccione Localidad --', true);

             foreach ($lista as $valor=>$localidad) {
                 echo CHtml::tag('option', array('value'=>$valor), CHtml::encode($localidad), true);
             }
         }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		
		$model=$this->loadModel($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Usuario']))
		{
			$messageType='warning';
			$message = "There are some errors ";
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model->attributes=$_POST['Usuario'];
				$messageType = 'success';
				$message = "<strong>Well done!</strong> You successfully update data ";

				/*
				$uploadFile=CUploadedFile::getInstance($model,'filename');
				if(!empty($uploadFile)) {
					$extUploadFile = substr($uploadFile, strrpos($uploadFile, '.')+1);
					if(!empty($uploadFile)) {
						if($uploadFile->saveAs(Yii::app()->basePath.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'usuario'.DIRECTORY_SEPARATOR.$model->id.DIRECTORY_SEPARATOR.$model->id.'.'.$extUploadFile)){
							$model->filename=$model->id.'.'.$extUploadFile;
							$message .= 'and file uploded';
						}
						else{
							$messageType = 'warning';
							$message .= 'but file not uploded';
						}
					}						
				}
				*/

				if($model->save()){
					$transaction->commit();
					Yii::app()->user->setFlash($messageType, $message);
					$this->redirect(array('view','id'=>$model->id));
				}
			}
			catch (Exception $e){
				$transaction->rollBack();
				Yii::app()->user->setFlash('error', "{$e->getMessage()}");
				// $this->refresh(); 
			}

			$model->attributes=$_POST['Usuario'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
					));
		
			}
                        
        public function actionBloquear($id)
	{		
		$model=$this->loadModel($id);
                $messageType='error'; 
                $message = Yii::app()->properties->msgERROR_INTERNO;
                if(Yii::app()->user->getId() == $id){
                    Yii::app()->user->setFlash('warning', "El usuario se encuentra en sesión"); 
                    $this->redirect(array('admin'));
                }else{
                    $transaction = Yii::app()->db->beginTransaction();
                    try{
                            $messageType = 'success';				
                            if($model{'estado'}=='DESBLOQUEADO' || $model{'estado'}=='DESHABILITADO'){
                                $model->estado="BLOQUEADO";
                                $message = "Se ha bloqueado el usuario ";
                            }else{
                                $model->estado="DESHABILITADO";
                                $model->hased_paswword=crypt($model->dni,Yii::app()->properties->hashPassword); 
                                $message = "Se ha desbloqueado el usuario ";
                            }                      
                            if($model->save()){  
                                    $transaction->commit();  
                                    Yii::app()->user->setFlash($messageType, $message);
                                    $this->redirect(array('admin'));                     

                            }else{
                                 $transaction->rollBack();
                                 Yii::app()->user->setFlash('warning', "El usuario se encuentra en sesión");
                            }
                    }
                    catch (Exception $e){
                            $transaction->rollBack();
                            Yii::log('actionBloquear', "ERROR", '');
                            Yii::app()->user->setFlash('error', Yii::app()->properties->msgERROR_INTERNO);
                            // $this->refresh(); 
                    }	
                }
                $model=new Usuario('search');
		$model->unsetAttributes();
                $this->render('admin',array('model'=>$model,));		
		
        }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		/*
		$dataProvider=new CActiveDataProvider('Usuario');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
		*/
		
		$model=new Usuario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Usuario']))
			$model->attributes=$_GET['Usuario'];

		$this->render('index',array(
			'model'=>$model,
					));
		
			}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
		$model=new Usuario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Usuario']))
			$model->attributes=$_GET['Usuario'];

		$this->render('admin',array(
			'model'=>$model,
					));
		
			}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Usuario the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Usuario::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Usuario $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionExport()
    {
        $model=new Usuario;
		$model->unsetAttributes();  // clear any default values
		if(isset($_POST['Usuario']))
			$model->attributes=$_POST['Usuario'];

		$exportType = $_POST['fileType'];
        $this->widget('ext.heart.export.EHeartExport', array(
            'title'=>'List of Usuario',
            'dataProvider' => $model->search(),
            'filter'=>$model,
            'grid_mode'=>'export',
            'exportType'=>$exportType,
            'columns' => array(
	                
					'id',
					'nombre',
					'apellido',
					'dni',
					'email',
					'estado',
					'hased_paswword',
					'last_login',
					//'created',
					'last_update',
	            ),
        ));
    }

    /**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionImport()
	{
		
		$model=new Usuario;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Usuario']))
		{
			if (!empty($_FILES)) {
				$tempFile = $_FILES['Usuario']['tmp_name']['fileImport'];
				$fileTypes = array('xls','xlsx'); // File extensions
				$fileParts = pathinfo($_FILES['Usuario']['name']['fileImport']);
				if (in_array(@$fileParts['extension'],$fileTypes)) {

					Yii::import('ext.heart.excel.EHeartExcel',true);
	        		EHeartExcel::init();
	        		$inputFileType = PHPExcel_IOFactory::identify($tempFile);
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$objPHPExcel = $objReader->load($tempFile);
					$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
					$baseRow = 2;
					$inserted=0;
					$read_status = false;
					while(!empty($sheetData[$baseRow]['A'])){
						$read_status = true;						
						//$id=  $sheetData[$baseRow]['A'];
						$nombre=  $sheetData[$baseRow]['B'];
						$apellido=  $sheetData[$baseRow]['C'];
						$dni=  $sheetData[$baseRow]['D'];
						$email=  $sheetData[$baseRow]['E'];
						$estado=  $sheetData[$baseRow]['F'];
						$hased_paswword=  $sheetData[$baseRow]['G'];
						$last_login=  $sheetData[$baseRow]['H'];
						//$created=  $sheetData[$baseRow]['I'];
						$last_update=  $sheetData[$baseRow]['J'];

						$model2=new Usuario;
						//$model2->id=  $id;
						$model2->nombre=  $nombre;
						$model2->apellido=  $apellido;
						$model2->dni=  $dni;
						$model2->email=  $email;
						$model2->estado=  $estado;
						$model2->hased_paswword=  $hased_paswword;
						$model2->last_login=  $last_login;
						//$model2->created=  $created;
						$model2->last_update=  $last_update;

						try{
							if($model2->save()){
								$inserted++;
							}
						}
						catch (Exception $e){
							Yii::app()->user->setFlash('error', "{$e->getMessage()}");
							//$this->refresh();
						} 
						$baseRow++;
					}	
					Yii::app()->user->setFlash('success', ($inserted).' row inserted');	
				}	
				else
				{
					Yii::app()->user->setFlash('warning', 'Wrong file type (xlsx, xls, and ods only)');
				}
			}


			$this->render('admin',array(
				'model'=>$model,
			));
		}
		else{
			$this->render('admin',array(
				'model'=>$model,
			));
		}
	}

	public function actionEditable(){
	    Yii::import('bootstrap.widgets.TbEditableSaver'); 
	    $es = new TbEditableSaver('Usuario'); 
            $es->update(); 
	}

	public function actions()
	{
    	return array(
        		'toggle' => array(
                	'class'=>'bootstrap.actions.TbToggleAction',
                	'modelName' => 'Usuario',
        		)
    	);
	}

	
}
