Event.observe(window, 'load', function() {
   new IndexaNfe( $('indexa_nfe_config_cuf'), $('indexa_nfe_config_cmunfg'), '/nfe/ajax/load/filter/config-cmunfg' );
    /**
     * add onchage action
     */  
   Event.observe( $('indexa_nfe_config_cuf') , 'change', function() {
       new IndexaNfe(  $('indexa_nfe_config_cuf'), $('indexa_nfe_config_cmunfg') );
    });
    
  
   new IndexaNfe( $('indexa_nfe_emit_cuf'), $('indexa_nfe_emit_cmun'), '/nfe/ajax/load/filter/emit-cmun' );
    /**
     * add onchage action
     */  
   Event.observe( $('indexa_nfe_emit_cuf') , 'change', function() {
       new IndexaNfe(  $('indexa_nfe_emit_cuf'), $('indexa_nfe_emit_cmun') );
    });

/*
   Event.observe( $('indexa_nfe_emit_cep') , 'blur', function() {
       new IndexaNfeCep($('indexa_nfe_emit_cep'), $('indexa_nfe_emit_xlgr'), $('indexa_nfe_emit_bairro'), $('indexa_nfe_emit_numero'));
    });
*/
});