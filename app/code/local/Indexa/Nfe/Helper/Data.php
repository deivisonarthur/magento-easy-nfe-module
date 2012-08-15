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

class Indexa_Nfe_Helper_Data extends Mage_Core_Helper_Abstract
{
     /**
     * @var string
     */
    const NFE_TIPO_AMBIENTE_PRODUCAO = '1';
    
    /**
     * @var string
     */
    const NFE_TIPO_AMBIENTE_HOMOLOGACAO = '2';
    
    /**
     * @var string
     */
    const NFE_ORIGEM_NACIONAL = '0';

    /**
     * @var string
     */
    const NFE_ORIGEM_ESTRANGEIRA_IMPORTACAO = '1';

    /**
     * @var string
     */
    const NFE_ORIGEM_ESTRANGEIRA_ADQUIRIDA = '2';
   
    /**
     * @var string
     */
    const NFE_NATOP_VENDA = '1';
   
    /**
     * @var string
     */
    const NFE_PROCEMI_DEFAULT = '0';
   
    /**
     * @var string
     */
    const NFE_FINNFE_NORMAL = '1';
    
    /**
     * @var string
     */
    const NFE_TPEMIS_NORMAL = '1';
    
    /**
     * @var string
     */
    const NFE_TPEMIS_CONTINGENCIA_FS = '2';
    
    /**
     * @var string
     */
    const NFE_TPEMIS_CONTINGENCIA_SCAN = '3';
    
    /**
     * @var string
     */
    const NFE_TPEMIS_CONTINGENCIA_DPEC = '4';
    
    /**
     * @var string
     */
    const NFE_TPEMIS_CONTINGENCIA_FS_DA = '5';
    
    /**
     * @var string
     */
    const NFE_TPIMP_RETRATO = '1';
    
    /**
     * @var string
     */
    const NFE_TPIMP_PAISAGEM = '2';
    
    /**
     * @var string
     */
    const NFE_TPNF_ENTRADA = '0';
    /**
     * @var string
     */
    const NFE_TPNF_SAIDA = '1';
    
    /**
     * @var string
     */
    const NFE_CRT_SIMPLES = '1';
    
    /**
     * @var string
     */
     const NFE_CRT_SIMPLES_EXCESSO  = '2';
     
    /**
     * @var string
     */
     const NFE_CRT_REGIME_NORMAL  = '3';
     
    /**
     * @var string
     */
     const NFE_SHIPMENT_STATUS_CREATED  = 'created';
     
    /**
     * @var string
     */
     const NFE_SHIPMENT_STATUS_FINISHED  = 'finished';
   
    /**
     * @var string
     */
     const NFE_SHIPMENT_STATUS_PROCESSING  = 'processing';
    
    /**
     * @var string
     */
     const NFE_SHIPMENT_STATUS_ERROR  = 'error';
     
     

}