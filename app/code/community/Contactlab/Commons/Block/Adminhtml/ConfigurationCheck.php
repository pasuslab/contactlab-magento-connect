<?php

/**
 * Rel notes block.
 */
class Contactlab_Commons_Block_Adminhtml_ConfigurationCheck extends Mage_Adminhtml_Block_Widget_Container {
    /**
     * Construct
     */
     protected function _construct()
     {
         $this->_headerText = "Cron Configuration Check";
         parent::_construct();
     }
     
     /**
      * Gets release notes collection.
      * @return \Varien_Data_Collection
      */
     public function getCronConfiguration() {
        $rv = new Varien_Data_Collection();
        $config = Mage::getConfig()->getNode('crontab/jobs')->children();
        $e = "";
        foreach ($config as $cronItem) {
            if (preg_match('|^contactl|', $cronItem->getName())) {
                $item = new Varien_Object();
                $item->setModule($this->normalizeModule($cronItem->getName()));
                $item->setName($this->normalizeName($cronItem->getName()));
                if ($cronItem->description) {
                    $item->setDescription((string) $cronItem->description);
                }
                if ($cronItem->schedule) {
                    $item->setSchedule((string) $cronItem->schedule->cron_expr);
                } else {
                    $item->setSchedule(false);
                }
                $rv->addItem($item);
            }
        }
        return $rv;
     }

    public function normalizeModule($name)
    {
        return ucwords(str_replace('_', ' ', preg_replace('|^([^_]*_[^_]*).*|', '$1', $name)));
    }
    public function normalizeName($name)
    {
        return ucwords(str_replace('_', ' ', preg_replace('|^[^_]*_[^_]*(.*)|', '$1', $name)));
    }

}
