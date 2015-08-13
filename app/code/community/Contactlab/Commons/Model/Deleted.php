<?php

/**
 * Class Contactlab_Commons_Model_Deleted.
 * @method bool getIsCustomer
 * @method string getEmail
 * @method setTaskId
 */
class Contactlab_Commons_Model_Deleted extends Mage_Core_Model_Abstract {
	
	public function _construct() {
		parent::_construct ();
		$this->_init('contactlab_commons/deleted' );
	}
	
}
