<?php
/**
 * Description of Payment
 *
 * @author greg
 * @package
 */

class Wpjb_Module_Admin_Payment extends Wpjb_Controller_Admin
{
    public function init()
    {

    }

    protected function _notifyJob($id)
    {
        $job = new Wpjb_Model_Job($id);
        $mod = Wpjb_Project::getInstance()->conf("posting_moderation");
        if(!$mod) {
            $job->is_active = 1;
            $job->is_approved = 1;
            Wpjb_Utility_Messanger::send(2, $job);
        }

        $job->payment_paid = $job->payment_sum;
        $job->save();
    }

    protected function _notifyResume($id)
    {
        $object = new Wpjb_Model_ResumesAccess($id);
        $emp = new Wpjb_Model_Employer($object->employer_id);
        $emp->addAccess($object->extend);
        $emp->save();
    }
    
    public function _paid($id)
    {
        $payment = new Wpjb_Model_Payment($id);
        
        if($payment->made_at != "0000-00-00 00:00:00") {
            return;
        }

        $payment->made_at = date("Y-m-d H:i:s");

        try {
            if($payment->object_type == Wpjb_Model_Payment::FOR_JOB) {
                $this->_notifyJob($payment->object_id);
            } elseif($payment->object_type == Wpjb_Model_Payment::FOR_RESUMES) {
                $this->_notifyResume($payment->object_id);
            } else {
                // wtf?
            }

            $payment->payment_paid = $payment->payment_sum;
            $payment->external_id = "manualy accepted";
            $payment->is_valid = 1;
            $payment->save();
            
            $this->_addInfo(__("Payment accepted.", WPJB_DOMAIN));

        } catch(Exception $e) {
            $payment->message = $e->getMessage();
            $payment->is_valid = 0;
            $payment->save();
            
            $this->_addError(__("Payment could not be accepted.", WPJB_DOMAIN)." ".$e->getMessage());
        }


    }
    
    
    public function indexAction()
    {
        $paid = (int)$this->_request->get("paid", 0);
        if($paid>0) {
            $this->_paid($paid);
        }
        
                
        $page = (int)$this->_request->get("page", 1);
        if($page < 1) {
            $page = 1;
        }
        $id = null;
        if($this->_request->post("id")) {
            $id = (int)$this->_request->post("id", 1);
        }

        $this->view->id = $id;
        $perPage = $this->_getPerPage();

        $query = new Daq_Db_Query();
        $query = $query->select("t.*, t2.*")
            ->from("Wpjb_Model_Payment t")
            ->joinLeft("t.user t2")
            ->order("t.id DESC")
            ->limitPage($page, $perPage);

        if($id > 0) {
            $query->where("t.id = ?", $id);
        }
        $this->view->data = $query->execute();

        $query = new Daq_Db_Query();
        $total = $query->select("COUNT(*) AS total")
            ->from("Wpjb_Model_Payment t")
            ->joinLeft("t.user t2")
            ->order("t.id DESC")
            ->limit(1);
        
        if($id > 0) {
            $query->where("t.id = ?", $id);
        }
        $total = $total->fetchColumn();

        $this->view->current = $page;
        $this->view->total = ceil($total/$perPage);
    }



}

?>