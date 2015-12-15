{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('multistyle.tpl','oviclayoutcontrol')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}
    {if isset($font) && $font|count>0}
        {foreach $font as $f}
            {$f.linkfont|html_entity_decode}
        {/foreach}    
    {/if}
    <style type="text/css">
    	/*
    	 * color-background-border
    	 * 1:use
    	 * 0:no use
    	 */   	
        /***  Font default ***/
        .mainFont{ldelim}
            font-family:{$font[0].fontname}!important;
        {rdelim}
       /*============button============*/
        .button_111
       	{ldelim}
            color:{$color.button_text} !important;;
            background-color:{$color.button} !important;;
            border-color:{$color.button} !important;;
        {rdelim}
        .button_111:hover,
        .button_111_hover:hover,
        .filter-box .label_radio.checked, 
        .filter-box .label_radio:hover
       	{ldelim}
            color:{$color.button_text_hover} !important;;
            background-color:{$color.button_hover} !important;;
            border-color:{$color.button_hover} !important;;
        {rdelim}
         .button_110
       	{ldelim}
            color:{$color.button_text} !important;;
            background-color:{$color.button} !important;;            
        {rdelim}
        .button_110:hover
        .button_110_hover:hover
       	{ldelim}
            color:{$color.button_text_hover} !important;;
            background-color:{$color.button_hover} !important;;
        {rdelim}        
        .button_101
       	{ldelim}
            color:{$color.button_text} !important;;            
            border-color:{$color.button} !important;;
        {rdelim}
        .button_101:hover,
        .button_101_hover:hover
       	{ldelim}
            color:{$color.button_text_hover} !important;;
            border-color:{$color.button_hover} !important;;
        {rdelim}        
        .button_100
       	{ldelim}
            color:{$color.button_text} !important;;            
        {rdelim}
        .button_100:hover,
        .button_100_hover:hover
       	{ldelim}
            color:{$color.button_text_hover} !important;;            
        {rdelim}
        .button_011
       	{ldelim}
            background-color:{$color.button} !important;;
            border-color:{$color.button} !important;;
        {rdelim}
        .button_011:hover,
        .button_011_hover:hover
       	{ldelim}            
            background-color:{$color.button_hover} !important;;
            border-color:{$color.button_hover} !important;;
        {rdelim}
        .button_010
       	{ldelim}            
            background-color:{$color.button} !important;;            
        {rdelim}
        .button_010:hover,
        .button_010_hover:hover
       	{ldelim}            
            background-color:{$color.button_hover} !important;;            
        {rdelim}
        .button_001
       	{ldelim}
            border-color:{$color.button} !important;;
        {rdelim}
        .button_001:hover,
        .button_001_hover:hover
       	{ldelim}
            border-color:{$color.button_hover} !important;;
        {rdelim}
        /*============button2============*/
        .second_button_111
       	{ldelim}
            color:{$color.second_button_text} !important;;
            background-color:{$color.second_button} !important;;
            border-color:{$color.second_button} !important;;
        {rdelim}
        .second_button_111:hover,
        .second_button_111_hover:hover,
        .second_button_111_hover.checked,
        .second_button_111_hover.active        
       	{ldelim}
            color:{$color.second_button_text_hover} !important;;
            background-color:{$color.second_button_hover} !important;;
            border-color:{$color.second_button_hover} !important;;
        {rdelim}
         .second_button_110
       	{ldelim}
            color:{$color.second_button_text} !important;;
            background-color:{$color.second_button} !important;;            
        {rdelim}
        .second_button_110:hover
        .second_button_110_hover:hover
       	{ldelim}
            color:{$color.second_button_text_hover} !important;;
            background-color:{$color.second_button_hover} !important;;
        {rdelim}        
        .second_button_101
       	{ldelim}
            color:{$color.second_button_text} !important;;            
            border-color:{$color.second_button} !important;;
        {rdelim}
        .second_button_101:hover,
        .second_button_101_hover:hover
       	{ldelim}
            color:{$color.second_button_text_hover} !important;;
            border-color:{$color.second_button_hover} !important;;
        {rdelim}        
        .second_button_100
       	{ldelim}
            color:{$color.second_button_text} !important;;            
        {rdelim}
        .second_button_100:hover,
        .second_button_100_hover:hover
       	{ldelim}
            color:{$color.second_button_text_hover} !important;;            
        {rdelim}
        .second_button_011
       	{ldelim}
            background-color:{$color.second_button} !important;;
            border-color:{$color.second_button} !important;;
        {rdelim}
        .second_button_011:hover,
        .second_button_011_hover:hover
       	{ldelim}            
            background-color:{$color.second_button_hover} !important;;
            border-color:{$color.second_button_hover} !important;;
        {rdelim}
        .second_button_010
       	{ldelim}            
            background-color:{$color.second_button} !important;;            
        {rdelim}
        .second_button_010:hover,
        .second_button_010_hover:hover
       	{ldelim}            
            background-color:{$color.second_button_hover} !important;;            
        {rdelim}
        .second_button_001
       	{ldelim}
            border-color:{$color.second_button} !important;;
        {rdelim}
        .second_button_001:hover,
        .second_button_001_hover:hover
       	{ldelim}
            border-color:{$color.second_button_hover} !important;;
        {rdelim}
    </style>
{/if}    