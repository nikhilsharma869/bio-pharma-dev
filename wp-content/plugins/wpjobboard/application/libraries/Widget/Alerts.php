<?php
/**
 * Description of JobBoardMenu
 *
 * @author greg
 * @package
 */

class Wpjb_Widget_Alerts extends Daq_Widget_Abstract
{
    public function __construct() 
    {
        $this->_context = Wpjb_Project::getInstance();
        $this->_viewAdmin = "alerts.php";
        $this->_viewFront = "alerts.php";
        
        parent::__construct(
            "wpjb-widget-alerts", 
            __("Job Alerts", WPJB_DOMAIN),
            array("description"=>__("Allows to create new job alert", WPJB_DOMAIN))
        );
    }
    
    public function update($new_instance, $old_instance) 
    {
	$instance = $old_instance;
	$instance['title'] = htmlspecialchars($new_instance['title']);
	$instance['hide'] = (int)($new_instance['hide']);
        return $instance;
    }

    public function _filter()
    {

    }


}

?>