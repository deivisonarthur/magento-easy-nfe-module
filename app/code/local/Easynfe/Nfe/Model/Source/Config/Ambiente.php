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

class Easynfe_Nfe_Model_Source_Config_Ambiente
{
    /**
     * Retrieve envoirment information
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => Easynfe_Nfe_Helper_Data::NFE_TIPO_AMBIENTE_PRODUCAO,
                'label' => Mage::helper('adminhtml')->__('Produção')
            ),
            array(
                'value' => Easynfe_Nfe_Helper_Data::NFE_TIPO_AMBIENTE_HOMOLOGACAO,
                'label' => Mage::helper('adminhtml')->__('Homologação')
            ),
        );
    }
}
