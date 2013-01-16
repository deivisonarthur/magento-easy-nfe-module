/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    design
 * @package     default_default
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */
var EasynfeNfe = new Class.create();
EasynfeNfe.prototype = {
    initialize : function( elementUf, elementMun, url, afterLoad, afterLoadFunction ){
        
        if( !url )
            url = '/nfe/ajax/load';
        
        this.munfg                 = elementMun;
        this.uf                    = elementUf;   
        this.loadAction            = url;   
        this.afterLoad             = afterLoad; 
        this.afterLoadFunction     = afterLoadFunction;
        
        if( elementUf != null && elementUf.value > 0 ){
            this.updateData();
        }
    },
    clearData : function() {
        var element = this.munfg;
        element.innerHTML = "";
    },
    updateData: function() {
        var url  = this.loadAction + '/uf/' + this.uf.value;
        
        new Ajax.Request(url, {
            method:'get',
            requestHeaders: {Accept: 'application/json'},
            onSuccess: function(transport) {
                try{
                    var responseJson = eval('('+ transport.responseText.toJSON() +')');                
                }catch ( e ){
                    var responseJson = eval( transport.responseText );
                }
              
                if( 'object' != typeof responseJson[0] ){
                    try{
                        var responseJson = eval( transport.responseText );           
                    }catch ( e ){
                    }
                }            
                
                if (responseJson) {
                    this.clearData();
                    munElement = this.munfg;
                    responseJson.each( function( item ) {
                        if( item.selected ){
                            munElement.options[munElement.options.length] = 
                                new Option(item.label, item.value, false, true);
                        }else{
                            munElement.options[munElement.options.length] = 
                                new Option(item.label, item.value, false);
                        }
                    }, munElement);
                    if( this.afterLoad ){
                        this.afterLoadFunction();
                    }
                    
                } 
            
            }.bind(this)
        });
    }    
}
       