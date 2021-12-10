jQuery(document).ready(function($){

    $('#sub-accordion-section-header_settings').on( 'click', '.header_layout_text', function(e){
        e.preventDefault();
        wp.customize.control( 'header_menu_layout' ).focus();        
    });

    $('#sub-accordion-section-header_layout_section').on( 'click', '.header_settings_text', function(e){
        e.preventDefault();
        wp.customize.control( 'ed_header_search' ).focus();        
    });

});