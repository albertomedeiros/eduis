  <?php
/**
 * StudentController
 * 
 * @author team eduis
 * @version 3
 */
class StudentController extends Zend_Controller_Action
{
    /**
     * 
     *@todo remove static value
     */
    protected $_member_id = 1;
    /**
     * The default action - show the home page
     */
    public function init ()
    {
        /* Initialize action controller here */
    }
    /**
     * @todo Consider :if you dont want any other class to call this function
     * make it private
     * dont allow even view to acess it
     * cause it is for internal functioning only
     * @return the $_member_id
     */
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    public function indexAction ()
    {
        // action body
    }
    /*
     * returns matric data of student
     * @param int qualification_id  
     * @return array $matric_data return array of present data of student in qualification table
     */
    private function fetchMatricData ($qualification_id)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_model = $student_model->fetchQualifiactionInfo(
        $qualification_id);
        if ($qualification_model instanceof Acad_Model_Qualification_Matric) {
            $matric_data['board'] = $qualification_model->getBoard();
            $matric_data['boardroll_no'] = $qualification_model->getBoard_roll_no();
            $matric_data['city_name'] = $qualification_model->getCity_name();
            $matric_data['institution'] = $qualification_model->getInstitution();
            $matric_data['marks_obtained'] = $qualification_model->getMarks_obtained();
            $matric_data['passing_year'] = $qualification_model->getPassing_year();
            $matric_data['percentage'] = $qualification_model->getPercentage();
            $matric_data['remarks'] = $qualification_model->getRemarks();
            $matric_data['school_ramk'] = $qualification_model->getSchool_rank();
            $matric_data['state_name'] = $qualification_model->getState_name();
            $matric_data['total_marks'] = $qualification_model->getTotal_marks();
            $matric_data['migration_date'] = $qualification_model->getTotal_marks();
        }
        return $matric_data;
    }
    /*
     * returns btech data of student
     * @param int qualification_id  
     * @return array $btech return array of present data of student in qualification table
     */
    private function fetchBtechData ($qualification_id)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_model = $student_model->fetchQualifiactionInfo(
        $qualification_id);
        if ($qualification_model instanceof Acad_Model_Qualification_Btech) {
            $btech_data['university'] = $qualification_model->getUniversity();
            $btech_data['board_roll_no'] = $qualification_model->getBoard_roll_no();
            $btech_data['city_name'] = $qualification_model->getCity_name();
            $btech_data['institution'] = $qualification_model->getInstitution();
            $btech_data['marks_obtained'] = $qualification_model->getMarks_obtained();
            $btech_data['passing_year'] = $qualification_model->getPassing_year();
            $btech_data['percentage'] = $qualification_model->getPercentage();
            $btech_data['remarks'] = $qualification_model->getRemarks();
            $btech_data['state_name'] = $qualification_model->getState_name();
            $btech_data['total_marks'] = $qualification_model->getTotal_marks();
            $btech_data['discipline_id'] = $qualification_model->getDiscipline_id();
            $btech_data['migration_date'] = $qualification_model->getMigration_date();
            ;
        }
        return $btech_data;
    }
    /*
     * returns twelfth data of student
     * @param int qualification_id  
     * @return array $twelfth_array return array of present data of student in qualification table
     */
    private function fetchTwelfthData ($qualification_id)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_model = $student_model->fetchQualifiactionInfo(
        $qualification_id);
        if ($qualification_model instanceof Acad_Model_Qualification_Twelfth) {
            $twelfth_data['board'] = $qualification_model->getBoard();
            $twelfth_data['board_roll_no'] = $qualification_model->getBoard_roll_no();
            $twelfth_data['city_name'] = $qualification_model->getCity_name();
            $twelfth_data['institution'] = $qualification_model->getInstitution();
            $twelfth_data['marks_obtained'] = $qualification_model->getMarks_obtained();
            $twelfth_data['passing_year'] = $qualification_model->getPassing_year();
            $twelfth_data['percentage'] = $qualification_model->getPercentage();
            $twelfth_data['remarks'] = $qualification_model->getRemarks();
            $twelfth_data['school_ramk'] = $qualification_model->getSchool_rank();
            $twelfth_data['state_name'] = $qualification_model->getState_name();
            $twelfth_data['total_marks'] = $qualification_model->getTotal_marks();
            $twelfth_data['discipline_id'] = $qualification_model->getDiscipline_id();
            $twelfth_data['pcm_percentage'] = $qualification_model->getPcm_percent();
            $twelfth_data['migration_date'] = $qualification_model->getMigration_date();
        }
        return $twelfth_data;
    }
    private function fetchDiplomaData ($qualification_id)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_model = $student_model->fetchQualifiactionInfo(
        $qualification_id);
        if ($qualification_model instanceof Acad_Model_Qualification_Diploma) {
            $diploma_data['university'] = $qualification_model->getUniversity();
            $diploma_data['board_roll_no'] = $qualification_model->getBoard_roll_no();
            $diploma_data['city_name'] = $qualification_model->getCity_name();
            $diploma_data['institution'] = $qualification_model->getInstitution();
            $diploma_data['marks_obtained'] = $qualification_model->getMarks_obtained();
            $diploma_data['passing_year'] = $qualification_model->getPassing_year();
            $diploma_data['percentage'] = $qualification_model->getPercentage();
            $diploma_data['remarks'] = $qualification_model->getRemarks();
            $diploma_data['state_name'] = $qualification_model->getState_name();
            $diploma_data['total_marks'] = $qualification_model->getTotal_marks();
            $diploma_data['discipline_id'] = $qualification_model->getDiscipline_id();
            $diploma_data['migration_date'] = $qualification_model->getMigration_date();
        }
        return $diploma_data;
    }
    private function fetchaieeeData ($exam_id)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $exam_data = array();
        $exam_model = $student_model->fetchCompetitveExamInfo($exam_id);
        if ($exam_model instanceof Acad_Model_Exam_Competitive) {
            $exam_data['name'] = $exam_model->getName();
            $exam_data['total_score'] = $exam_model->getTotal_score();
            $exam_data['abbr'] = $exam_model->getAbbr();
            $exam_data['air'] = $exam_model->getAll_india_rank();
            $exam_data['roll_no'] = $exam_model->getRoll_no();
            $exam_data['total_score'] = $exam_model->getTotal_score();
        }
        return $exam_data;
    }
    private function fetchleetData ($exam_id)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $exam_data = array();
        $exam_model = $student_model->fetchCompetitveExamInfo($exam_id);
        if ($exam_model instanceof Acad_Model_Exam_Competitive) {
            $exam_data['name'] = $exam_model->getName();
            $exam_data['total_score'] = $exam_model->getTotal_score();
            $exam_data['abbr'] = $exam_model->getAbbr();
            $exam_data['air'] = $exam_model->getAll_india_rank();
            $exam_data['roll_no'] = $exam_model->getRoll_no();
            $exam_data['total_score'] = $exam_model->getTotal_score();
        }
        return $exam_data;
    }
    private function fetchgateData ($exam_id)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $exam_data = array();
        $exam_model = $student_model->fetchCompetitveExamInfo($exam_id);
        if ($exam_model instanceof Acad_Model_Exam_Competitive) {
            $exam_data['name'] = $exam_model->getName();
            $exam_data['total_score'] = $exam_model->getTotal_score();
            $exam_data['abbr'] = $exam_model->getAbbr();
            $exam_data['air'] = $exam_model->getAll_india_rank();
            $exam_data['roll_no'] = $exam_model->getRoll_no();
            $exam_data['total_score'] = $exam_model->getTotal_score();
        }
        return $exam_data;
    }
    private function fetchDmcInfo ($single_dmc_info_id = null, 
    $class_specific = null, $result_type_specific = null, $all = null, 
    $considered_only = null, $ordered_by_date = null)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        if ($single_dmc_info_id) {
            $dmc_info = self::setDmcInfoData($single_dmc_info_id);
            return $dmc_info;
        }
        if ($ordered_by_date) {
            $dmc_info_ids = $student_model->fetchDmcInfoIds(null, true, null, 
            null, null, null);
            $dmc_info = self::setDmcInfoData($dmc_info_ids);
            return $dmc_info;
        }
        if ($result_type_specific) {
            $dmc_info_ids = $student_model->fetchDmcInfoIds(null, null, true, 
            null, null, true);
            $dmc_info = self::setDmcInfoData($dmc_info_ids);
            return $dmc_info;
        }
        if ($all) {
            $dmc_info_ids = $student_model->fetchDmcInfoIds(null, null, null, 
            true, null, null);
            $dmc_info = self::setDmcInfoData($dmc_info_ids);
            return $dmc_info;
        }
        if ($considered_only) {
            $dmc_info_ids = $student_model->fetchDmcInfoIds(null, null, null, 
            null, true, null);
            $dmc_info = self::setDmcInfoData($dmc_info_ids);
            return $dmc_info;
        }
        if ($ordered_by_date) {
            $dmc_info_ids = $student_model->fetchDmcInfoIds(null, null, null, 
            null, null, true);
            $dmc_info = self::setDmcInfoData($dmc_info_ids);
            return $dmc_info;
        }
    }
    private function setDmcInfoData ($dmc_info_ids)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        if (is_array($dmc_info_ids)) {
            $dmc_info_data = array();
            foreach ($dmc_info_ids as $dmc_info_id) {
                $dmc_info_model = $student_model->fetchDmcInfo($dmc_info_id);
                if ($dmc_info_model instanceof Acad_Model_Course_DmcInfo) {
                    $dmc_info_data[$dmc_info_id]['dmc_info_id'] = $dmc_info_model->getDmc_info_id();
                    $dmc_info_data[$dmc_info_id]['dispatch_date'] = $dmc_info_model->getDispatch_date();
                    $dmc_info_data[$dmc_info_id]['marks_obtained'] = $dmc_info_model->getMarks_obtained();
                    $dmc_info_data[$dmc_info_id]['percentage'] = $dmc_info_model->getPercentage();
                    $dmc_info_data[$dmc_info_id]['result_type_id'] = $dmc_info_model->getResult_type_id();
                    $dmc_info_data[$dmc_info_id]['scaled_marks'] = $dmc_info_model->getScaled_marks();
                    $dmc_info_data[$dmc_info_id]['total_marks'] = $dmc_info_model->getTotal_marks();
                }
            }
        } else {
            $dmc_info_model = $student_model->fetchDmcInfo($dmc_info_id);
            if ($dmc_info_model instanceof Acad_Model_Course_DmcInfo) {
                $dmc_info_data[$dmc_info_id]['dmc_info_id'] = $dmc_info_model->getDmc_info_id();
                $dmc_info_data[$dmc_info_id]['dispatch_date'] = $dmc_info_model->getDispatch_date();
                $dmc_info_data[$dmc_info_id]['marks_obtained'] = $dmc_info_model->getMarks_obtained();
                $dmc_info_data[$dmc_info_id]['percentage'] = $dmc_info_model->getPercentage();
                $dmc_info_data[$dmc_info_id]['result_type_id'] = $dmc_info_model->getResult_type_id();
                $dmc_info_data[$dmc_info_id]['scaled_marks'] = $dmc_info_model->getScaled_marks();
                $dmc_info_data[$dmc_info_id]['total_marks'] = $dmc_info_model->getTotal_marks();
            }
        }
        return $dmc_info_data;
    }
    private function fetchsubjectDmc ($dmc_info_id, $subject_ids)
    {
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $dmc_data = array();
        if (is_array($subject_ids)) {
            foreach ($subject_ids as $subject_id) {
                $dmc_object = $student_model->fetchDmc($dmc_info_id, 
                $subject_id);
                if ($dmc_object instanceof Acad_Model_Course_DmcMarks) {
                    $dmc_data[$subject_id]['date'] = $dmc_object->getDate();
                    $dmc_data[$subject_id]['external'] = $dmc_object->getExternal();
                    $dmc_data[$subject_id]['internal'] = $dmc_object->getInternal();
                    $dmc_data[$subject_id]['percentage'] = $dmc_object->getPercentage();
                }
            }
        } else {
            $dmc_object = $student_model->fetchDmc($dmc_info_id, $subject_ids);
            if ($dmc_object instanceof Acad_Model_Course_DmcMarks) {
                $dmc_data['date'] = $dmc_object->getDate();
                $dmc_data['external'] = $dmc_object->getExternal();
                $dmc_data['internal'] = $dmc_object->getInternal();
                $dmc_data['percentage'] = $dmc_object->getPercentage();
            }
        }
        return $dmc_data;
    }
    public function fetchClassSubjects ($class_id)
    {
        $class_object = new Acad_Model_Class();
        $class_object->setClass_id($class_id);
        $subject_ids = $class_object->fetchSubjects();
        $subject_data = array();
        foreach ($subject_ids as $subject_id) {
            $subject_object = new Acad_Model_Subject();
            $subject_object->setSubject_id($subject_id);
            $subject_object->fetchInfo();
            $subject[$subject_id]['name'] = $subject_object->getSubject_name();
            $subject[$subject_id]['code'] = $subject_object->getSubject_name();
        }
        return $subject_data;
    }
    public function registerAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $critcal_info = $student_model->fetchCriticalInfo();
        Zend_Registry::get('logger')->debug($critcal_info);
        if ($critcal_info == false) {
            $PROTOCOL = 'http://';
            $URL_STU_CRITICAL_INFO = $PROTOCOL . CORE_SERVER .
             '/student/fetchcriticalinfo';
            $client = new Zend_Http_Client($URL_STU_CRITICAL_INFO);
            $client->setCookie('PHPSESSID', $_COOKIE['PHPSESSID']);
            $response = $client->request();
            if ($response->isError()) {
                $remoteErr = 'REMOTE ERROR: (' . $response->getStatus() . ') ' .
                 $response->getMessage();
                throw new Zend_Exception($remoteErr, Zend_Log::ERR);
            }
            $critical_data = Zend_Json::decode($response->getBody());
            if ($critical_data) {
                $student_model->saveCriticalInfo($critical_data);
            } else {
                $msg = 'PLEASE REGISTER IN CORE MODULE....GOTO core.aceambala.com';
                throw new Exception('$msg');
            }
        }
        $this->_redirect('student/checkstatus');
    }
    /**
     * @todo check status of profile in auth that it is filled or not
     * Enter description here ...
     */
    public function checkstatusAction ()
    {
        $profile_present = 1;
        if ($profile_present) {
            $this->_redirect('student/viewprofile');
        } else {
            $this->_redirect('student/createprofile');
        }
    }
    public function profileAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $this->_helper->viewRenderer->setNoRender(false);
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_data = array();
        $qualfication_ids = $student_model->fetchQualificationsIds();
        foreach ($qualfication_ids as $qualfication_id) {
            $qualfication_model = $student_model->fetchQualifiactionInfo(
            $qualfication_id);
            if ($qualfication_model instanceof Acad_Model_Qualification) {
                $qualification_data[$qualfication_id]['name'] = $qualfication_model->getQualification_name();
                $qualification_data[$qualfication_id]['id'] = $qualfication_id;
            }
        }
        $class_ids = $student_model->fetchAllClassIds();
        $model_member_id = $student_model->getMember_id();
        $degree_data = array();
        foreach ($class_ids as $class_id) {
            $class_model = new Acad_Model_Class();
            $class_model->setClass_id($class_id);
            $class_model->fetchInfo();
            $semester_id = $class_model->getSemester_id();
            $dmc_info_ids = $student_model->fetchDmcInfoIds(null, null, true, 
            null);
            foreach ($dmc_info_ids as $dmc_info_id) {
                $dmc_object = $student_model->fetchDmcInfo($dmc_info_id);
                if ($dmc_object instanceof Acad_Model_Course_DmcInfo) {
                    $degree_data[$semester_id][$dmc_info_id]['dispatch_date'] = $dmc_object->getDispatch_date();
                }
            }
        }
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($qualification_data)) {
                    $this->view->assign('qualification_data', 
                    $qualification_data);
                    $this->view->assign('degree_data', $degree_data);
                }
                Zend_Registry::get('logger')->debug($qualification_data);
                Zend_Registry::get('logger')->debug($degree_data);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' .
                 $this->_helper->json($qualification_data, false) . ')';
                break;
            case 'json':
                $this->_helper->json($qualification_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($qualification_data);
                break;
            default:
                ;
                break;
        }
    }
    public function viewmatricinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $qualification_data = self::fetchMatricData($params['qualification_id']);
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($qualification_data)) {
                    $this->view->assign('matric', $qualification_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' .
                 $this->_helper->json($qualification_data, false) . ')';
                break;
            case 'json':
                $this->_helper->json($qualification_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($qualification_data);
                break;
            default:
                ;
                break;
        }
    }
    public function viewtwelfthinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_model = $student_model->fetchQualifiactionInfo(
        $params['qualification_id']);
        $qualification_data = self::fetchMatricData($params['qualification_id']);
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($qualification_data)) {
                    $this->view->assign('matric', $qualification_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($qualification_data, 
                false) . ')';
                break;
            case 'json':
                $this->_helper->json($qualification_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($qualification_data);
                break;
            default:
                ;
                break;
        }
    }
    public function viewdiplomainfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_model = $student_model->fetchQualifiactionInfo(
        $params['qualification_id']);
        $qualification_data = self::fetchMatricData($params['qualification_id']);
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($qualification_data)) {
                    $this->view->assign('matric', $qualification_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($qualification_data, 
                false) . ')';
                break;
            case 'json':
                $this->_helper->json($qualification_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($qualification_data);
                break;
            default:
                ;
                break;
        }
    }
    public function viewbtechinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $qualification_model = $student_model->fetchQualifiactionInfo(
        $params['qualification_id']);
        $qualification_data = self::fetchMatricData($params['qualification_id']);
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($qualification_data)) {
                    $this->view->assign('matric', $qualification_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' .
                 $this->_helper->json($qualification_data, false) . ')';
                break;
            case 'json':
                $this->_helper->json($qualification_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($qualification_data);
                break;
            default:
                ;
                break;
        }
    }
    public function viewleetinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $exam_id = $params['exam_id'];
        $exam_data = self::fetchaieeData($params['exam_id']);
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($exam_data)) {
                    $this->view->assign('matric', $exam_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($exam_data, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($exam_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($exam_data);
                break;
            default:
                ;
                break;
        }
    }
    public function viewaieeeinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $exam_data = self::fetchaieeData($params['exam_id']);
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($exam_data)) {
                    $this->view->assign('matric', $exam_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($exam_data, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($exam_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($exam_data);
                break;
            default:
                ;
                break;
        }
    }
    public function viewgateinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $exam_id = $params['exam_id'];
        $exam_data = array();
        $exam_data = self::fetchaieeData($params['exam_id']);
        $exam_model = $student_model->fetchCompetitveExamInfo($exam_id);
        if ($exam_model instanceof Acad_Model_Exam_Competitive) {
            $exam_data['name'] = $exam_model->getName();
            $exam_data['total_score'] = $exam_model->getTotal_score();
            $exam_data['abbr'] = $exam_model->getAbbr();
            $exam_data['air'] = $exam_model->getAll_india_rank();
            $exam_data['roll_no'] = $exam_model->getRoll_no();
            $exam_data['total_score'] = $exam_model->getTotal_score();
        }
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($exam_data)) {
                    $this->view->assign('matric', $exam_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($exam_data, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($exam_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($exam_data);
                break;
            default:
                ;
                break;
        }
    }
    public function savematricinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $qualification_name = $request['qualification_name'];
        $qualification_model = new Acad_Model_Qualification();
        $qualifications = $qualification_model->fetchQualifications();
        $qualification_id = array_search($qualification_name, $qualifications);
        $save_data = $request['qualification_data'];
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $student_model->saveQualificationInfo($qualification_id, $save_data);
        $success = true;
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($success)) {
                    $this->view->assign('is_successfull', $success);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($success, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($success);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($success);
                break;
            default:
                ;
                break;
        }
    }
    public function savetwelfthinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $qualification_name = $request['qualification_name'];
        $qualification_model = new Acad_Model_Qualification();
        $qualifications = $qualification_model->fetchQualifications();
        $qualification_id = array_search($qualification_name, $qualifications);
        $save_data = $request['qualification_data'];
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $student_model->saveQualificationInfo($qualification_id, $save_data);
        $success = true;
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($success)) {
                    $this->view->assign('is_successfull', $success);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($success, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($success);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($success);
                break;
            default:
                ;
                break;
        }
    }
    public function savediplomainfoAction ()
    {
        {
            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->layout()->disableLayout();
            $request = $this->getRequest();
            $params = array_diff($request->getParams(), 
            $request->getUserParams());
            $format = $this->_getParam('format', 'html');
            $qualification_name = $request['qualification_name'];
            $qualification_model = new Acad_Model_Qualification();
            $qualifications = $qualification_model->fetchQualifications();
            $qualification_id = array_search($qualification_name, 
            $qualifications);
            $save_data = $request['qualification_data'];
            $student_model = new Acad_Model_Member_Student();
            $student_model->setMember_id($this->getMember_id());
            $student_model->saveQualificationInfo($qualification_id, $save_data);
            $success = true;
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    if (! empty($success)) {
                        $this->view->assign('is_successfull', $success);
                    }
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' . $this->_helper->json($success, false) .
                     ')';
                    break;
                case 'json':
                    $this->_helper->json($success);
                    break;
                case 'test':
                    Zend_Registry::get('logger')->debug($success);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function savebtechinfoAction ()
    {
        {
            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->layout()->disableLayout();
            $request = $this->getRequest();
            $params = array_diff($request->getParams(), 
            $request->getUserParams());
            $format = $this->_getParam('format', 'html');
            $qualification_name = $request['qualification_name'];
            $qualification_model = new Acad_Model_Qualification();
            $qualifications = $qualification_model->fetchQualifications();
            $qualification_id = array_search($qualification_name, 
            $qualifications);
            $save_data = $request['qualification_data'];
            $student_model = new Acad_Model_Member_Student();
            $student_model->setMember_id($this->getMember_id());
            $student_model->saveQualificationInfo($qualification_id, $save_data);
            $success = true;
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    if (! empty($success)) {
                        $this->view->assign('is_successfull', $success);
                    }
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' . $this->_helper->json($success, false) .
                     ')';
                    break;
                case 'json':
                    $this->_helper->json($success);
                    break;
                case 'test':
                    Zend_Registry::get('logger')->debug($success);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function saveleetinfoAction ()
    {
        {
            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->layout()->disableLayout();
            $request = $this->getRequest();
            $params = array_diff($request->getParams(), 
            $request->getUserParams());
            $format = $this->_getParam('format', 'html');
            $qualification_name = $request['qualification_name'];
            $qualification_model = new Acad_Model_Qualification();
            $qualifications = $qualification_model->fetchQualifications();
            $qualification_id = array_search($qualification_name, 
            $qualifications);
            $save_data = $request['qualification_data'];
            $student_model = new Acad_Model_Member_Student();
            $student_model->setMember_id($this->getMember_id());
            $student_model->saveQualificationInfo($qualification_id, $save_data);
            $success = true;
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    if (! empty($success)) {
                        $this->view->assign('is_successfull', $success);
                    }
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' . $this->_helper->json($success, false) .
                     ')';
                    break;
                case 'json':
                    $this->_helper->json($success);
                    break;
                case 'test':
                    Zend_Registry::get('logger')->debug($success);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function saveaieeeinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $exam_id = $params['exam_id'];
        $save_data = $params['competitive_data'];
        $exam_model = $student_model->saveCompetitiveExamInfo($save_data);
        $success = true;
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($success)) {
                    $this->view->assign('is_successfull', $success);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($success, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($success);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($success);
                break;
            default:
                ;
                break;
        }
    }
    public function savegateinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $exam_id = $params['exam_id'];
        $save_data = $params['competitive_data'];
        $exam_model = $student_model->saveCompetitiveExamInfo($save_data);
        $success = true;
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($success)) {
                    $this->view->assign('is_successfull', $success);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($success, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($success);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($success);
                break;
            default:
                ;
                break;
        }
    }
    public function createprofileAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function editmatricinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $qualification_id = $params['qualification_id'];
        if ($qualification_id) {
            $student_model = new Acad_Model_Member_Student();
            $qualification_data = self::fetchMatricData($qualification_id);
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    if (! empty($qualification_data)) {
                        $this->view->assign('qualification_data', 
                        $qualification_data);
                    }
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' .
                     $this->_helper->json($qualification_data, false) . ')';
                    break;
                case 'json':
                    $this->_helper->json($qualification_data);
                    break;
                case 'test':
                    Zend_Registry::get('logger')->debug($qualification_data);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function edittwelfthinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $qualification_id = $params['qualification_id'];
        if ($qualification_id) {
            $student_model = new Acad_Model_Member_Student();
            $qualification_data = self::fetchTwelfthData($qualification_id);
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    if (! empty($qualification_data)) {
                        $this->view->assign('qualification_data', 
                        $qualification_data);
                    }
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' .
                     $this->_helper->json($qualification_data, false) . ')';
                    break;
                case 'json':
                    $this->_helper->json($qualification_data);
                    break;
                case 'test':
                    Zend_Registry::get('logger')->debug($qualification_data);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function editbtechinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $qualification_id = $params['qualification_id'];
        if ($qualification_id) {
            $student_model = new Acad_Model_Member_Student();
            $qualification_data = self::fetchBtechData($qualification_id);
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    if (! empty($qualification_data)) {
                        $this->view->assign('qualification_data', 
                        $qualification_data);
                    }
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' .
                     $this->_helper->json($qualification_data, false) . ')';
                    break;
                case 'json':
                    $this->_helper->json($qualification_data);
                    break;
                case 'test':
                    Zend_Registry::get('logger')->debug($qualification_data);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function editdiplomainfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $qualification_id = $params['qualification_id'];
        if ($qualification_id) {
            $student_model = new Acad_Model_Member_Student();
            $qualification_data = self::fetchDiplomaData($qualification_id);
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    if (! empty($qualification_data)) {
                        $this->view->assign('qualification_data', 
                        $qualification_data);
                    }
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' .
                     $this->_helper->json($qualification_data, false) . ')';
                    break;
                case 'json':
                    $this->_helper->json($qualification_data);
                    break;
                case 'test':
                    Zend_Registry::get('logger')->debug($qualification_data);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function editaieeeinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $exam_id = $params['exam_id'];
        if ($exam_id) {
            $student_model = new Acad_Model_Member_Student();
            $qualification_data = self::fetchaieeeData($exam_id);
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    if (! empty($qualification_data)) {
                        $this->view->assign('qualification_data', 
                        $qualification_data);
                    }
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' .
                     $this->_helper->json($qualification_data, false) . ')';
                    break;
                case 'json':
                    $this->_helper->json($qualification_data);
                    break;
                case 'test':
                    Zend_Registry::get('logger')->debug($qualification_data);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function editleetinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $exam_id = $params['exam_id'];
        if ($exam_id) {
            $student_model = new Acad_Model_Member_Student();
            $qualification_data = self::fetchleetData($exam_id);
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    if (! empty($qualification_data)) {
                        $this->view->assign('qualification_data', 
                        $qualification_data);
                    }
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' .
                     $this->_helper->json($qualification_data, false) . ')';
                    break;
                case 'json':
                    $this->_helper->json($qualification_data);
                    break;
                case 'test':
                    Zend_Registry::get('logger')->debug($qualification_data);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function editgateinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $exam_id = $params['exam_id'];
        if ($exam_id) {
            $student_model = new Acad_Model_Member_Student();
            $qualification_data = self::fetchgateData($exam_id);
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    if (! empty($qualification_data)) {
                        $this->view->assign('qualification_data', 
                        $qualification_data);
                    }
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' .
                     $this->_helper->json($qualification_data, false) . ')';
                    break;
                case 'json':
                    $this->_helper->json($qualification_data);
                    break;
                case 'test':
                    Zend_Registry::get('logger')->debug($qualification_data);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    /**
     * 
     * only to render view of 
     */
    public function createdmcAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function fetchclassdmcAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $class_id = $params['class_id'];
        $dmc_view_type = $params['dmc_view_type'];
        $dmc_info_id = $params['dmc_info_id'];
        $class_object = new Acad_Model_Class();
        $class_object->setClass_id($class_id);
        $subject_ids = $class_object->fetchSubjects();
        $subject_data = array();
        $dmc_data = array();
        $dmc_info_data = array();
        switch ($dmc_view_type) {
            case 'latest':
                $class_id = $params['class_id'];
                $subject_data = $this->fetchClassSubjects($class_id);
                $dmc_info_data = self::fetchDmcInfo(null, null, null, null, 
                null, true);
                $dmc_info_id = $dmc_info_data[0][0];
                $dmc_data = self::fetchDmcMarks($dmc_info_id, $subject_ids);
                break;
            case 'single':
                $class_id = $params['class_id'];
                $dmc_info_data = self::fetchDmcInfo(null, null, null, null, 
                null, true);
                $dmc_data = self::fetchDmcMarks($dmc_info_id, $subject_ids);
                break;
        }
        $response = array('subject_data' => $subject_data, 
        'dmc_data' => $dmc_data, 'dmc_info_data' => $dmc_info_data);
        switch ($response) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($response)) {
                    $this->view->assign('qualification_data', $response);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($response, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($response);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($response);
                break;
            default:
                ;
                break;
        }
    }
    public function savedmcAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $dmc_info = $params['dmc_info'];
        $dmc_data_array = $params['dmc_data'];
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $student_model->saveDmcInfo($dmc_info);
        foreach ($dmc_data_array as $dmc_data) {
            $student_model->saveDmcMarks($dmc_data);
        }
    }
    public function fetchsubjectdmcAction ($subject_id, $dmc_info_id)
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'html');
        $class_id = $params['subject_id'];
        $dmc_info_id = $params['dmc_info_id'];
        $student_model = new Acad_Model_Member_Student();
        $student_model->setMember_id($this->getMember_id());
        $dmc_data = self::fetchsubjectDmc($dmc_info_id, $subject_id);
        switch ($dmc_data) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                if (! empty($dmc_data)) {
                    $this->view->assign('qualification_data', $dmc_data);
                }
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($dmc_data, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($dmc_data);
                break;
            case 'test':
                Zend_Registry::get('logger')->debug($dmc_data);
                break;
            default:
                ;
                break;
        }
    }
}
