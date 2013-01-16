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

class Easynfe_Nfe_Model_Source_Config_Crt
{
    /**
     * Retrieve CRT information
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => Easynfe_Nfe_Helper_Data::NFE_CRT_SIMPLES,
                'label' => Mage::helper('adminhtml')->__('Simples Nacional')
            ),
            array(
                'value' => Easynfe_Nfe_Helper_Data::NFE_CRT_SIMPLES_EXCESSO,
                'label' => Mage::helper('adminhtml')->__('Simples Nacional (excesso de sublimite de receita bruta )')
            ),
            array(
                'value' => Easynfe_Nfe_Helper_Data::NFE_CRT_REGIME_NORMAL,
                'label' => Mage::helper('adminhtml')->__('Regime Normal')
            ),
        );
    }
}
