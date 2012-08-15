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

class Indexa_Nfe_Model_Source_Config_Crt
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
                'value' => Indexa_Nfe_Helper_Data::NFE_CRT_SIMPLES,
                'label' => Mage::helper('adminhtml')->__('Simples Nacional')
            ),
            array(
                'value' => Indexa_Nfe_Helper_Data::NFE_CRT_SIMPLES_EXCESSO,
                'label' => Mage::helper('adminhtml')->__('Simples Nacional (excesso de sublimite de receita bruta )')
            ),
            array(
                'value' => Indexa_Nfe_Helper_Data::NFE_CRT_REGIME_NORMAL,
                'label' => Mage::helper('adminhtml')->__('Regime Normal')
            ),
        );
    }
}
