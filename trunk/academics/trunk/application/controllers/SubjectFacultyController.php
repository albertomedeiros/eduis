<?php
class Department_SubjectFacultyController extends Aceis_Base_BaseController {
	
	public function init() {
		
		$this->_autoModel = TRUE;
		$this->_autoDbCols = TRUE;
		parent::init ();
	}
	
	/*
     * @about Interface.
     */
	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
		$this->view->assign ( 'controller', $this->_request->getControllerName () );
		$this->view->assign ( 'module', $this->_request->getModuleName () );
		$this->view->assign('department_id',$_SESSION['staff_detail']['department_id']);
	}
	
	/*
     * Back end data provider to datagrid.
     * @return JSON data
     */
	public function fillgridAction() {
		$request = $this->getRequest ();
		$valid = $request->getParam ( 'nd' );
		if ($request->isXmlHttpRequest () and $valid) {
			$this->jqgrid = new Aceis_Base_Helper_Jqgrid ( );
			$this->jqgrid->setGridparam ( $request );
			$this->jqgrid->sql = Zend_Db_Table::getDefaultAdapter ()->select ()->from ( $this->model->info ( 'name' ),array('subject_faculty.subject_code','subject_mode_id','staff_id','subject_department.degree_id','department_id','department_id','subject_department.semester_id') )
														->join('subject_department','(subject_department.subject_code = subject_faculty.subject_code)',array())
														->where('subject_faculty.department_id = ?','cse');
			
			$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'staff_id' :
						case 'subject_code' :
							$this->jqgrid->sql->where ( "$key LIKE ?", $value . '%' );
							break;
						case 'subject_mode_id' :
							$this->jqgrid->sql->where ( "$key = ?", $value );
							break;
					}
				}
			}
			$this->fillgridfinal ();
		
		} else {
			echo ('<b>Oops!! </b><br/>No use of peeping like that... :)');
		}
		
		}
		
	public function getsubjectfacultyAction() {
		$request = $this->getRequest ();
		$subject_code = $request->getParam ( 'subject_code' );
		$subject_mode = $request->getParam ( 'subject_mode_id' );
		$department_id = $request->getParam ( 'department_id' );
		$format = $this->getRequest ()->getParam ( 'format', 'json' );
		if (isset ( $subject_code )) {
			$result = $this->model->getSubjectFaculty ( $subject_code, $subject_mode, $department_id );
			switch (strtolower ( $format )) {
				case 'json' :
					$this->_helper->json ( $result );
					return;
				case 'select' :
					echo '<select>';
					if (1 == count ( $result )) {
						echo '<option value="' . $result [0] ['staff_id'] . '">' . $result [0] ['first_name'] . ' ' . $result [0] ['last_name'] . '</option>';
					} else {
						echo '<option>Select one</option>';
						foreach ( $result as $key => $staff ) {
							echo '<option value="' . $staff ['staff_id'] . '">' . $staff ['first_name'] . ' ' . $staff ['last_name'] . '</option>';
						}
					}
					
					echo '</select>';
					return;
			}
		}
		
		header ( "HTTP/1.1 400 Bad Request" );
		echo 'Either format type not supported or incorrect.';
		die ();
	
	}
	public function getdepartmentfacultyAction()
	{
		
		$department_id  = $this->getRequest()->getParam('department_id');
		$this->_helper->json(Department_Model_DbTable_SubjectFaculty::getDepartmentFaculty($department_id));	 		
	}
}