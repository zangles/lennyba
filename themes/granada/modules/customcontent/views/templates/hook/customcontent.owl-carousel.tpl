{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('customcontent.owl-carousel.tpl','customcontent')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}	
	{if isset($module_items) && $module_items|@count >0}	
		{$module_before}
		<div class="container {$module_custom_class}" style=" {if $module_background != ''} background-image: url({$module_background});{/if}">
			<div class="carousel-container">
				
				{if $module_display_name == '1'}
					<h3 class="small-title text-center">{$module_name}</h3>					
				{/if}	
				<div class="row">
					<div class="owl-carousel team-member-carousel center-buttons">
						<div class="member-col">
						{foreach from=$module_items item=mitem name=items}
							<div class="member">
								{$mitem.before}
                                 <figure><img src="{$mitem.full_path}" alt="{$mitem.name}" class="img-responsive"></figure>
                                 <div class="member-content">
									{$mitem.content}
                                 </div>
                                 {$mitem.after}
                              </div>
                              {if ($smarty.foreach.items.index % 2 == 1) && !$smarty.foreach.items.last} 
								</div>
								<div class="member-col"> 
							{/if}	        
					    {/foreach}
						</div>						
					</div>
				</div>
			</div>			
		</div>	
		{$module_after}
	{/if}
{/if}
