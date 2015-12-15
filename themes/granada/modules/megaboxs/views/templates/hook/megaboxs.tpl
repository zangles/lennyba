{if isset($megaboxs) && $megaboxs|@count >0}
    {foreach from=$megaboxs item=module name=modules}                       
        {$module.content}
    {/foreach}    
{/if}
{addJsDef secure_key=$secure_key}
{addJsDef shop_name=$shop_name}
{addJsDef defaultLat=$defaultLat}
{addJsDef defaultLong=$defaultLong}
{addJsDef distance_unit=$distanceUnit}
{addJsDef searchUrl=$searchUrl}
{addJsDef logo_store=$logo_store}
{addJsDef tpl_uri=$tpl_uri}
{addJsDef megaboxsUrl=$megaboxsUrl}
{addJsDef megaboxsImageUrl=$megaboxsImageUrl}

{addJsDef megaboxsUrlAjax=$megaboxsUrlAjax}
{addJsDef hasStoreIcon=$hasStoreIcon}
{addJsDef img_store_dir=$img_store_dir}
{addJsDef img_ps_dir=$img_ps_dir}
{addJsDef megaboxMap=''}
{addJsDef markers=array()}
{addJsDef infoWindow=''}

{addJsDefL name=translation_1}{l s='No stores were found. Please try selecting a wider radius.' mod='megaboxs' js=1}{/addJsDefL}
{addJsDefL name=translation_2}{l s='store found -- see details:' mod='megaboxs' js=1}{/addJsDefL}
{addJsDefL name=translation_3}{l s='stores found -- view all results:' mod='megaboxs' js=1}{/addJsDefL}
{addJsDefL name=translation_4}{l s='Phone:' mod='megaboxs' js=1}{/addJsDefL}
{addJsDefL name=translation_5}{l s='Get directions' mod='megaboxs' js=1}{/addJsDefL}
{addJsDefL name=translation_6}{l s='Not found' mod='megaboxs' js=1}{/addJsDefL}
