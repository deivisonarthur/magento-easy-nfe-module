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
class Indexa_Nfe_Model_Nfe {
    
    /**
     * staging server URLs
     */    
    const NFE_TEST_REQUEST_PUT_URL =  'https://staging.doit.com.br/easy-nfe-server/nfe';
    
    const NFE_TEST_REQUEST_URL =      'https://staging.doit.com.br/easy-nfe-server/nfe/request/';
    
    const NFE_TEST_REQUEST_URL_BASE = 'https://staging.doit.com.br/easy-nfe-server/';
    
    /**
     * server URLs
     */
    const NFE_REQUEST_PUT_URL = 'https://easynfe.doit.com.br/nfe';
    
    const NFE_REQUEST_URL =     'https://easynfe.doit.com.br/nfe/request/';
    
    const NFE_REQUEST_URL_BASE = 'https://easynfe.doit.com.br/';
    
    
    const NFE_SERIE = '11';

    /**
     * Starts processing NF-e 
     */
    public function execute() {

        /**
         * get shipment collection
         */
        $mOrderNfe = Mage::getModel('indexa_nfe/sales_order_nf')
                ->getCollection()
                ->addStatusFilter(Indexa_Nfe_Helper_Data::NFE_SHIPMENT_STATUS_CREATED);

        $aParams["nfe.NFe"]["nfe.infNFe"]["@versao"] = Mage::getStoreConfig('indexa_nfe/geral/versao');
        $aParams["nfe.NFe"]["nfe.infNFe"]["nfe.ide"] = $this->_prepareIdeData();
        $aParams["nfe.NFe"]["nfe.infNFe"]["nfe.emit"] = $this->_prepareEmitData();

        if (count($mOrderNfe) > 0) {
            foreach ($mOrderNfe as $mNfe) {
                /**
                 * save executed date 
                 */
                $mNfe->setData('executed_at', date('Y-m-d H:i:s'));
                $mNfe->save();

                /**
                 * load sales order shipment
                 */
		
                if ($mNfe->getShipmentId()) {
                    $mOrderShipment = Mage::getModel('sales/order_shipment')->load($mNfe->getShipmentId());
                    $mOrder = $mOrderShipment->getOrder();

                    $mOrder->getIncrementId();  

                    $aParams["nfe.NFe"]["nfe.infNFe"]["nfe.dest"] = $this->_prepareCustomerData($mOrder);
                    $aParams["nfe.NFe"]["nfe.infNFe"]["nfe.det"] = $this->_prepareItems($mOrderShipment);
                    $aParams["nfe.NFe"]["nfe.infNFe"]["nfe.total"] = $aParams["nfe.NFe"]["nfe.infNFe"]["nfe.det"]["nfe.total"];
                    $aParams["nfe.NFe"]["nfe.infNFe"]["nfe.transp"]["nfe.modFrete"] = '0'; // emitente
                    //$aParams["nfe.NFe"]["nfe.infNFe"]["nfe.total"] =  $aParams["nfe.NFe"]["nfe.infNFe"]["nfe.det"]["nfe.total"];

                    $aParams["nfe.organization"] = Mage::getStoreConfig('indexa_nfe/acesso/chave');
                    $aParams["nfe.cert"]["easynfe.certData"] = Mage::getModel('indexa_nfe/certificado')->load('1')->getCertificado();
                    $aParams["nfe.cert"]["easynfe.certPasswd"] = Mage::getStoreConfig('indexa_nfe/acesso/password');

                    $aParams["nfe.NFe"]["nfe.infNFe"]["nfe.infAdic"]["nfe.infCpl"] = ".";

                    unset($aParams["nfe.NFe"]["nfe.infNFe"]["nfe.det"]["nfe.total"]);

                    $this->_nfeSend($mNfe->getId(), $aParams);

                }
            }
        }
        return $this;
    }

