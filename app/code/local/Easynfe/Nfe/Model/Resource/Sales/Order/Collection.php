<?php
/**
 * Easynfe - NF-e. 
 *
 * @title      Magento Easynfe NF-e
 * @category   General
 * @package    Easynfe_Nfe
 * @author     Indexa Development Team <desenvolvimento@indexainternet.com.br>
 * @copyright  Copyright (c) 2011 Indexa - http://www.indexainternet.com.br
 */


class Easynfe_Nfe_Model_Resource_Sales_Order_Collection extends Easynfe_Nfe_Model_Resource_Db_Collection_Abstract{
    
    /**
     * Initialize resource
     *
     */
    public function _construct(){
        $this->_init('easynfe_nfe/sales_order');
    }
    
    /**
     * Filter NF By order Id
     *
     * @param string|array $id
     * 
     * @return Easynfe_Nfe_Model_Resource_Sales_Order_Collection
     */
    public function addOrderFilter($id){
        if (!empty($id)) {
            if (is_array($id)) {
                $this->addFieldToFilter('main_table.order_id', array('in' => $id));
            } else {
                $this->addFieldToFilter('main_table.order_id', $id);
            }
        }
        return $this;
    }
    
}

