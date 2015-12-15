{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('megaboxs.default.group.products.tpl','megaboxs')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}
	{if $megaboxs_group_products && $megaboxs_group_products|@count >0}
		<div class="col-md-{$megaboxs_group_width} {$megaboxs_group_custom_class}">
			{if $megaboxs_group_display_title == '1'}<h4>{$megaboxs_group_name}</h4>{/if}		
			<div class="owl-carousel footer-toprated-slider">
				{include file="$tpl_dir./group-product-carousel-style1.tpl" products=$megaboxs_group_products group_count=2 view_rate_total=1}
			</div>	
		</div>
	{/if}
{/if}