    /**
     * start communication with easyNFe
     * 
     * @param array $aParams 
     */
    private function _nfeSend($nfeId, $aParams) {
        //echo '<pre>';print_r($aParams);die();
        $mRequest = Mage::getModel('indexa_nfe/sales_order_request');
        
        $mRequest->setData('request', Zend_Json::encode($aParams));
        $mRequest->setData('nfe_nf_id', $nfeId);
        $mRequest->setData('status', Indexa_Nfe_Helper_Data::NFE_SHIPMENT_STATUS_CREATED);
        $mRequest->setData('created_at', date('Y-m-d H:i:s'));
        
        $mRequest->save();

        if( Mage::getStoreConfig('indexa_nfe/config/tpamb') == '1' ){
            $url = self::NFE_REQUEST_PUT_URL;
        }else{
            $url = self::NFE_TEST_REQUEST_PUT_URL;
        }

        /**
         * prepare curl request
         */
        $defaults = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 1,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            CURLOPT_POSTFIELDS => Zend_Json::encode($aParams),
            //CURLOPT_POST=> true,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_RETURNTRANSFER => true
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, ($defaults));

        if (!$result = curl_exec($ch)) {
            $message = curl_error($ch);
            $mRequest->setData('status', Indexa_Nfe_Helper_Data::NFE_SHIPMENT_STATUS_ERROR);
        } else {
            $sucess = explode(PHP_EOL, $result);
            $message = $sucess[8];
            $mRequest->setData('status', Indexa_Nfe_Helper_Data::NFE_SHIPMENT_STATUS_PROCESSING);
        }
       
        curl_close($ch);
        
        $mRequest->setData('messages', $message);
        
        $mRequest->setData('executed_at', date('Y-m-d H:i:s'));
        $mRequest->save();

