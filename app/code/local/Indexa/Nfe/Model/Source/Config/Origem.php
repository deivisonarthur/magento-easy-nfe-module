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

class Indexa_Nfe_Model_Source_Config_Origem extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
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
                'value' => Indexa_Nfe_Helper_Data::NFE_ORIGEM_NACIONAL,
                'label' => Mage::helper('adminhtml')->__('Nacional')
            ),
            array(
                'value' => Indexa_Nfe_Helper_Data::NFE_ORIGEM_ESTRANGEIRA_IMPORTACAO,
                'label' => Mage::helper('adminhtml')->__('Estrangeira – Importação direta')
            ),
            array(
                'value' => Indexa_Nfe_Helper_Data::NFE_ORIGEM_ESTRANGEIRA_ADQUIRIDA,
                'label' => Mage::helper('adminhtml')->__('Estrangeira – Adquirida no mercado interno')
            ),
        );
    }
}
