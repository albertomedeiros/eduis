<?php
class Department_SubjectDepartmentController extends Aceis_Base_BaseController {
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
		$this->jqgrid = new Aceis_Base_Helper_Jqgrid ( );
		self::createModel();
		$request = $this->getRequest ();
		$valid = $request->getParam ( 'nd' );
		$department_id = $request->getParam('department_id');
		if ($request->isXmlHttpRequest () and $valid) {
			
			$this->jqgrid->setGridparam ( $request );
			
			$this->jqgrid->sql = $this->model->select ()->from ( $this->model->info ( 'name' ) )->where('department_id = ?',$department_id);
			
			$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'department_id' :
						case 'degree_id' :
							$this->jqgrid->sql->where ( "$key LIKE ?", $value . '%' );
							break;
						case 'subject_code' :
						case 'semester_id' :
							$this->jqgrid->sql->where ( "$key = ?", $value );
							break;
					}
				}
			}
			self::fillgridfinal ();
		
		} else {
			header ( "HTTP/1.1 403 Forbidden" );
		}
	
	}
	
	
	/*
	 * Subjects in a semester
	 */
	public function getsemsubjectAction() {
		$request = $this->getRequest ();
		$format = $request->getParam ( 'format', 'json' );
		$department_id = $request->getParam ( 'department_id' );
		$degree_id = $request->getParam ( 'degree_id' );
		$semester_id = $request->getParam ( 'semester_id' );
		$subject_type_id = $request->getParam ( 'subject_type_id' );
		if (isset ( $department_id ) and isset ( $degree_id ) and isset ( $semester_id )) {
			$result = Department_Model_DbTable_SubjectDepartment::getSemesterSubjects ( $department_id, $degree_id, $semester_id, $subject_type_id );
			switch (strtolower ( $format )) {
				case 'json' :
					$this->_helper->json ( $result );
					return;
				case 'select' :
					echo '<select>';
					echo '<option value = "">Select one</option>';
					foreach ( $result as $key => $subject ) {
						echo '<option value="' . $subject ['subject_code'] . '">' . $subject ['subject_code'] . ' | ' . $subject ['subject_name'] . '</option>';
					}
					echo '</select>';
					return;
				default :
					header ( "HTTP/1.1 400 Bad Request" );
					echo 'Unsupported format';
			}
		} else {
			header ( "HTTP/1.1 400 Bad Request" );
		}
	}
	
	/*
	 * Faculty teaching in a semester
	 */
	/*public function combosemfacultyAction() {
		$request = $this->getRequest ();
		$department_id = $request->getParam ( 'department_id' );
		$degree_id = $request->getParam ( 'degree_id' );
		$semester_id = $request->getParam ( 'semester_id' );
		$subject_type_id = $request->getParam ( 'subject_type_id' );
		
		if (isset ( $department_id ) and isset ( $degree_id ) and isset ( $semester_id )) {
			$result = $this->table->getSemesterFaculty ( $department_id, $degree_id, $semester_id, $subject_type_id );
			
			echo '<select>';
			echo '<option>Select one</option>';
			foreach ( $result as $key => $staff ) {
				echo '<option value="' . $staff ['staff_id'] . '">' . $staff ['first_name'] . ' ' . $staff ['last_name'] . ' | ' . $staff ['department_id'] . '</option>';
			}
			echo '</select>';
		}
	
	}*/

}
