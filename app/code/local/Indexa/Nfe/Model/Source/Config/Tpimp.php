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

class Indexa_Nfe_Model_Source_Config_Tpimp
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
                'value' => Indexa_Nfe_Helper_Data::NFE_TPIMP_RETRATO,
                'label' => Mage::helper('adminhtml')->__('Retrato')
            ),
            array(
                'value' => Indexa_Nfe_Helper_Data::NFE_TPIMP_PAISAGEM,
                'label' => Mage::helper('adminhtml')->__('Paisagem')
            )
        );
    }
}
