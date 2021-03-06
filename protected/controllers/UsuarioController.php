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
        
        public function accessRules(){
            if( in_array("admin", Yii::app()->user->getState('rol'))){ 
                 $arr =array('admin','view','bloquear','export','create','update',);   // give all access to admin
            }else if( in_array("alumno", Yii::app()->user->getState('rol'))){
                 $arr =array('');   // give all access to staff
                }else{
                    $arr = array('');          //  no access to other user
                }
                
            return array(                   
                array('allow', 
                                'actions'=>$arr,
                                'users'=>array('@'),
                        ), 
                array('allow', 
                                'actions'=>array('SelectLocalidad'),
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
                $UsuarioRol = new UsuarioRol();
                Yii::log("usrID:" . Yii::app()->user->id . " Crear usuario", "trace", "application.controllers.UsuarioController");
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
                                            
                                            if($_POST['Usuario']['isDocente'] == "1"){
                                               $UsuarioRol->id_rol='docente'; 
                                               Yii::log("usrID:" . Yii::app()->user->id . " Nuevo usuario: Docente: " + $model{'dni'}, "info", "application.controllers.UsuarioController");
                                            }else{
                                                $UsuarioRol->id_rol='alumno';
                                                Yii::log("usrID:" . Yii::app()->user->id . " Nuevo usuario: Alumno: " + $model{'dni'}, "info", "application.controllers.UsuarioController");
                                            }                                            
                                            $UsuarioRol->id_usuario=$model{'id'};
                                            $UsuarioRol->save();

                                            $messageType = 'success';
                                            $message = "Se ha guardado el usuario con éxito";
                                            $transaction->commit();
                                            Yii::log("usrID:" . Yii::app()->user->id . " Nuevo usuario. DNI: " + $model{'dni'}, "info", "application.controllers.UsuarioController");
                                            Yii::app()->user->setFlash($messageType, $message);
                                            $this->redirect(array('create'));
                                        }else{
                                            $messageType = 'warning';
                                            Yii::log("usrID:" . Yii::app()->user->id . " Existe usuario con el mismo DNI", "warning", "application.controllers.UsuarioController");
                                            $message = "Ya existe un usuario con el DNI: " . $model{'dni'};
                                            $transaction->rollBack();                                            
                                            Yii::app()->user->setFlash($messageType, $message);
                                        }
				}				
			}
			catch (Exception $e){
				$transaction->rollBack();
                                 Yii::log("usrID:" . Yii::app()->user->id . " Usuario no almacenado " + $e->getMessage(), "error", "application.controllers.UsuarioController");
				Yii::app()->user->setFlash('error', "{$e->getMessage()}");
				//$this->refresh();
			}
			
		}
                
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
		date_default_timezone_set('America/Argentina/Buenos_Aires');
		$model=$this->loadModel($id);
                $model{'fecha_nacimiento'} = date("d/m/Y", strtotime($model{'fecha_nacimiento'}));               
                
                $localidad = Localidad::model()->findByPk($model{'id_localidad'});
                $model{'id_provincia'} = $localidad{'id_provincia'};
		if(isset($_POST['Usuario']))
		{                        
                        $messageType='warning';
			$message = "Existen errores en los datos ";
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model->attributes=$_POST['Usuario'];                                
				$messageType = 'success';
				$message = "Los datos se han actualizado correctamente ";  
                                
                                if($model->validate()){
                                    $model{'last_update'} = date('Y-m-d H:i:s');
                                    $date = str_replace('/', '-', $model{'fecha_nacimiento'});
                                    $model{'fecha_nacimiento'} = date("Y-m-d", strtotime($date));                                  
                                    if($model->save(false)){                                    
                                       $transaction->commit(); 
                                       Yii::app()->user->setFlash($messageType, $message);
                                       Yii::log("usrID:" . Yii::app()->user->id . " Se actualizó el usuario: " + $model{'dni'}, "info", "application.controllers.UsuarioController");
                                       $this->redirect('admin');
                                   }   
                                }
			}
			catch (Exception $e){
				$transaction->rollBack();
                                Yii::log("usrID:" . Yii::app()->user->id . " Usuario no actualizado " + $e->getMessage(), "error", "application.controllers.UsuarioController");
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
                        
        public function actionBloquear($id){
		$model=$this->loadModel($id);
                $messageType='error'; 
                $message = Yii::app()->properties->msgERROR_INTERNO;
                if(Yii::app()->user->getId() == $id){
                    Yii::app()->user->setFlash('warning', "El usuario se encuentra en sesión"); 
                    Yii::log("El usuario " + $model{'dni'} + " se encuentra en sesiòn ", "warning", "application.controllers.UsuarioController");
                    $this->redirect(array('admin'));
                }else{
                    $transaction = Yii::app()->db->beginTransaction();
                    try{
                            $messageType = 'success';				
                            if($model{'estado'}=='ACTIVO'){
                                $model->estado="BLOQUEADO";
                                $message = "Se ha bloqueado el usuario ";
                                Yii::log("Usuario " + $model{'dni'} + " bloqueado ", "info", "application.controllers.UsuarioController");
                                $model{'last_update'} = date('Y-m-d H:i:s');
                            }elseif ($model{'estado'}=='DESHABILITADO') {
                                 Yii::app()->user->setFlash('error', "No se puede Bloquear el usuario. El usuario no se encuentra activo");
                                 $this->redirect(array('admin'));
                            }else{
                                $model->estado="ACTIVO";  
                                Yii::log("Usuario " + $model{'dni'} + " està activo ", "info", "application.controllers.UsuarioController");
                                $message = "Se ha desbloqueado el usuario";
                                $model{'last_update'} = date('Y-m-d H:i:s');
                            }      
                            
                            
                            if($model->save(false)){  
                                    $transaction->commit();                                     
                                    Yii::app()->user->setFlash($messageType, $message);
                                    $this->redirect(array('admin'));                     

                            }else{
                                 $transaction->rollBack();
                                 Yii::app()->user->setFlash('error', $message);
                            }
                    }
                    catch (Exception $e){
                            $transaction->rollBack();
                            Yii::log("No se bloquedo/activo el usuario " + $model{'dni'} + ". " + $e->getMessage(), "error", "application.controllers.UsuarioController");
                            Yii::app()->user->setFlash('error', Yii::app()->properties->msgERROR_INTERNO);
                            // $this->refresh(); 
                    }	
                }
                $model=new Usuario('search');
		$model->unsetAttributes();
                $this->render('admin',array('model'=>$model,));		
		
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
            'title'=>'Listado de Usuarios',
            'dataProvider' => $model->search(),
            'filter'=>$model,
            'grid_mode'=>'export',
            'exportType'=>$exportType,
            'columns' => array(
                            'dni',
                            'apellido',
                            'nombre',
                            'email',
                            'estado',
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
