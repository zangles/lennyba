{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('tplfile.tpl','module_name')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}