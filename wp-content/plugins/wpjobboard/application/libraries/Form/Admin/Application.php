<?php
/**
 * Description of Application
 *
 * @author greg
 * @package
 */

class Wpjb_Form_Admin_Application extends Daq_Form_ObjectAbstract
{
    protected $_model = "Wpjb_Model_Application";

    public function _exclude()
    {
        if($this->_object->getId()) {
            return array("id" => $this->_object->getId());
        } else {
            return array();
        }
    }

    public function init()
    {
        $e = new Daq_Form_Element("id", Daq_Form_Element::TYPE_HIDDEN);
        $e->setValue($this->_object->id);
        $e->addFilter(new Daq_Filter_Int());
        $this->addElement($e);

        $e = new Daq_Form_Element("applicant_name");
        $e->setRequired(true);
        $e->setValue($this->_object->applicant_name);
        $e->setLabel(__("Applicant Name", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("email");
        $e->setRequired(true);
        $e->setValue($this->_object->email);
        $e->setLabel(__("E-mail", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("resume", Daq_Form_Element::TYPE_TEXTAREA);
        $e->setValue($this->_object->resume);
        $e->setLabel(__("Resume/Message", WPJB_DOMAIN));
        $this->addElement($e);

        $e = new Daq_Form_Element("is_rejected", Daq_Form_Element::TYPE_SELECT);
        $e->setValue($this->_object->is_rejected);
        $e->setLabel(__("Reject application", WPJB_DOMAIN));
        $e->addFilter(new Daq_Filter_Int());
        $e->addValidator(new Daq_Validate_InArray(array(0,1)));
        $e->addOption(1, 1, __("Yes", WPJB_DOMAIN));
        $e->addOption(0, 0, __("No", WPJB_DOMAIN));
        $this->addElement($e);

        apply_filters("wpja_form_init_application", $this);

        $this->_additionalFields();
    }
    
    protected function _additionalFields()
    {
        $query = new Daq_Db_Query();
        $result = $query->select("*")->from("Wpjb_Model_AdditionalField t")
            ->joinLeft("t.value t2", "job_id=".$this->getObject()->getId())
            ->where("field_for = 2")
            ->where("is_active = 1")
            ->execute();


        foreach($result as $field) {
            $e = new Daq_Form_Element("field_".$field->getId(), $field->type);
            $e->setLabel($field->label);
            $e->setHint($field->hint);


            if($field->type == Daq_Form_Element::TYPE_SELECT) {
                $query = new Daq_Db_Query();
                $option = $query->select("*")
                    ->from("Wpjb_Model_FieldOption t")
                    ->where("field_id=?", $field->getId())
                    ->execute();

                foreach($option as $o) {
                    if($o->value == $field->getValue()->value) {
                        $e->setValue($o->id);
                        break;
                    }
                }

            } else {
                $e->setValue($field->getValue()->value);
            }

            if($field->type != Daq_Form_Element::TYPE_CHECKBOX) {
                $e->setRequired((bool)$field->is_required);
            } else {
                $e->addFilter(new Daq_Filter_Int());
            }

            if($field->type == Daq_Form_Element::TYPE_TEXT) {
                switch($field->validator) {
                    case 1:
                        $e->addValidator(new Daq_Validate_StringLength(0, 80));
                        break;
                    case 2:
                        $e->addValidator(new Daq_Validate_StringLength(0, 160));
                        break;
                    case 3:
                        $e->addValidator(new Daq_Validate_Int());
                        break;
                    case 4:
                        $e->addValidator(new Daq_Validate_Float());
                        break;
                }
            }

            foreach((array)$field->getOptionList() as $option) {
                $e->addOption($option->getId(), $option->getId(), $option->value);
            }

            $this->addElement($e, "fields");
        }
    }
    
    protected function _saveAdditionalFields(array $valueList)
    {
        $query = new Daq_Db_Query();
        $result = $query->select("*")
            ->from("Wpjb_Model_AdditionalField t")
            ->where("is_active = 1")
            ->where("field_for = 2")
            ->execute();

        $query = new Daq_Db_Query();
        $fieldValue = $query->select("*")
            ->from("Wpjb_Model_FieldValue t")
            ->where("job_id = ?", $this->getObject()->getId())
            ->execute();

        foreach($result as $option) {
            $id = "field_".$option->getId();
            $value = $valueList[$id];
            if($option->type == Daq_Form_Element::TYPE_SELECT) {
                foreach((array)$option->getOptionList() as $opt) {
                    if($opt->id == $value) {
                        $value = $opt->value;
                        break;
                    }
                }
            }

            $object = null;
            foreach($fieldValue as $temp) {
                if($temp->field_id == $option->getId()) {
                    $object = $temp;
                    break;
                }
            }

            if($object === null) {
                $object = new Wpjb_Model_FieldValue();
                $object->field_id = $option->getId();
                $object->job_id = $this->getObject()->getId();
            }

            $object->value = $value;
            $object->save();
        }
    }
    
    public function save()
    {
        $valueList = $this->getValues();
        
        parent::save();
        $this->_saveAdditionalFields($valueList);
        $this->_additionalFields();
    }
}

?>