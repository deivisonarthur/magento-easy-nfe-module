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


class Indexa_Nfe_Model_System_Config_Certificado extends Mage_Core_Model_Config_Data
{
    public function _afterSave(){
        Mage::getResourceModel('indexa_nfe/certificado')->uploadAndImport($this);
    }
 
}