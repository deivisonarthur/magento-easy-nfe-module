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

class Easynfe_Nfe_Model_Certificado extends Mage_Core_Model_Abstract
{
     /**
     * define model key
     *
     * @return void
     */
    public function _construct(){
        $this->_init('easynfe_nfe/certificado');
    }
   
}