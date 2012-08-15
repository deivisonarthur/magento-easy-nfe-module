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

class Indexa_Nfe_Model_Sales_Shipment extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resource
     *
     */
    protected function _construct(){
        $this->_init('indexa_nfe/sales_shipment');
    }
}