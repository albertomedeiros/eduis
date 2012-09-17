<?php
class StudentController extends Zend_Controller_Action
{
    /**
     * 
     * @var int
     */
    protected $_member_id;
    protected $_user_name;
    protected $_user_type;
    protected $_department_id;
    /**
     * @return the $_member_id
     */
    protected function getMember_id ()
    {
        return $this->_member_id;
    }
    /**
     * @return the $_user_name
     */
    protected function getUser_name ()
    {
        return $this->_user_name;
    }
    /**
     * @return the $_user_type
     */
    protected function getUser_type ()
    {
        return $this->_user_type;
    }
    /**
     * @return the $_department_id
     */
    protected function getDepartment_id ()
    {
        return $this->_department_id;
    }
    /**
     * @param int $_member_id
     */
    protected function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_user_name
     */
    protected function setUser_name ($_user_name)
    {
        $this->_user_name = $_user_name;
    }
    /**
     * @param field_type $_user_type
     */
    protected function setUser_type ($_user_type)
    {
        $this->_user_type = $_user_type;
    }
    /**
     * @param field_type $_department_id
     */
    protected function setDepartment_id ($_department_id)
    {
        $this->_department_id = $_department_id;
    }
    public function indexAction ()
    {}
    public function init ()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $authInfo = Zend_Auth::getInstance()->getStorage()->read();
            $this->setDepartment_id($authInfo['department_id']);
            $this->setUser_name($authInfo['identity']);
            $this->setUser_type($authInfo['userType']);
            $this->setMember_id($authInfo['member_id']);
        }
    }
    public function sendemailAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $email_ids = $params['myarray']['email_ids'];
        $subject = $params['myarray']['subject'];
        $message = $params['myarray']['message'];
        foreach ($email_ids as $email_id) {
            $this->sendEmail($email_id, $subject, $message);
        }
    }
    public function exportexcelAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $core_data = $params['myarray']['core_data'];
        $academic_data = $params['myarray']['academic_data'];
        $final_data = array();
        foreach ($core_data as $member_id_core => $info) {
            if (! empty($academic_data[$member_id_core])) {
                $member_data = array_merge($core_data[$member_id_core], 
                $academic_data[$member_id_core]);
                $final_data[$member_id_core] = $member_data;
            }
        }
        $headings = array_pop($final_data);
        $headers = array_keys($headings);
        foreach ($headers as $key => $header) {
            $headers[$key] = strtoupper($header);
        }
        $this->export_to_excel($headers, $final_data);
        /*set_time_limit(0);
        define('TEMP_CORE', realpath(dirname(__FILE__) . '/../temp'));
        $filename = TEMP_CORE . "/Student_Data-" . date("m-d-Y") . ".xls";
        $realPath = realpath($filename);
        if (false === $realPath) {
            touch($filename);
            chmod($filename, 0777);
        }
        $filename = realpath($filename);
        $handle = fopen($filename, "w");
        $finalData = array();
        foreach ($data as $key => $row) {
            foreach ($row as $col => $value) {
                $finalData[$key][utf8_decode($col)] = utf8_decode($value);
            }
        }
        $headings = array();
        $copy = array();
        $copy = $finalData;
        $headings = array_pop($copy);
        $headers = array();
        $headers['headers'] = array_keys($headings);
        foreach ($headers['headers'] as $key => $header) {
            $headers['headers'][$key] = strtoupper($header);
        }
        Zend_Registry::get('logger')->debug($headers);
        Zend_Registry::get('logger')->debug($finalData);
        foreach ($headers as $header) {
            fputcsv($handle, $header, "\t");
        }
        foreach ($finalData as $finalRow) {
            fputcsv($handle, $finalRow, "\t");
        }
        fclose($handle);
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->getResponse()
            ->setRawHeader(
        "Content-Type: application/vnd.ms-excel; charset=UTF-8")
            ->setRawHeader(
        "Content-Disposition: attachment; filename=Student_Data.xls")
            ->setRawHeader("Content-Transfer-Encoding: binary")
            ->setRawHeader("Expires: 0")
            ->setRawHeader(
        "Cache-Control: must-revalidate, post-check=0, pre-check=0")
            ->setRawHeader("Pragma: public")
            ->setRawHeader("Content-Length: " . filesize($filename))
            ->sendResponse();
        readfile($filename);
        exit();*/
    }
    public function collectexportabledataAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_ids = $params['myarray']['member_ids'];
        $data = $this->prepareDataForExport($member_ids);
        $format = $this->_getParam('format', 'log');
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                $this->view->assign('data', $data);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($data, false) . ')';
                break;
            case 'json':
                $this->_helper->json($data);
                break;
            case 'log':
                Zend_Registry::get('logger')->debug($data);
                break;
            default:
                ;
                break;
        }
    }
    public function fetchemailidsAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        Zend_Registry::get('logger')->debug(
        'Params required : array(\'member_ids\'=>array())');
        if (! empty($params['member_ids'])) {
            $member_ids = $params['member_ids'];
            Zend_Registry::get('logger')->debug($params);
            //for testing set
            //$member_ids = $member_ids = array(1, 2, 3, 4, 5);
            $member_email_ids = array();
            foreach ($member_ids as $member_id) {
                $email_id = $this->findEmailId($member_id);
                $member_email_ids[$member_id] = $email_id;
            }
            if (empty($member_email_ids)) {
                $member_email_ids = false;
            }
            $format = $this->_getParam('format', 'html');
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    $this->view->assign('member_email_ids', $member_email_ids);
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' .
                     $this->_helper->json($member_email_ids, false) . ')';
                    break;
                case 'json':
                    $this->_helper->json($member_email_ids);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function memberidcheckAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        Zend_Registry::get('logger')->debug(
        'member_id may be sent in as parameter');
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        $member_id_exists = $this->memberIdCheck($member_id);
        $this->_helper->json($member_id_exists);
    }
    /**
     * All links are here
     */
    public function createprofileAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function fetchclassinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        Zend_Registry::get('logger')->debug(
        'member_id may be sent in as parameter');
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        $class_info = $params['myarray']['class_info'];
        $class_id = $class_info['class_id'];
        $stu_class_info = $this->findStuClassInfo($member_id, $class_id);
        Zend_Registry::get('logger')->debug($stu_class_info);
        $this->_helper->json($stu_class_info);
    }
    public function viewclassinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        Zend_Registry::get('logger')->debug(
        'member_id may be sent in as parameter');
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        $this->view->assign('department_id', $this->getDepartment_id());
        $class_ids = $this->getAllClassIds($member_id);
        if ($class_ids == false) {
            $this->view->assign('student_class_info', false);
        } else {
            $student = new Core_Model_Member_Student();
            $student->setMember_id($member_id);
            $raw_class_info = array();
            foreach ($class_ids as $class_id) {
                $info = $this->findStuClassInfo($member_id, $class_id);
                $class_info = $this->findClassInfo($class_id);
                $batch_id = $class_info['class_info']['batch_id'];
                $raw_class_info[$batch_id] = $info['roll_no'];
            }
            $stu_class_info = array();
            foreach ($raw_class_info as $batch_id => $roll_num) {
                $batch_info = $this->findBatchInfo($batch_id);
                $batch_start = $batch_info['batch_info']['batch_start'];
                $stu_class_info[$batch_start] = $roll_num;
            }
            Zend_Registry::get('logger')->debug(
            'Name of varibale assigned to view is : student_class_info');
            Zend_Registry::get('logger')->debug($stu_class_info);
            $this->view->assign('student_class_info', $stu_class_info);
        }
    }
    public function editclassinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $department_id = $this->getDepartment_id();
        $this->view->assign('department_id', $department_id);
    }
    public function saveclassinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        Zend_Registry::get('logger')->debug(
        'member_id may be sent in as parameter');
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        $my_array = $params['myarray'];
        $student_class_info = $my_array['class_info'];
        return $this->saveClassInfo($member_id, $student_class_info);
    }
    public function fetchunvregistrationinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        Zend_Registry::get('logger')->debug(
        'member_id may be sent in as parameter');
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        $member_id_exists = $this->memberIdCheck($member_id);
        if ($member_id_exists) {
            $registration_info['registration_id'] = $this->findRegistrationInfo(
            $member_id);
            $this->_helper->json($registration_info);
        } else {
            $registration_info = false;
        }
        $this->_helper->json($registration_info);
    }
    public function viewunvregistrationinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function editunvregistrationinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function saveunvregistrationinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        Zend_Registry::get('logger')->debug(
        'member_id may be sent in as parameter');
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        $my_array = $params['myarray'];
        $reg_info = $my_array['registration_info'];
        return $this->saveRegistrationInfo($member_id, $reg_info);
    }
    /**
     * before calling this function use memberidcheck function
     * Enter description here ...
     * @param int $member_id
     */
    public function fetchpersonalinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        Zend_Registry::get('logger')->debug(
        'member_id may be sent in as parameter');
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        $personal_info = $this->findCriticalInfo($member_id);
        Zend_Registry::get('logger')->debug($personal_info);
        $this->_helper->json($personal_info);
    }
    public function viewpersonalinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function editpersonalinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function savepersonalinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        Zend_Registry::get('logger')->debug(
        'member_id may be sent in as parameter');
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        $my_array = $params['myarray'];
        $critical_info = $my_array['personal_info'];
        Zend_Registry::get('logger')->debug($params);
        return $this->saveCriticalData($member_id, $critical_info);
    }
    public function fetchaddressinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        Zend_Registry::get('logger')->debug(
        'member_id may be sent in as parameter');
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        $address_info = $this->findAddressInfo($member_id);
        $this->_helper->json($address_info);
    }
    public function viewaddressinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function editaddressinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function saveaddressinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        Zend_Registry::get('logger')->debug(
        'member_id may be sent in as parameter');
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        $my_array = $params['myarray'];
        $all_address_info = $my_array['address_info'];
        foreach ($all_address_info as $address_type => $address_info) {
            $address_info['address_type'] = $address_type;
            $this->saveAddressData($member_id, $address_info);
        }
    }
    public function fetchcontactinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        Zend_Registry::get('logger')->debug(
        'member_id may be sent in as parameter');
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        $contact_info = $this->findContactsInfo($member_id);
        $this->_helper->json($contact_info);
    }
    public function viewcontactinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function editcontactinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function savecontactinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        Zend_Registry::get('logger')->debug(
        'member_id may be sent in as parameter');
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        $my_array = $params['myarray'];
        $all_contact_info = $my_array['contact_info'];
        foreach ($all_contact_info as $contact_type => $contact_info) {
            $contact_info['contact_type_id'] = $contact_type;
            $this->saveContactsInfo($member_id, $contact_info);
        }
    }
    public function fetchrelativesinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        Zend_Registry::get('logger')->debug(
        'member_id may be sent in as parameter');
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        $relative_info = $this->findRelativesInfo($member_id);
        $this->_helper->json($relative_info);
    }
    public function viewrelativesinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function editrelativesinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function saverelativesinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        Zend_Registry::get('logger')->debug(
        'member_id may be sent in as parameter');
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        $my_array = $params['myarray'];
        $all_relatives_info = $my_array['relatives_info'];
        foreach ($all_relatives_info as $relatives_type => $relatives_info) {
            $relatives_info['relation_id'] = $relatives_type;
            $this->saveRelativeInfo($member_id, $relatives_info);
        }
    }
    /**
     * Checks if member is registered in the core,
     * @return true if member_id is registered, false otherwise
     */
    private function memberIdCheck ($member_id_to_check)
    {
        $student = new Core_Model_Member_Student();
        $student->setMember_id($member_id_to_check);
        $member_id_exists = $student->memberIdCheck();
        if (! $member_id_exists) {
            Zend_Registry::get('logger')->debug(
            'Member with member_id : ' . $member_id_to_check .
             ' is not registered in CORE');
        }
        return $member_id_exists;
    }
    /**
     * @todo view changes no class finder
     * Enter description here ...
     * @param unknown_type $data_to_save
     */
    private function saveClassInfo ($member_id, $class_info)
    {
        $class_info['member_id'] = $member_id;
        $student = new Core_Model_Member_Student();
        $student->setMember_id($member_id);
        return $student->saveClassInfo($class_info);
    }
    private function saveCriticalData ($member_id, $data_to_save)
    {
        /**
         * 
         * static for student
         * @var int
         */
        $data_to_save['member_type_id'] = 1;
        $student_model = new Core_Model_Member_Student();
        $student_model->setMember_id($member_id);
        return $student_model->saveCriticalInfo($data_to_save);
    }
    private function saveRelativeInfo ($member_id, $relative_info)
    {
        $student_model = new Core_Model_Member_Student();
        $relative_info['member_id'] = $member_id;
        $student_model->setMember_id($member_id);
        return $student_model->saveRelativesInfo($relative_info);
    }
    private function saveAddressData ($member_id, $address_info)
    {
        $student_model = new Core_Model_Member_Student();
        $student_model->setMember_id($member_id);
        return $student_model->saveAddressInfo($address_info);
    }
    private function saveContactsInfo ($member_id, $contact_info)
    {
        $student_model = new Core_Model_Member_Student();
        $student_model->setMember_id($member_id);
        return $student_model->saveContactsInfo($contact_info);
    }
    private function saveAdmissionData ($member_id, $data_to_save)
    {
        /**
         * 
         * static for student
         * @var int
         */
        $department_id = $data_to_save['department_id'];
        $student_model = new Core_Model_Member_Student();
        $admission = array('member_id' => $member_id, 
        'alloted_branch' => $department_id);
        $student_model->setMember_id($member_id);
        return $student_model->saveAdmissionInfo($admission);
    }
    private function saveRegistrationInfo ($member_id, $data_to_save)
    {
        /**
         * 
         * static for student
         * @var int
         */
        $student_model = new Core_Model_Member_Student();
        $registration_id = $data_to_save['registration_id'];
        $registration_array = array('member_id' => $member_id, 
        'registration_id' => $registration_id);
        $student_model->setMember_id($member_id);
        return $student_model->saveRegistrationInfo($registration_array);
    }
    /**
     * fetches students information for an acdemic class
     * Enter description here ...
     * @param int $class_id
     */
    private function findStuClassInfo ($member_id, $class_id)
    {
        $member_id_exists = $this->memberIdCheck($member_id);
        if ($member_id_exists) {
            $student = new Core_Model_Member_Student();
            $student->setMember_id($member_id);
            $info = $student->fetchClassInfo($class_id);
            if ($info instanceof Core_Model_StudentClass) {
                $stu_class_info = array();
                $stu_class_info['roll_no'] = $info->getRoll_no();
                $stu_class_info['group_id'] = $info->getGroup_id();
                $stu_class_info['start_date'] = $info->getStart_date();
                $stu_class_info['completion_date'] = $info->getCompletion_date();
                foreach ($stu_class_info as $key => $value) {
                    if ($value == null) {
                        unset($stu_class_info[$key]);
                    }
                }
            } else {
                $stu_class_info = false;
                /*$message = 'No member_class info for class_id ' . $class_id;
                $code = Zend_Log::ERR;
                throw new Exception($message, $code);*/
            }
            return $stu_class_info;
        }
    }
    private function findCriticalInfo ($member_id)
    {
        $member_id_exists = $this->memberIdCheck($member_id);
        if ($member_id_exists) {
            $student = new Core_Model_Member_Student();
            $student->setMember_id($member_id);
            $info = $student->fetchCriticalInfo();
            if ($info instanceof Core_Model_Member_Student) {
                $critical_data['first_name'] = $info->getFirst_name();
                $critical_data['middle_name'] = $info->getMiddle_name();
                $critical_data['last_name'] = $info->getLast_name();
                $critical_data['cast_id'] = $info->getCast_id();
                $critical_data['nationality_id'] = $info->getNationality_id();
                $critical_data['religion_id'] = $info->getReligion_id();
                $critical_data['blood_group'] = $info->getBlood_group();
                $critical_data['dob'] = $info->getDob();
                $critical_data['gender'] = $info->getGender();
                foreach ($critical_data as $key => $value) {
                    if ($value == null) {
                        $critical_data[$key] = null;
                    }
                }
            } else {
                $critical_data = false;
                /*$message = 'Personal info for member id : ' . $member_id .
                 ' not present.';
                $code = Zend_Log::ERR;
                throw new Exception($message, $code);*/
            }
            return $critical_data;
        }
    }
    private function findAddressInfo ($member_id)
    {
        $member_id_exists = $this->memberIdCheck($member_id);
        if ($member_id_exists) {
            $address = new Core_Model_Mapper_MemberAddress();
            $address_types = $address->fetchAddressTypes($member_id);
            $student = new Core_Model_Member_Student();
            $student->setMember_id($member_id);
            if (is_array($address_types)) {
                $address_info = array();
                foreach ($address_types as $address_type) {
                    $info = $student->fetchAddressInfo($address_type);
                    if ($info instanceof Core_Model_MemberAddress) {
                        $address_info[$address_type]['postal_code'] = $info->getPostal_code();
                        $address_info[$address_type]['city'] = $info->getCity();
                        $address_info[$address_type]['district'] = $info->getDistrict();
                        $address_info[$address_type]['state'] = $info->getState();
                        $address_info[$address_type]['address'] = $info->getAddress();
                        foreach ($address_info as $key => $value) {
                            if ($value == null) {
                                unset($address_info[$key]);
                            }
                        }
                    }
                }
            } else {
                $address_info = false;
            }
            return $address_info;
        }
    }
    private function findContactsInfo ($member_id)
    {
        $member_id_exists = $this->memberIdCheck($member_id);
        if ($member_id_exists) {
            $contact = new Core_Model_MemberContacts();
            $contact_type_ids = $contact->fetchAllContactTypes();
            $student = new Core_Model_Member_Student();
            $student->setMember_id($member_id);
            $contact_info = array();
            foreach ($contact_type_ids as $contact_type_id => $contact_type_name) {
                $contact_info[$contact_type_id] = array(
                'contact_details' => null);
                $info = $student->fetchContactInfo($contact_type_id);
                if ($info instanceof Core_Model_MemberContacts) {
                    $contact_info[$contact_type_id]['contact_details'] = $info->getContact_details();
                }
            }
            return $contact_info;
        }
    }
    private function findRelativesInfo ($member_id)
    {
        $member_id_exists = $this->memberIdCheck($member_id);
        if ($member_id_exists) {
            $relative = new Core_Model_Mapper_MemberRelatives();
            $relation_ids = $relative->fetchRelationIds($member_id);
            if (is_array($relation_ids)) {
                $relatives_info = array();
                foreach ($relation_ids as $relation_id) {
                    $info = $this->findRelativeInfo($member_id, $relation_id);
                    $relatives_info[$relation_id]['occupation'] = $info['occupation'];
                    $relatives_info[$relation_id]['designation'] = $info['designation'];
                    $relatives_info[$relation_id]['office_add'] = $info['office_add'];
                    $relatives_info[$relation_id]['name'] = $info['name'];
                    $relatives_info[$relation_id]['contact'] = $info['contact'];
                    $relatives_info[$relation_id]['annual_income'] = $info['annual_income'];
                    $relatives_info[$relation_id]['landline_no'] = $info['landline_no'];
                    $relatives_info[$relation_id]['email'] = $info['email'];
                    foreach ($relatives_info as $key => $array) {
                        foreach ($array as $k => $value) {
                            if ($value == null) {
                                unset($relatives_info[$key][$k]);
                            }
                        }
                    }
                }
            } else {
                $relatives_info = false;
            }
            return $relatives_info;
        }
    }
    private function findRelativeInfo ($member_id, $relation_id)
    {
        $member_id_exists = $this->memberIdCheck($member_id);
        if ($member_id_exists) {
            $relatives_info = array();
            $student = new Core_Model_Member_Student();
            $student->setMember_id($member_id);
            $info = $student->fetchRelativeInfo($relation_id);
            if ($info instanceof Core_Model_MemberRelatives) {
                $relatives_info['occupation'] = $info->getOccupation();
                $relatives_info['designation'] = $info->getDesignation();
                $relatives_info['office_add'] = $info->getOffice_add();
                $relatives_info['name'] = $info->getName();
                $relatives_info['contact'] = $info->getContact();
                $relatives_info['annual_income'] = $info->getAnnual_income();
                $relatives_info['landline_no'] = $info->getLandline_no();
                $relatives_info['email'] = $info->getEmail();
            }
            return $relatives_info;
        }
        return false;
    }
    private function getActiveClassIds ($member_id)
    {
        $student = new Core_Model_Member_Student();
        $student->setMember_id($member_id);
        $class_ids = $student->fetchActiveClassIds();
        //if (is_array($class_ids)) {
        return $class_ids;
        /*        } else {
            if ($class_ids == false) {
                throw new Exception(
                'Student with member_id : ' . $member_id .
                 ' has not been registered in any Acdemic Class ', 
                Zend_Log::WARN);
            }
        }*/
    }
    private function getAllClassIds ($member_id)
    {
        $student = new Core_Model_Member_Student();
        $student->setMember_id($member_id);
        $class_ids = $student->fetchAllClassIds();
        //if (is_array($class_ids)) {
        return $class_ids;
        /*  } else {
            if ($class_ids == false) {
                throw new Exception(
                'Student with member_id : ' . $member_id .
                 ' has not been registered in any Acdemic Class ', 
                Zend_Log::WARN);
            }
        }*/
    }
    private function findClassInfo ($class_id)
    {
        $httpClient = new Zend_Http_Client();
        $httpClient->setUri('http://' . CORE_SERVER . '/class/getclassinfo');
        $httpClient->setMethod('POST');
        $httpClient->setParameterPost(
        array('class_id' => $class_id, 'format' => 'json'));
        $response = $httpClient->request();
        if ($response->isError()) {
            $class_info = false;
            /*$error = 'ERROR: (' . $response->getStatus() . ') ' .
             $response->getHeader('Message');
            throw new Zend_Exception($error, Zend_Log::ERR);*/
        } else {
            $jsonContent = $response->getBody($response);
            $class_info = Zend_Json::decode($jsonContent);
            return $class_info;
        }
    }
    private function findBatchInfo ($batch_id)
    {
        $httpClient = new Zend_Http_Client();
        $httpClient->setUri('http://' . CORE_SERVER . '/batch/getbatchinfo');
        $httpClient->setMethod('POST');
        $httpClient->setParameterPost(
        array('batch_id' => $batch_id, 'format' => 'json'));
        $response = $httpClient->request();
        if ($response->isError()) {
            $batch_info = false;
            /*$error = 'ERROR: (' . $response->getStatus() . ') ' .
             $response->getHeader('Message');
            throw new Zend_Exception($error, Zend_Log::ERR);*/
        } else {
            $jsonContent = $response->getBody($response);
            $batch_info = Zend_Json::decode($jsonContent);
            return $batch_info;
        }
    }
    private function findAllContactTypes ()
    {
        $contacts = new Core_Model_MemberContacts();
        return $contacts->fetchAllContactTypes();
    }
    private function findEmailId ($member_id)
    {
        $contacty_types = $this->findAllContactTypes();
        if (empty($contacty_types)) {
            return false;
        } else {
            $contact_type_id = array_search('EMAIL', $contacty_types);
            if (is_int($contact_type_id)) {
                $student = new Core_Model_Member_Student();
                $student->setMember_id($member_id);
                $info = $student->fetchContactInfo($contact_type_id);
                if ($info instanceof Core_Model_MemberContacts) {
                    return $info->getContact_details();
                }
            } else {
                return false;
            }
        }
    }
    private function sendEmail ($email_id, $subject, $message)
    {
        $mail = new Zend_Mail();
        $mail->setBodyText($message);
        $mail->addTo($email_id);
        $mail->setSubject($subject);
        $mail->send();
    }
    private function findRelationId ($relation_name)
    {
        $relations = new Core_Model_Relations();
        $all_relations = $relations->fetchRelations();
        if (! empty($all_relations)) {
            $relation_id = array_search($relation_name, $all_relations);
            if (is_integer($relation_id))
                return $relation_id;
            else
                return false;
        } else
            return false;
    }
    private function findRegistrationInfo ($member_id)
    {
        $student = new Core_Model_Member_Student();
        $student->setMember_id($member_id);
        $info = $student->fetchRegistrationInfo();
        $registration_info = array();
        if ($info instanceof Core_Model_StudentRegistration) {
            return $info->getRegistration_id();
        }
    }
    private function prepareDataForExport ($member_ids)
    {
        $info_to_export = array();
        if ((! empty($member_ids)) and (is_array($member_ids))) {
            foreach ($member_ids as $member_id) {
                /*
                 * Personal Info
                 */
                $class_ids = $this->getAllClassIds($member_id);
                //Zend_Registry::get('logger')->debug($class_ids);
                if (is_array($class_ids)) {
                    $class_info = $this->findStuClassInfo($member_id, 
                    array_pop($class_ids));
                    $info_to_export[$member_id]['roll_number'] = $class_info['roll_no'];
                } else {
                    $info_to_export[$member_id]['roll_number'] = false;
                }
                $info_to_export[$member_id]['registration_id'] = $this->findRegistrationInfo(
                $member_id);
                $critical_info = $this->findCriticalInfo($member_id);
                $info_to_export[$member_id]['first_name'] = $critical_info['first_name'];
                $info_to_export[$member_id]['last_name'] = $critical_info['last_name'];
                $info_to_export[$member_id]['middle_name'] = $critical_info['middle_name'];
                $info_to_export[$member_id]['dob'] = $critical_info['dob'];
                $info_to_export[$member_id]['gender'] = $critical_info['gender'];
                /*
                 * Fathers name
                 */
                $relative_id = $this->findRelationId('FATHER');
                $relative_info = $this->findRelativeInfo($member_id, 
                $relative_id);
                if (empty($relative_info['name'])) {
                    $info_to_export[$member_id]['father_name'] = null;
                } else {
                    $info_to_export[$member_id]['father_name'] = $relative_info['name'];
                }
                /*
                 * Address info
                 */
                $address_info = $this->findAddressInfo($member_id);
                $address_req = $address_info['MAILING'];
                $info_to_export[$member_id]['postal_code'] = $address_req['postal_code'];
                $info_to_export[$member_id]['city'] = $address_req['city'];
                $info_to_export[$member_id]['district'] = $address_req['district'];
                $info_to_export[$member_id]['state'] = $address_req['state'];
                $info_to_export[$member_id]['address'] = $address_req['address'];
                /*
                 * Contact Info
                 */
                $contact = new Core_Model_Mapper_MemberContacts();
                $all_contact_types = $contact->fetchAllContactTypes();
                $home_landline = array_search('HOME LANDLINE', 
                $all_contact_types);
                $contact_info = $this->findContactsInfo($member_id);
                //over write; no problem
                $info_to_export[$member_id]['home_landline'] = $contact_info[$home_landline]['contact_details'];
                $home_mobile = array_search('HOME MOBILE', $all_contact_types);
                $info_to_export[$member_id]['home_mobile'] = $contact_info[$home_mobile]['contact_details'];
                $email = array_search('EMAIL', $all_contact_types);
                $info_to_export[$member_id]['email'] = $contact_info[$email]['contact_details'];
            }
            return $info_to_export;
        }
    }
    private function export_to_excel ($headers, $data)
    {
        $data_to_export = array();
        foreach ($data as $key => $row) {
            foreach ($row as $col => $value) {
                $data_to_export[$key][utf8_decode($col)] = utf8_decode($value);
            }
        }
        $php_excel = new PHPExcel();
        $php_excel->getProperties()
            ->setCreator("AMRIT SINGH")
            ->setLastModifiedBy("AMRIT SINGH")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Contains crucial student data")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        $excel_sheet = $php_excel->getActiveSheet();
        $alphabets = range('A', 'P');
        $styleArray = array('font' => array('bold' => true, 'size' => 12), 
        'alignment' => array(
        'center' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), 
        'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)), 
        'fill' => array('type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR, 
        'rotation' => 90, 'startcolor' => array('argb' => 'FFA0A0A0'), 
        'endcolor' => array('argb' => 'FFFFFFFF')));
        $excel_sheet->getStyle("A1:P1")->applyFromArray($styleArray);
        $alphabets_index = 0;
        $row_number = 1;
        foreach ($headers as $header) {
            $cell_coordinate = $alphabets[$alphabets_index] . $row_number;
            $excel_sheet->setCellValue($cell_coordinate, 
            strtoupper(' ' . $header . ' '));
            $alphabets_index = ($alphabets_index + 1);
        }
        foreach ($alphabets as $alphabet) {
            $excel_sheet->getColumnDimension($alphabet)->setAutoSize(true);
        }
        $row_number = 2;
        foreach ($data_to_export as $student_data) {
            $index_to_get = 0;
            foreach ($student_data as $info) {
                if (empty($value)) {
                    $value = 'NA';
                }
                $coordinate = $alphabets[$index_to_get];
                $excel_sheet->setCellValue($coordinate . $row_number, 
                ' ' . $info . ' ');
                $index_to_get = ($index_to_get + 1);
            }
            $row_number += 1;
        }
        /* 
         * 
         * Does not work :-(
         * /
        /*$toCol = $excel_sheet->getColumnDimension(
        $excel_sheet->getHighestColumn())
            ->getColumnIndex();
        for ($td = 'A'; $td != $toCol; $td ++) {
            $calculatedWidth = $excel_sheet->getColumnDimension($td)->getWidth();
            $excel_sheet->getColumnDimension($td)->setWidth(
            (int) $calculatedWidth * 2);
        }
        $excel_sheet->calculateColumnWidths();*/
        $php_excel->setActiveSheetIndex(0);
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"Student Data.xls\"");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($php_excel, "Excel5");
        $objWriter->save("php://output");
        exit();
    }
}