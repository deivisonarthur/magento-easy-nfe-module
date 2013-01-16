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

class Easynfe_Nfe_Model_Source_Config_Origem extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    
    /**
     * Retrieve CRT information
     *
     * @return array
     */
    public function getAllOptions()
    {
        return array(
            array(
                'value' => Easynfe_Nfe_Helper_Data::NFE_ORIGEM_NACIONAL,
                'label' => Mage::helper('adminhtml')->__('Nacional')
            ),
            array(
                'value' => Easynfe_Nfe_Helper_Data::NFE_ORIGEM_ESTRANGEIRA_IMPORTACAO,
                'label' => Mage::helper('adminhtml')->__('Estrangeira – Importação direta')
            ),
            array(
                'value' => Easynfe_Nfe_Helper_Data::NFE_ORIGEM_ESTRANGEIRA_ADQUIRIDA,
                'label' => Mage::helper('adminhtml')->__('Estrangeira – Adquirida no mercado interno')
            ),
        );
    }
}
