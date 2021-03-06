<?php

/**
 * Controller that manage the queue of exporting tasks.
 */
class Contactlab_Subscribers_Adminhtml_Contactlab_Subscribers_UkController extends Mage_Adminhtml_Controller_Action {
    /**
     * Update UK Table action.
     */
    public function updateAction() {
        $doIt = Mage::app()->getRequest()->getParam('doit') === 'yes';
        $helper = Mage::helper('contactlab_subscribers');
        $session = Mage::getSingleton('adminhtml/session');
        try {
            if (!Mage::helper('contactlab_commons')->isAllowed('uk', 'update')) {
                throw new Zend_Exception("Unique keys update not allowed");
            }
            $this->doUpdate($doIt);
            if ($doIt) {
                $session->addSuccess($helper->__('Unique keys updated successfully.'));
            }
        } catch (Exception $e) {
            $session->addError($e);
        }
        return $this->_redirect('adminhtml/contactlab_commons_tasks');
    }

    /**
     * Truncate UK Table action.
     */
    public function truncateAction() {
        $helper = Mage::helper('contactlab_subscribers');
        $session = Mage::getSingleton('adminhtml/session');
        try {
            if (!Mage::helper('contactlab_commons')->isAllowed('uk', 'truncate')) {
                throw new Zend_Exception("Unique keys truncate not allowed");
            }
            $this->truncate();
            $session->addSuccess($helper->__('Unique keys truncation successfully queued.'));
        } catch (Exception $e) {
            $session->addError($e);
        }
        return $this->_redirect('adminhtml/contactlab_commons_tasks');
    }

    /** Really update uk. */
    private function doUpdate($doIt) {
        /* @var $helper Contactlab_Subscribers_Helper_Uk */
        $helper = Mage::helper('contactlab_subscribers/uk');
        if ($doIt) {
            $helper->addUpdateUkTask();
        } else {
            $helper->updateAll($doIt);
        }
    }

    /** Truncate table. */
    private function truncate() {
        /* @var $helper Contactlab_Subscribers_Helper_Uk */
        $helper = Mage::helper('contactlab_subscribers/uk');
        $helper->addTruncateUkTask();
    }

    /**
     * Is this controller allowed?
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('newsletter/contactlab/stats');
    }
}
