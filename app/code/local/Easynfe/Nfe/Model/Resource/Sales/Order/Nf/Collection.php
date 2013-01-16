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


class Easynfe_Nfe_Model_Resource_Sales_Order_Nf_Collection extends Easynfe_Nfe_Model_Resource_Db_Collection_Abstract{
    
    /**
     * Initialize resource
     *
     */
    public function _construct(){
        $this->_init('easynfe_nfe/sales_order_nf');
    }
    
     /**
     * Filter by NF status
     *
     * @param string|array $status
     * 
     * @return Easynfe_Nfe_Model_Resource_Sales_Order_Nf_Collection
     */
    public function addStatusFilter($status){
        if (!empty($status)) {
            if (is_array($status)) {
                $this->addFieldToFilter('main_table.status', array('in' => $status));
            } else {
                $this->addFieldToFilter('main_table.status', $status);
            }
        }
        return $this;
    }
     /**
     * Filter by NF id
     *
     * @param string|array $id
     * 
     * @return Easynfe_Nfe_Model_Resource_Sales_Order_Nf_Collection
     */
    public function addNfFilter($id){
        if (!empty($id)) {
            if (is_array($id)) {
                $this->addFieldToFilter('main_table.nf_order_id', array('in' => $id));
            } else {
                $this->addFieldToFilter('main_table.nf_order_id', $id);
            }
        }
        return $this;
    }
}

