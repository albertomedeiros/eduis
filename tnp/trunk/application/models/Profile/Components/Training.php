<?php
class Tnp_Model_Profile_Components_Training
{
    protected $_member_trainings_info = array();
    protected $_training_id;
    protected $_training_technology;
    protected $_technical_field_id;
    protected $_technical_field_name;
    protected $_technical_sector;
    protected $_training_institute;
    protected $_start_date;
    protected $_completion_date;
    protected $_training_semester;
    protected $_member_id;
    protected $_mapper;
    protected $_class_properties = array('training_id', 'training_technology', 
    'technical_field_id', 'technical_field_name', 'training_sector', 
    'training_institute', 'start_date', 'completion_date', 'training_semester', 
    'member_id');
    public function getClass_properties ()
    {
        return $this->_class_properties;
    }
    public function setClass_properties ($_class_properties)
    {
        $this->_class_properties = $_class_properties;
    }
    protected function getMember_trainings_info ()
    {
        $member_trainings_info = $this->_member_trainings_info;
        if (sizeof($member_trainings_info) == 0) {
            $member_trainings_info = $this->getMapper()->fetchMemberTrainingsInfo(
            $this);
            $this->setMember_trainings_info($member_trainings_info);
        }
        return $this->_member_trainings_info;
    }
    protected function setMember_trainings_info ($_member_trainings_info)
    {
        $this->_member_trainings_info = $_member_trainings_info;
    }
    public function getTraining_id ()
    {
        $training_id = $this->_training_id;
        if (! isset($training_id)) {
            $this->getMapper()->fetchTraining_id($this);
        }
        return $this->_training_id;
    }
    public function setTraining_id ($_training_id)
    {
        $this->_training_id = $_training_id;
    }
    public function getTraining_technology ()
    {
        return $this->_training_technology;
    }
    public function setTraining_technology ($_training_technology)
    {
        $this->_training_technology = $_training_technology;
    }
    public function getTechnical_field_id ()
    {
        $technical_field_id = $this->_technical_field_id;
        if (! isset($technical_field_id)) {
            $this->getMapper()->fetchTechnical_field_id($this);
        }
        return $this->_technical_field_id;
    }
    public function setTechnical_field_id ($_technical_field_id)
    {
        $this->_technical_field_id = $_technical_field_id;
    }
    public function getTechnical_field_name ()
    {
        return $this->_technical_field_name;
    }
    public function setTechnical_field_name ($_technical_field_name)
    {
        $this->_technical_field_name = $_technical_field_name;
    }
    public function getTechnical_sector ()
    {
        return $this->_technical_sector;
    }
    public function setTechnical_sector ($_technical_sector)
    {
        $this->_technical_sector = $_technical_sector;
    }
    public function getTraining_institute ()
    {
        return $this->_training_institute;
    }
    public function setTraining_institute ($_training_institute)
    {
        $this->_training_institute = $_training_institute;
    }
    public function getStart_date ()
    {
        return $this->_start_date;
    }
    public function setStart_date ($_start_date)
    {
        $this->_start_date = $_start_date;
    }
    public function getCompletion_date ()
    {
        return $this->_completion_date;
    }
    public function setCompletion_date ($_completion_date)
    {
        $this->_completion_date = $_completion_date;
    }
    public function getTraining_semester ()
    {
        return $this->_training_semester;
    }
    public function setTraining_semester ($_training_semester)
    {
        $this->_training_semester = $_training_semester;
    }
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * used to init an object
     * @param array $options
     */
    public function setOptions ($options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    /**
     * Set Mapper
     * @param Tnp_Model_Mapper_Profile_Components_Training $mapper
     * @return Tnp_Model_Profile_Components_Training
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_Profile_Components_Training
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_Profile_Components_Training());
        }
        return $this->_mapper;
    }
    public function __construct (array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    public function __set ($name, $value)
    {
        $method = 'set' . $name;
        if ('mapper' == $name || ! method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
        }
        $this->$method($value);
    }
    public function __get ($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || ! method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
        }
    }
    /**
     * @todo
     * Enter description here ...
     */
    public function save ()
    {
        $this->getMapper()->save($this);
    }
    /**
     * 
     * Enter description here ...
     * @throws Exception
     */
    public function initMemberTrainingInfo ()
    {
        $member_trainings_info = $this->getMember_trainings_info();
        $training_id = $this->getTraining_id();
        if (! isset($training_id)) {
            $error = 'No Training Id provided';
            throw new Exception($error);
        } else {
            if (! array_key_exists($training_id, $member_trainings_info)) {
                $error = 'Training Id : ' . $training_id . 'for user ' .
                 $this->getMember_id() . ' is invalid';
                throw new Exception($error);
            } else {
                $options = $member_trainings_info[$training_id];
                $this->setOptions($options);
            }
        }
    }
    public function getMemberTrainingIds ()
    {
        $member_trainings_info = $this->getMember_trainings_info();
        return array_keys($member_trainings_info);
    }
    public function initTrainingInfo ()
    {
        $options = $this->getMapper()->fetchTrainingInfo($this);
        $this->setOptions($options);
    }
    public function initTechnicalFieldInfo ()
    {
        $options = $this->getMapper()->fetchTechnicalFieldInfo($this);
        $this->setOptions($options);
    }
    /**
     * 
     * Enter description here ...
     * @param array $options containing properties mapped to values
     * @param array $property_range containing properties mapped to array containing upper and lower range
     * @throws Exception when trying to set equality and range both ,for property, at the same time
     * @throws Exception when invalid properties are specified 
     * @return array containing Member Ids
     */
    public function search (array $options = null, array $property_range = null)
    {
        $class_properties = array();
        $options_keys = array();
        $valid_options = array();
        $invalid_options = array();
        $setter_options = array();
        $property_range_keys = array();
        $valid_range_keys = array();
        $invalid_range_keys = array();
        $range = array();
        $error = '';
        $class_properties = $this->getClass_properties();
        if (! empty($options)) {
            $options_keys = array_keys($options);
            $valid_options = array_intersect($options_keys, $class_properties);
            foreach ($valid_options as $valid_option) {
                //$setter_options array is now ready for search
                //but will it participate,is not confirmed
                $setter_options[$valid_option] = $options[$valid_option];
            }
            $invalid_options = array_diff($options_keys, $class_properties);
            if (! empty($invalid_options)) {
                foreach ($invalid_options as $invalid_option) {
                    $error = $error . '  ' . $invalid_option;
                }
            }
        }
        if (! empty($property_range)) {
            $property_range_keys = array_keys($property_range);
            $valid_range_keys = array_intersect($property_range_keys, 
            $class_properties);
            foreach ($valid_range_keys as $valid_range_key) {
                //$range array is now ready for search
                //but will it participate,is not confirmed
                $range[$valid_range_key] = $property_range[$valid_range_key];
            }
            $invalid_range_keys = array_diff($property_range_keys, 
            $class_properties);
            if (! empty($invalid_range_keys)) {
                $error = implode(', ', $invalid_range_keys);
            }
        }
        $user_friendly_message = "<b>" . $error . "</b>" .
         ' are invalid parameters and therefore, they were not included in search.' .
         "</br>" .
         'Please try again with correct parameters to get more accurate results' .
         "</br>";
        $deciding_intersection = array_intersect($valid_options, 
        $valid_range_keys);
        Zend_Registry::get('logger')->debug(var_export($user_friendly_message));
        $deciding_intersection = array_intersect($valid_options, 
        $valid_range_keys);
        if (empty($deciding_intersection)) {
            //now we can set off for search operation
            $this->setOptions($setter_options);
            $result = $this->getMapper()->fetchStudents($this, $setter_options, 
            $range);
            return $result;
        } else {
            foreach ($deciding_intersection as $duplicate_entry) {
                $error_1 = $error_1 . '  ' . $duplicate_entry;
            }
            throw new Exception(
            'Range and equality cannot be set for ' . $error_1 .
             ' at the same time');
        }
    }
}