<?php
/**
 * Indexa - NF-e. 
 *
 * @title      Magento Indexa NF-e
 * @category   General
 * @package    Indexa_Nfe
 * @author     Indexa Development Team <desenvolvimento@indexainternet.com.br>
 * @copyright  Copyright (c) 2011 Indexa - http://www.indexainternet.com.br
 */


class Indexa_Nfe_Model_Resource_Sales_Order_Request_Collection extends Indexa_Nfe_Model_Resource_Db_Collection_Abstract{
    
    /**
     * Initialize resource
     *
     */
    public function _construct(){
        $this->_init('indexa_nfe/sales_order');
    }
    
     /**
     * Filter by NF request status
     *
     * @param string|array $status
     * 
     * @return Indexa_Nfe_Model_Resource_Sales_Order_Collection
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
     * @return Indexa_Nfe_Model_Resource_Sales_Order_Nf_Collection
     */
    public function addNfFilter($id){
        if (!empty($id)) {
            if (is_array($id)) {
                $this->addFieldToFilter('main_table.nfe_nf_id', array('in' => $id));
            } else {
                $this->addFieldToFilter('main_table.nfe_nf_id', $id);
            }
        }
        return $this;
    }
}

