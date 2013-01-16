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


class Easynfe_Nfe_Model_System_Config_Certificado extends Mage_Core_Model_Config_Data
{
    public function _afterSave(){
        Mage::getResourceModel('easynfe_nfe/certificado')->uploadAndImport($this);
    }
 
}