        return $mRequest->getData('messages');
    }

    public function updateInfo(){
        
        /**
         * get shipment collection
         */
        $mNfeRequest = Mage::getModel('indexa_nfe/sales_order_request')
                ->getCollection()
                ->addStatusFilter(Indexa_Nfe_Helper_Data::NFE_SHIPMENT_STATUS_PROCESSING);    
     //   echo '<pre>';
        if ($mNfeRequest){
            foreach ($mNfeRequest as $request){
                 $this->_getRequestInfo( $request );
                
            }
        }
        
      
        
    }
    
    
    private function _getRequestInfo( $request ){
        
        if( Mage::getStoreConfig('indexa_nfe/config/tpamb') == '1' ){
            $url = self::NFE_REQUEST_URL;
        }else{
            $url = self::NFE_TEST_REQUEST_URL;
        }
        
        if( Mage::getStoreConfig('indexa_nfe/config/tpamb') == '1' ){
            $url_base = self::NFE_REQUEST_URL_BASE;
        }else{
            $url_base = self::NFE_TEST_REQUEST_URL_BASE;
        }
        
        
        
        $httpmessage = file($url . $request->getMessages() );
        
        $mRequest = Mage::getModel('indexa_nfe/sales_order_request')->load($request->getId());
        $orderId = Mage::getModel('indexa_nfe/sales_order')->load( Mage::getModel('indexa_nfe/sales_order_nf')->load( $mRequest->getNfeNfId() )->getNfOrderId() )->getOrderId();
        $mOrder = Mage::getModel('sales/order')->load($orderId);
        /* @var $mOrder Mage_Sales_Model_Order */  
        
        if( is_array($httpmessage) ){
             
            if( 'AUTHORIZED' == str_replace(PHP_EOL, '', $httpmessage[0]) ){
                $access_key = file_get_contents( $url_base . 'nfe/' . Mage::getStoreConfig('indexa_nfe/acesso/chave') . '/' . self::NFE_SERIE . '/' . $httpmessage[1] . '/accessKey');
                
                if( $access_key ){ 
                    
                    /**
                     * save tmp xml
                     */
                    $tmp_filename = Mage::getBaseDir() . '/nf/tmp/'.$access_key.'.xml';
                    $xml_content = file_get_contents( $url_base . 'nfe/' . Mage::getStoreConfig('indexa_nfe/acesso/chave') . '/' . Indexa_Nfe_Model_Nfe::NFE_SERIE . '/' . $httpmessage[1] . '?accessKey=' . $access_key);
                    
                    file_put_contents( $tmp_filename, $xml_content);
                    $nfXML = new Zend_Config_Xml( $tmp_filename );
                    
                    if( $nfXML->protNFe->infProt->chNFe ){
                        
                        $xml_filename = Mage::getBaseDir() . '/nf/xml/'.$nfXML->protNFe->infProt->chNFe.'.xml';
                        file_put_contents( $xml_filename, $xml_content);
                        
                        $pdf_filename = Mage::getBaseDir() . '/nf/pdf/'.$nfXML->protNFe->infProt->chNFe.'.pdf';
                        $pdf_content = file_get_contents( $url_base . 'nfe/' . Mage::getStoreConfig('indexa_nfe/acesso/chave') . '/' . Indexa_Nfe_Model_Nfe::NFE_SERIE . '/' . $httpmessage[1] . '/danfe?accessKey=' . $access_key);
                        file_put_contents( $pdf_filename, $pdf_content );
                       
                        $mRequest->setData('messages', $nfXML->protNFe->infProt->chNFe );
                        $mRequest->setData('status', Indexa_Nfe_Helper_Data::NFE_SHIPMENT_STATUS_FINISHED);
                        $mRequest->setData('finished_at', date('Y-m-d H:i:s'));

                         /**
                         * change status order
                         */
                        if( $mOrder->canShip() ){
                            $mOrder->setStatus('pending_nf')->save();
                        }else{
                            $mOrder->setStatus('complete_nf')->save();
                        }
                        
                        unlink($tmp_filename);
                        /**/

			if( Mage::getStoreConfig('indexa_nfe/email/status') ){
		                try{
		                    
		                      // send email
		                     
		                    $objEmail = new Varien_Object();
		                    $config = new Zend_Config_Xml( $xml_filename );

		                    $objEmail->setData('nf', $config->NFe->infNFe->ide->nNF );
		                    $objEmail->setData('mod', $config->NFe->infNFe->ide->mod );
		                    $objEmail->setData('cpf', $config->NFe->infNFe->dest->CPF );
		                    $objEmail->setData('serie', $config->NFe->infNFe->ide->serie );
		                    $objEmail->setData('chave', $config->protNFe->infProt->chNFe );

		                    
		                     // create email and attach files
		                     
		                    $sendMail = Mage::getModel('core/email_template');
		                    $sendMail->getMail()->createAttachment($pdf_content, 
		                                                            'application/pdf', 
		                                                            Zend_Mime::DISPOSITION_ATTACHMENT, 
		                                                            Zend_Mime::ENCODING_BASE64,
		                                                            basename( $pdf_filename )
		                                                            );
		                    $sendMail->getMail()->createAttachment($xml_content, 
		                                                            'text/xml', 
		                                                            Zend_Mime::DISPOSITION_ATTACHMENT, 
		                                                            Zend_Mime::ENCODING_BASE64,
		                                                            basename( $xml_filename )
		                                                            );
				     if( Mage::getStoreConfig('indexa_nfe/email/cc') ){
				     	 $sendMail->getMail()->addCc( Mage::getStoreConfig('indexa_nfe/email/cc') );
				     }
				     if( Mage::getStoreConfig('indexa_nfe/email/email') &&  Mage::getStoreConfig('indexa_nfe/email/nome') ){
				         $senderEmail =  array('name' => Mage::getStoreConfig('indexa_nfe/email/nome'), 'email' => Mage::getStoreConfig('indexa_nfe/email/email') );
				     }else{
				          $senderEmail =  'general';
				     }
		                     $sendMail->sendTransactional(
		                                                'indexa_nfe_email',
		                                                $senderEmail,
		                                                $mOrder->getCustomerEmail(),
		                                                $mOrder->getCustomerName(),
		                        array('nfe' => $objEmail));
		                    
		                    $sendMail->getSentSuccess();
		                    
		                }catch(Exception $e){
		                   
		                }     
			 }
                    }   
                }
                
            }
            if( 'REJECTED' == str_replace(PHP_EOL, '', $httpmessage[0]) ){
                 $mRequest->setData('status', Indexa_Nfe_Helper_Data::NFE_SHIPMENT_STATUS_ERROR);
                $mRequest->setData('messages', $httpmessage[1] );
                $mRequest->setData('finished_at', date('Y-m-d H:i:s'));
                /**
                
                 * change status order
                */
                 $mOrder->setStatus('error_nf')->save(); 
                
            }
            if( 'SEND_FAILED' == str_replace(PHP_EOL, '', $httpmessage[0]) ){
                $mRequest->setData('status', Indexa_Nfe_Helper_Data::NFE_SHIPMENT_STATUS_ERROR);
                $mRequest->setData('messages', $httpmessage[1] );
                $mRequest->setData('finished_at', date('Y-m-d H:i:s'));
                /**
                 * change status order
                 */
                $mOrder->setStatus('error_nf')->save();
            }
            
            Mage::getModel('indexa_nfe/sales_order_nf')->load( $mRequest->getNfeNfId() )->setStatus(Indexa_Nfe_Helper_Data::NFE_SHIPMENT_STATUS_FINISHED)->setFinishedAt(date('Y-m-d H:i:s'))->save();
            
            $mRequest->save();
        }
        
    }
    /**
     *  prepare customer data to make requests 
     * 
     * @param Mage_Sales_Model_Order $mOrder
     * 
     * @return array 
     */
    private function _prepareCustomerData($mOrder) {

        $aCustomerData['nfe.CPF'] = ( str_replace(array('.', '/', '-'), array('', '', ''), $mOrder->getCustomerTaxvat()) );
        $aCustomerData['nfe.xNome'] = $mOrder->getCustomerName();
        $aCustomerData['nfe.IE'] = '';

        $mShipping = $mOrder->getShippingAddress();
        
        $shippingStreet = $mShipping->getStreet();
        $aCustomerData['nfe.enderDest']['nfe.xLgr'] = (string)trim($shippingStreet[0]);
        $aCustomerData['nfe.enderDest']['nfe.nro'] = (string) trim($shippingStreet[1]);
        $aCustomerData['nfe.enderDest']['nfe.xBairro'] = trim($shippingStreet[3]);
        $aCustomerData['nfe.enderDest']['nfe.cMun'] = $mShipping->getCity();
        $aCustomerData['nfe.enderDest']['nfe.xMun'] = ( Mage::getModel('indexa_nfe/directory_country_region_city')->load( $mShipping->getCity() )->getName() );        
        $aCustomerData['nfe.enderDest']['nfe.UF'] = Mage::getModel('directory/region')->load($mShipping->getRegionId())->getCode();
        $aCustomerData['nfe.enderDest']['nfe.cPais'] = Mage::getModel('indexa_nfe/directory_country')->load($mShipping->getCountryId(), 'country_id')->getId();
        $aCustomerData['nfe.enderDest']['nfe.xPais'] = Mage::app()->getLocale()->getCountryTranslation($mShipping->getCountryId());
        $aCustomerData['nfe.enderDest']['nfe.CEP'] = str_replace('-', '', $mShipping->getPostcode());

        return $aCustomerData;
    }

    /**
     * prepare item information 
     * 
     * @param Mage_Sales_Model_Order_Shipment $mOrderShipment 
     */
    private function _prepareItems($mOrderShipment) {

        $key = 0;
        
        $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vBC'] = 0;
        $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vProd'] = 0;
        $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vICMS'] = 0;

        $mShipping = $mOrderShipment->getOrder()->getShippingAddress();
        
        /**
         * assign shipping values to items 
         */
        $nItems = count( $mOrderShipment->getOrder()->getAllItems() );
        if( $mOrderShipment->getOrder()->getShippingAmount() ){
           

            $vFrete = (string) number_format( $mOrderShipment->getOrder()->getShippingAmount() ,  2,'.', '' );
            $vFreteParcial = number_format( ($vFrete / $nItems), 2,'.', '' );

            for ( $i=0; $i < $nItems; $i++  ){
                $arrFreteParcial[$i] = $vFreteParcial;
            }

            if( ($vFreteParcial * $nItems) < $vFrete ){
                $arrFreteParcial[0] += ($vFrete - ($vFreteParcial * $nItems));
            }  

            if( ($vFreteParcial * $nItems) > $vFrete ){
                $arrFreteParcial[0] += (($vFreteParcial * $nItems) - $vFrete );
            }  
            /**
             * format elements
             */
            for ( $i=0; $i < $nItems; $i++  ){
                $arrFreteParcial[$i] = number_format( $arrFreteParcial[$i],  2,'.', '' );
            }
        }
        
        foreach ($mOrderShipment->getAllItems() as $_shipmentItem) {
            /**
             * load order item
             */
            $mOrderItem = Mage::getModel('sales/order_item')->load($_shipmentItem->getOrderItemId());
            
            $mProduct = Mage::getModel('catalog/product')->load($mOrderItem->getProductId());
            
            $cKey = $key;
            $aOrderItem[$cKey]['@nItem'] = ++$key;

            $aOrderItem[$cKey]['nfe.prod']['nfe.cProd'] = $_shipmentItem->getProductId();
            $aOrderItem[$cKey]['nfe.prod']['nfe.cEAN'] = '';
            $aOrderItem[$cKey]['nfe.prod']['nfe.cEANTrib'] ='';
            $aOrderItem[$cKey]['nfe.prod']['nfe.xProd'] = trim( $_shipmentItem->getName() );
            
            $productPrice = $_shipmentItem->getPrice();
            
            $dDescTotal = 0;
            if( $mOrderItem->getDiscountAmount() > 0 ){
                $dDescTotal = number_format( $mOrderItem->getDiscountAmount() * ( $_shipmentItem->getQty() / $mOrderItem->getQtyOrdered()  ),  2,'.', '' );
                $productPrice -= $dDescTotal/$_shipmentItem->getQty();
            }
            
            $diff = $mOrderShipment->getOrder()->getTotalPaid() - $mOrderShipment->getOrder()->getGrandTotal();
            $percent = $diff / $mOrderShipment->getOrder()->getGrandTotal();
                
            $productPrice = $productPrice * (1 + $percent);
            
            unset( $aOrderItem[$cKey]['nfe.prod']['nfe.vDesc'] );
            
            $aOrderItem[$cKey]['nfe.prod']['nfe.vProd'] = (string)number_format( $productPrice * $_shipmentItem->getQty(),  2,'.', '' );
          
            $aOrderItem[$cKey]['nfe.prod']['nfe.indTot'] = '1';

            $sCustomerUf = Mage::getModel('indexa_nfe/directory_country_region')->load($mShipping->getRegionId(), 'region_id')->getId();

            /**
             * check CFOP code
             */
            $aOrderItem[$cKey]['nfe.prod']['nfe.CFOP'] = ( $sCustomerUf == Mage::getStoreConfig('indexa_nfe/emit/cuf') ? '5102' : '6108' );
            $aOrderItem[$cKey]['nfe.prod']['nfe.NCM'] = (string) ( $_shipmentItem->getNfeNcm() ? $_shipmentItem->getNfeNcm() : $mProduct->getNfeNcm() );

            $aOrderItem[$cKey]['nfe.prod']['nfe.uCom'] = (string) ( $_shipmentItem->getNfeUcom() ? $_shipmentItem->getNfeUcom() : $mProduct->getNfeUcom() );
            $aOrderItem[$cKey]['nfe.prod']['nfe.qCom'] = (int)$_shipmentItem->getQty();
            $aOrderItem[$cKey]['nfe.prod']['nfe.vUnCom'] = (string)number_format($productPrice,  2,'.', '' );

            $aOrderItem[$cKey]['nfe.prod']['nfe.uTrib'] = (string) ( $_shipmentItem->getNfeUcom() ? $_shipmentItem->getNfeUcom() : $mProduct->getNfeUcom() );
            $aOrderItem[$cKey]['nfe.prod']['nfe.qTrib'] =  (int) ( $_shipmentItem->getQty() );
            $aOrderItem[$cKey]['nfe.prod']['nfe.vUnTrib'] = (string) number_format( $productPrice,  2,'.', '' );
            
            $vFrete = 0;
            
            if($arrFreteParcial[$cKey] > 0){
                    $vFrete = ( $arrFreteParcial[$cKey] * ( $_shipmentItem->getQty() / $mOrderItem->getQtyOrdered() ) ) * (1 + $percent);
                    $aOrderItem[$cKey]['nfe.prod']['nfe.vFrete'] = (string)number_format($vFrete,  2,'.', '' );
            }
           
            $vTotal = number_format( ( $productPrice * $_shipmentItem->getQty() ) ,  2,'.', '' );
            
            /**
             * ICMS 00
             */
            $aOrderItem[$cKey]['nfe.imposto']['nfe.ICMS']['nfe.ICMS00']['nfe.orig'] = (string) ( $_shipmentItem->getNfeOrig() ? $_shipmentItem->getNfeOrig() : '0' ) ;
            $aOrderItem[$cKey]['nfe.imposto']['nfe.ICMS']['nfe.ICMS00']['nfe.CST'] = '00';
            $aOrderItem[$cKey]['nfe.imposto']['nfe.ICMS']['nfe.ICMS00']['nfe.modBC'] = '0'; //a definir
            $aOrderItem[$cKey]['nfe.imposto']['nfe.ICMS']['nfe.ICMS00']['nfe.vBC'] = (string)number_format( $vTotal + $vFrete, 2,'.', '' );
            
            /**
             * ICMS fixed 18% 
             */
            $aOrderItem[$cKey]['nfe.imposto']['nfe.ICMS']['nfe.ICMS00']['nfe.pICMS'] = '18';
            $aOrderItem[$cKey]['nfe.imposto']['nfe.ICMS']['nfe.ICMS00']['nfe.vICMS'] = (string)number_format( ($vTotal + $vFrete) * 0.18,  2,'.', '' );

            
            /**
             * COFINS CST 01 - 7.60%
             */
            $pAliquotaCofins = '7.60';
            
            $aOrderItem[$cKey]['nfe.imposto']['nfe.COFINS']['nfe.COFINSAliq']['nfe.CST'] = '01';
            $aOrderItem[$cKey]['nfe.imposto']['nfe.COFINS']['nfe.COFINSAliq']['nfe.vBC'] = (string)number_format( $vTotal + $vFrete,2,'.', '' );
            $aOrderItem[$cKey]['nfe.imposto']['nfe.COFINS']['nfe.COFINSAliq']['nfe.pCOFINS'] = $pAliquotaCofins;
            $aOrderItem[$cKey]['nfe.imposto']['nfe.COFINS']['nfe.COFINSAliq']['nfe.vCOFINS'] = (string)number_format( ( $vTotal + $vFrete )* ($pAliquotaCofins / 100) , 2,'.', '' );
            
            /**
             * PIS CST 01 - 1.65%
             */
            $pAliquotaPis = '1.65';    
            $aOrderItem[$cKey]['nfe.imposto']['nfe.PIS']['nfe.PISAliq']['nfe.CST'] = '01';
            $aOrderItem[$cKey]['nfe.imposto']['nfe.PIS']['nfe.PISAliq']['nfe.vBC'] = (string)number_format( $vTotal + $vFrete,2,'.', '' );
            $aOrderItem[$cKey]['nfe.imposto']['nfe.PIS']['nfe.PISAliq']['nfe.pPIS'] = $pAliquotaPis;
            $aOrderItem[$cKey]['nfe.imposto']['nfe.PIS']['nfe.PISAliq']['nfe.vPIS'] = (string)number_format( ( $vTotal + $vFrete) * ($pAliquotaPis / 100) , 2,'.', '' );
            
            /**
             * sum items
             */
            $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vProd'] += $vTotal;
           
            $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vICMS'] += ($vTotal + $vFrete) * 0.18;
            $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vBC'] += $vTotal + $vFrete ;
            $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vNF'] += $vTotal + $vFrete;
           
            $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vPIS'] += ($vTotal + $vFrete ) * ($pAliquotaPis / 100);
            $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vCOFINS'] += ($vTotal + $vFrete) * ($pAliquotaCofins / 100);

            if($vFrete > 0){
                $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vFrete'] += $vFrete;
            }
            /*if( $dTotal ){
                $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vDesc'] += $dTotal;
            }*/
        }
        $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vProd'] = (string)number_format( $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vProd'],  2,'.', '' );
        $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vICMS'] = (string)number_format ( $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vICMS'],  2,'.', '' );
        $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vBC'] = (string)number_format( $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vBC'],  2,'.', '' );
        $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vNF'] =  (string)number_format( $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vNF'], 2,'.', '' );
       // if( $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vFrete'] )
        $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vFrete'] = (string)number_format( $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vFrete'], 2,'.', '' );
        
        $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vPIS'] = (string)number_format( $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vPIS'], 2,'.', '' );
        $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vCOFINS'] = (string)number_format( $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vCOFINS'], 2,'.', '' );

        $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vST'] = '0';
        $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vBCST'] = '0';
        $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vSeg'] = '0';
        $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vDesc'] = '0';
        $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vII'] = '0';
        $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vIPI'] = '0';
        $aOrderItem['nfe.total']['nfe.ICMSTot']['nfe.vOutro'] = '0';
        
        return $aOrderItem;
    }

    /**
     * prepare ide information
     */
    private function _prepareIdeData() {

        $aIdeData['nfe.cUF'] = Mage::getStoreConfig('indexa_nfe/config/cuf');
        $aIdeData['nfe.cNF'] = '10000001'; // rewrited on webservice ;
        $aIdeData['nfe.natOp'] = Mage::getStoreConfig('indexa_nfe/config/natop') == '1' ? 'Venda de Mercadorias' : '';
        $aIdeData['nfe.indPag'] = '0'; //$mOrder->getPayment()->getMethod(); // rewrited on webservice 
        $aIdeData['nfe.mod'] = Mage::getStoreConfig('indexa_nfe/config/mod');
        $aIdeData['nfe.serie'] = self::NFE_SERIE;
        $aIdeData['nfe.nNF'] = '1'; // rewrited on webservice 
        $aIdeData['nfe.dEmi'] = date('Y-m-d'); // data de emissao do documento fiscal
        $aIdeData['nfe.dSaiEnt'] = date('Y-m-d'); // data de saida ou entrada do produtogn
        $aIdeData['nfe.hSaiEnt'] = date('H:i:s'); // hora de saida ou entrada do produto
        $aIdeData['nfe.tpNF'] = Indexa_Nfe_Helper_Data::NFE_TPNF_SAIDA; // tipo da operação 0 - entrada, 1 - saida
        $aIdeData['nfe.cMunFG'] = Mage::getStoreConfig('indexa_nfe/config/cmunfg');
        $aIdeData['nfe.tpImp'] = Mage::getStoreConfig('indexa_nfe/config/tpimp'); // tipo da impressao 1 - retrato, 2 - paisagem
        $aIdeData['nfe.tpEmis'] = Indexa_Nfe_Helper_Data::NFE_TPEMIS_NORMAL; // tipo de emissao 
        $aIdeData['nfe.cDV'] = '1'; // send as null 
        $aIdeData['nfe.tpAmb'] = Mage::getStoreConfig('indexa_nfe/config/tpamb'); // tipo de emissao 
        $aIdeData['nfe.finNFe'] = Indexa_Nfe_Helper_Data::NFE_FINNFE_NORMAL; // numero da nota fiscal
        $aIdeData['nfe.procEmi'] = Indexa_Nfe_Helper_Data::NFE_PROCEMI_DEFAULT; // tipo de emissao
        $aIdeData['nfe.verProc'] = '1'; // tipo de emissao

        return $aIdeData;
    }

    /**
     *  prepare company data to make requests 
     * 
     * @return array 
     */
    private function _prepareEmitData() {

        $aEmitData['nfe.CNPJ'] = str_replace(array('.', '/', '-'), array('', '', ''), Mage::getStoreConfig('indexa_nfe/emit/cnpj'));
        $aEmitData['nfe.xNome'] = Mage::getStoreConfig('indexa_nfe/emit/nome');
        
        $aEmitData['nfe.enderEmit']['nfe.xLgr'] = Mage::getStoreConfig('indexa_nfe/emit/xlgr');
        $aEmitData['nfe.enderEmit']['nfe.nro'] = Mage::getStoreConfig('indexa_nfe/emit/numero');
        $aEmitData['nfe.enderEmit']['nfe.xBairro'] = Mage::getStoreConfig('indexa_nfe/emit/bairro');
        $aEmitData['nfe.enderEmit']['nfe.cMun'] = Mage::getStoreConfig('indexa_nfe/emit/cmun');
        $aEmitData['nfe.enderEmit']['nfe.xMun'] = ( Mage::getModel('indexa_nfe/directory_country_region_city')->load( Mage::getStoreConfig('indexa_nfe/emit/cmun') )->getName() );
	$aEmitData['nfe.enderEmit']['nfe.fone'] = (string) Mage::getStoreConfig('indexa_nfe/emit/fone') ? Mage::getStoreConfig('indexa_nfe/emit/fone'): '1130643003' ;

        $aEmitData['nfe.enderEmit']['nfe.UF'] = Mage::getModel('directory/region')->load( Mage::getModel('indexa_nfe/directory_country_region')->load( Mage::getStoreConfig('indexa_nfe/emit/cuf') )->getRegionId() )->getCode();
        $aEmitData['nfe.enderEmit']['nfe.CEP'] = Mage::getStoreConfig('indexa_nfe/emit/cep');
        $aEmitData['nfe.enderEmit']['nfe.cPais'] = Mage::getStoreConfig('indexa_nfe/emit/cpais');
        $aEmitData['nfe.enderEmit']['nfe.xPais'] = Mage::app()->getLocale()->getCountryTranslation(Mage::getModel('indexa_nfe/directory_country')->load(Mage::getStoreConfig('indexa_nfe/emit/cpais'))->getCountryId());
        
        $aEmitData['nfe.IE'] = (string)Mage::getStoreConfig('indexa_nfe/emit/ie');        
        $aEmitData['nfe.CRT'] = (string)Mage::getStoreConfig('indexa_nfe/emit/crt');

        return $aEmitData;
    }
    
}