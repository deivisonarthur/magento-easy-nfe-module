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

class Easynfe_Nfe_Model_Source_Config_Finnfe
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
                'value' => Easynfe_Nfe_Helper_Data::NFE_TPIMP_RETRATO,
                'label' => Mage::helper('adminhtml')->__('Retrato')
            ),
            array(
                'value' => Easynfe_Nfe_Helper_Data::NFE_TPIMP_PAISAGEM,
                'label' => Mage::helper('adminhtml')->__('Paisagem')
            )
        );
    }
}
