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

class Indexa_Nfe_Model_Source_Config_Tpemis
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
                'value' => Indexa_Nfe_Helper_Data::NFE_TPEMIS_NORMAL,
                'label' => Mage::helper('adminhtml')->__('Normal')
            ),
            array(
                'value' => Indexa_Nfe_Helper_Data::NFE_TPEMIS_CONTINGENCIA_FS,
                'label' => Mage::helper('adminhtml')->__('Contingência FS')
            ),
            array(
                'value' => Indexa_Nfe_Helper_Data::NFE_TPEMIS_CONTINGENCIA_SCAN,
                'label' => Mage::helper('adminhtml')->__('Contingência SCAN')
            ),
            array(
                'value' => Indexa_Nfe_Helper_Data::NFE_TPEMIS_CONTINGENCIA_DPEC,
                'label' => Mage::helper('adminhtml')->__('Contingência DPEC')
            ),
            array(
                'value' => Indexa_Nfe_Helper_Data::NFE_TPEMIS_CONTINGENCIA_FS_DA,
                'label' => Mage::helper('adminhtml')->__('Contingência FS-DA')
            )
        );
    }
}
