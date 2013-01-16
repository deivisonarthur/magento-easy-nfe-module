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


class Easynfe_Nfe_Model_Resource_Sales_Order_Nf extends Easynfe_Nfe_Model_Resource_Db_Abstract{
    
    /**
     * Initialize resource
     *
     */
    public function _construct(){
        $this->_init('easynfe_nfe/sales_order_nf', 'id');
    }
}

