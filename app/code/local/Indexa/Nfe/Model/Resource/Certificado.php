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

class Indexa_Nfe_Model_Resource_Certificado extends Mage_Core_Model_Mysql4_Abstract
{
     /**
     * Define main table and id field name
     *
     * @return void
     */
    protected function _construct(){
        $this->_init('indexa_nfe/certificado', 'id');
    }
    
    /**
     * Upload file and import data from it
     *
     * @param Varien_Object $object
     * @throws Mage_Core_Exception
     * @return Mage_Shipping_Model_Mysql4_Carrier_Tablerate
     */
    public function uploadAndImport(Varien_Object $object)
    {
        if (empty($_FILES['groups']['tmp_name']['acesso']['fields']['importcert']['value'])) {
            return $this;
        }
        
        $sFile = base64_encode( file_get_contents( $_FILES['groups']['tmp_name']['acesso']['fields']['importcert']['value'] ) );
        
        $mCertificado = Mage::getModel('indexa_nfe/certificado');
        
        /**
         * check if certificado exists to update
         */
        if( $idCertificado = $this->hasCertificado() ){
            $mCertificado->setId($idCertificado);
        }
        
        $mCertificado->setCertificado( $sFile );
        $mCertificado->setCreatedAt( date('Y-m-d H:i:s') );
        $mCertificado->save();
     
        return $this;
    }
    
    /**
     * try to load first element from nfe_certificado
     * 
     * @return int
     */
    public function hasCertificado(){
        return Mage::getModel('indexa_nfe/certificado')->load('1')->getId();
    }
}