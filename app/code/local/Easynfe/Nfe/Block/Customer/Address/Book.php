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

class Easynfe_Nfe_Block_Customer_Address_Book extends Mage_Customer_Block_Address_Book
{
    public function getAddressHtml($address)
    {
        if( is_object($address) && is_numeric( $address->getCity() ) ){
            $address->setCity( Mage::getModel('easynfe_nfe/directory_country_region_city')->load($address->getCity())->getName() );
        }

        return $address->format('html');
        //return $address->toString($address->getHtmlFormat());
    }
}
