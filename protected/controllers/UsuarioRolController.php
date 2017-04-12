<?php

class UsuarioRolController extends Controller
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
             
            if( Yii::app()->user->getState('rol') == "admin"){ 
                 $arr =array('admin','view');   // give all access to admin
            }else if( Yii::app()->user->getState('rol') =="alumno"){
                    $arr =array('index','staff','staffcalendar','update');   // give all access to staff
                }else{
                    $arr = array('');          //  no access to other user
                  }
                
            return array(                   
                array('allow', 
                                'actions'=>$arr,
                                'users'=>array('@'),
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
            $messageType = 'error';
            if(isset($_POST['UsuarioRol'])){ 
                $model = UsuarioRol::model()->findByPk($id);                
                if($_POST['UsuarioRol']['isAdmin']=="0"){
                    $model{'id_rol'}='admin'; 
                }elseif ($_POST['UsuarioRol']['isAdmin']=='1') { 
                    $model{'id_rol'}='alumno';
                }
                $model{'last_update'} = date('Y-m-d H:i:s');
                if($model->validate() && $model->save()){
                    $messageType = 'success';
                    $message = "Se ha modificado el rol con éxito.";
                    Yii::log('Usuario guardado con exito', "INFO", '');
                    Yii::app()->user->setFlash($messageType, $message);
                }else{
                    Yii::log('No se almacenó el rol al usuario', "error", '');
                    Yii::app()->user->setFlash($messageType, $message);
                }
                $this->redirect(array('admin'));
            }
            
		if(isset($_GET['asModal'])){                    
                        $model = new UsuarioRol();
                        $model = UsuarioRol::model()->findByPk($id);
                        $usuario = Usuario::model()->findByPk($model{'id_usuario'});
                        $rol = Rol::model()->findByPk($model{'id_rol'});
                        $model->usuario_nombre=$usuario{'nombre'};
                        $model->usuario_apellido=$usuario{'apellido'};
                        $model->usuario_dni=$usuario{'dni'};
                        $model->usuario_email=$usuario{'email'};
                        $model->rol_nombre=$rol{'nombre'};
                        
                        if($rol{'id'}=='admin'){
                            $model->isAdmin=0; //Posicion 0
                        }else{
                            $model->isAdmin=1; //Posicion 1
                        }
                        
			$this->renderPartial('modalEdit',array(
				'model'=>$model,
			));
		}
		else{		
			$this->render('view',array(
				'model'=>$this->loadModel($id),
			));
			
		}
	}

        /**
	 * Manages all models.
	 */
	public function actionAdmin()
	{			
		if(isset($_GET['UsuarioRol']))
			$model->attributes=$_GET['UsuarioRol'];
		
                $this->render('admin',array('model'=>new UsuarioRol()));                
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return UsuarioRol the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=UsuarioRol::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param UsuarioRol $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuario-rol-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionExport()
    {
        $model=new UsuarioRol;
		$model->unsetAttributes();  // clear any default values
		if(isset($_POST['UsuarioRol']))
			$model->attributes=$_POST['UsuarioRol'];

		$exportType = $_POST['fileType'];
        $this->widget('ext.heart.export.EHeartExport', array(
            'title'=>'List of UsuarioRol',
            'dataProvider' => $model->search(),
            'filter'=>$model,
            'grid_mode'=>'export',
            'exportType'=>$exportType,
            'columns' => array(
	                
					'id',
					'id_rol',
					'id_usuario',
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
		
		$model=new UsuarioRol;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['UsuarioRol']))
		{
			if (!empty($_FILES)) {
				$tempFile = $_FILES['UsuarioRol']['tmp_name']['fileImport'];
				$fileTypes = array('xls','xlsx'); // File extensions
				$fileParts = pathinfo($_FILES['UsuarioRol']['name']['fileImport']);
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
						$id_rol=  $sheetData[$baseRow]['B'];
						$id_usuario=  $sheetData[$baseRow]['C'];
						//$created=  $sheetData[$baseRow]['D'];
						$last_update=  $sheetData[$baseRow]['E'];

						$model2=new UsuarioRol;
						//$model2->id=  $id;
						$model2->id_rol=  $id_rol;
						$model2->id_usuario=  $id_usuario;
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
	    $es = new TbEditableSaver('UsuarioRol'); 
			    $es->update();
	}

	public function actions()
	{
    	return array(
        		'toggle' => array(
                	'class'=>'bootstrap.actions.TbToggleAction',
                	'modelName' => 'UsuarioRol',
        		)
    	);
	}

	
}
