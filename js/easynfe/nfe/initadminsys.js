Event.observe(window, 'load', function() {
   new EasynfeNfe( $('easynfe_nfe_config_cuf'), $('easynfe_nfe_config_cmunfg'), '/nfe/ajax/load/filter/config-cmunfg' );
    /**
     * add onchage action
     */  
   Event.observe( $('easynfe_nfe_config_cuf') , 'change', function() {
       new EasynfeNfe(  $('easynfe_nfe_config_cuf'), $('easynfe_nfe_config_cmunfg') );
    });
    
  
   new EasynfeNfe( $('easynfe_nfe_emit_cuf'), $('easynfe_nfe_emit_cmun'), '/nfe/ajax/load/filter/emit-cmun' );
    /**
     * add onchage action
     */  
   Event.observe( $('easynfe_nfe_emit_cuf') , 'change', function() {
       new EasynfeNfe(  $('easynfe_nfe_emit_cuf'), $('easynfe_nfe_emit_cmun') );
    });

/*
   Event.observe( $('easynfe_nfe_emit_cep') , 'blur', function() {
       new EasynfeNfeCep($('easynfe_nfe_emit_cep'), $('easynfe_nfe_emit_xlgr'), $('easynfe_nfe_emit_bairro'), $('easynfe_nfe_emit_numero'));
    });
*/
});