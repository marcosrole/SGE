<?php

class InscripcionmateriaController extends Controller
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
				'actions'=>array('create','update','ConfirmarInscripcion','admin','delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','export','import','editable','toggle',),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
        public function actionConfirmarInscripcion($idMateria)
	{
                $Materia = Materia::model()->findByPk($idMateria);   
                $mesaExistente = Mesa::model()->dentroPeriodo(date('Y-m-d H:i:s'));
                if($mesaExistente==NULL){
                    Yii::log('actionConfirmarInscripcion', "ERROR", '');
                    Yii::app()->user->setFlash('warning', "No existe mesa a inscribirse");
                    $this->redirect(array('inscripcionmateria/create'));
                }else{
                    $Inscripcion = New Inscripcionmateria();
                    $Inscripcion{'id_usuario'} = Yii::app()->user->getId();
                    $Inscripcion{'id_materia'} = $idMateria;
                    $Inscripcion{'id_mesa'} = $mesaExistente{'id'};
                    $Inscripcion{'ticket'} = $this->generateCode();
                    if($Inscripcion->insert()){
                        Yii::app()->user->setFlash('success', '<strong>Inscripción correcta. </strong> Nº de Ticket: ' . $Inscripcion{'ticket'});
                        $this->redirect(array('inscripcionmateria/create'));
                    }else{                
                        Yii::log('actionConfirmarInscripcion', "ERROR", '');
                        Yii::app()->user->setFlash('error', Yii::app()->properties->msgERROR_INTERNO);
                        $this->redirect(array('inscripcionmateria/create','materia'=>Materia::model()->findByPk($idMateria)));
                    }
                }
                
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
				'materia'=>Materia::model()->findByPk($id),
			));
			
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{           
                
                $mesaExistente = Mesa::model()->dentroPeriodo(date('Y-m-d H:i:s'));
                $alumno = Usuario::model()->findByAttributes(array('id'=>Yii::app()->user->getId()));
                $carrera = $alumno->carrera;   
//                $materias=Materia::model()->findByAttributes(array('id_carrera'=>$carrera{'id'}));
                $materias = new Materia('search');
                
                if($mesaExistente!=NULL){
                    
                    $model=new Inscripcionmateria;

                    // Uncomment the following line if AJAX validation is needed
                    // $this->performAjaxValidation($model);

                    if(isset($_POST['Inscripcionmateria']))
                    {
                            $transaction = Yii::app()->db->beginTransaction();
                            try{
                                    $messageType='warning';
                                    $message = "There are some errors ";
                                    $model->attributes=$_POST['Inscripcionmateria'];
                                    //$uploadFile=CUploadedFile::getInstance($model,'filename');
                                    if($model->save()){
                                            $messageType = 'success';
                                            $message = "<strong>Well done!</strong> You successfully create data ";
                                            /*
                                            $model2 = Inscripcionmateria::model()->findByPk($model->id);						
                                            if(!empty($uploadFile)) {
                                                    $extUploadFile = substr($uploadFile, strrpos($uploadFile, '.')+1);
                                                    if(!empty($uploadFile)) {
                                                            if($uploadFile->saveAs(Yii::app()->basePath.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'inscripcionmateria'.DIRECTORY_SEPARATOR.$model2->id.DIRECTORY_SEPARATOR.$model2->id.'.'.$extUploadFile)){
                                                                    $model2->filename=$model2->id.'.'.$extUploadFile;
                                                                    $model2->save();
                                                                    $message .= 'and file uploded';
                                                            }
                                                            else{
                                                                    $messageType = 'warning';
                                                                    $message .= 'but file not uploded';
                                                            }
                                                    }						
                                            }
                                            */
                                            $transaction->commit();
                                            Yii::app()->user->setFlash($messageType, $message);
                                            $this->redirect(array('view','id'=>$model->id));
                                    }				
                            }
                            catch (Exception $e){
                                    $transaction->rollBack();
                                    Yii::app()->user->setFlash('error', "{$e->getMessage()}");
                                    //$this->refresh();
                            }

                    }
                    
                    $this->render('create',array(
                            'mesaExamen'=>$mesaExistente,
                            'carrera' => $carrera,
                            'materias' => $materias
                                            ));

                    
                }else{
                   $this->render('create',array(
                       'mesaExamen'=>$mesaExistente,
                       'carrera' => $carrera,
                       'materias' => $materias
                       )); 
                }
		
				
	}
        
        /**
         * Generador automatico de Ticket
         * 
         */
        
        public function generateCode(){
            $unique =   FALSE;
            $length =   7;
//            $chrDb  =   array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9');
            $chrDb  =   array('0','1','2','3','4','5','6','7','8','9');

            while (!$unique){
                  $str = '';
                  for ($count = 0; $count < $length; $count++){

                      $chr = $chrDb[rand(0,count($chrDb)-1)];

                      if (rand(0,1) == 0){
                         $chr = strtoupper($chr);
                      }                      
                      $str .= $chr;
                  }
                  /* check if unique */
//                  $existingCode = Inscripcionmateria::model()->findAllByAttributes(array('ticket'=>$str)); 
//                  if ($existingCode!=NULL){
                     $unique = TRUE;
//                  }
            }
            return $str;
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

		if(isset($_POST['Inscripcionmateria']))
		{
			$messageType='warning';
			$message = "There are some errors ";
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model->attributes=$_POST['Inscripcionmateria'];
				$messageType = 'success';
				$message = "<strong>Well done!</strong> You successfully update data ";

				/*
				$uploadFile=CUploadedFile::getInstance($model,'filename');
				if(!empty($uploadFile)) {
					$extUploadFile = substr($uploadFile, strrpos($uploadFile, '.')+1);
					if(!empty($uploadFile)) {
						if($uploadFile->saveAs(Yii::app()->basePath.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'inscripcionmateria'.DIRECTORY_SEPARATOR.$model->id.DIRECTORY_SEPARATOR.$model->id.'.'.$extUploadFile)){
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

			$model->attributes=$_POST['Inscripcionmateria'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
					));
		
			}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
            var_dump($id); die();
            
            if($this->loadModel($id)->delete()){
                Yii::app()->user->setFlash('success', 'Se ha eliminado la inscripción');
                $this->redirect(array('inscripcionmateria/admin'));
            }else{
                Yii::log('No se ha eliminado la inscripción', "ERROR", '');
                Yii::app()->user->setFlash('error', Yii::app()->properties->msgERROR_INTERNO);
                $this->redirect(array('inscripcionmateria/admin'));
            }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		/*
		$dataProvider=new CActiveDataProvider('Inscripcionmateria');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
		*/
		
		$model=new Inscripcionmateria('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Inscripcionmateria']))
			$model->attributes=$_GET['Inscripcionmateria'];

		$this->render('index',array(
			'model'=>$model,
					));
		
			}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
		$model=new Inscripcionmateria('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Inscripcionmateria']))
			$model->attributes=$_GET['Inscripcionmateria'];

		$this->render('admin',array(
			'model'=>$model,
					));
		
			}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Inscripcionmateria the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Inscripcionmateria::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Inscripcionmateria $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='inscripcionmateria-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionExport()
    {
        $model=new Inscripcionmateria;
		$model->unsetAttributes();  // clear any default values
		if(isset($_POST['Inscripcionmateria']))
			$model->attributes=$_POST['Inscripcionmateria'];

		$exportType = $_POST['fileType'];
        $this->widget('ext.heart.export.EHeartExport', array(
            'title'=>'List of Inscripcionmateria',
            'dataProvider' => $model->search(),
            'filter'=>$model,
            'grid_mode'=>'export',
            'exportType'=>$exportType,
            'columns' => array(
	                
					'id',
					'id_usuario',
					'id_materia',
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
		
		$model=new Inscripcionmateria;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Inscripcionmateria']))
		{
			if (!empty($_FILES)) {
				$tempFile = $_FILES['Inscripcionmateria']['tmp_name']['fileImport'];
				$fileTypes = array('xls','xlsx'); // File extensions
				$fileParts = pathinfo($_FILES['Inscripcionmateria']['name']['fileImport']);
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
						$id_usuario=  $sheetData[$baseRow]['B'];
						$id_materia=  $sheetData[$baseRow]['C'];
						//$created=  $sheetData[$baseRow]['D'];
						$last_update=  $sheetData[$baseRow]['E'];

						$model2=new Inscripcionmateria;
						//$model2->id=  $id;
						$model2->id_usuario=  $id_usuario;
						$model2->id_materia=  $id_materia;
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
		Yii::import('booster.widgets.TbEditableSaver'); 
	    $es = new TbEditableSaver('Inscripcionmateria'); 
			    $es->update();
	}

	public function actions()
	{
    	return array(
        		'toggle' => array(
                	'class'=>'bootstrap.actions.TbToggleAction',
                	'modelName' => 'Inscripcionmateria',
        		)
    	);
	}

	
}
