{if isset($module_items) && $module_items|@count >0}	
	{$module_before}
	<div class="container {$module_custom_class}" style=" {if $module_background != ''} background-image: url({$module_background});{/if}">
		<div class="row">
			{if $module_display_name == '1'}
				<h2 class="light-title">{$module_name}</h2>
			{/if}	
			{foreach from=$module_items item=mitem name=items}
				{$mitem.before}
				<div class="col-md-{$mitem.width} {$mitem.custom_class}">
					<div class="feature-box feature-box-inline clearfix">
						{if $mitem.icon_type == 'class'}
			   				<span class="{$mitem.full_path}"></span>
			   			{else}
			   				{if $mitem.full_path != ''}
			   					<img src="{$mitem.full_path}" alt="{$mitem.name}" />
			   				{/if}               			
			   			{/if}				
						<div class="feature-content">
							<h3>
								{if $mitem.link != '' && $mitem.link != '#'}
									<a href="{$mitem.link}" title="{$mitem.name}">{$mitem.name}</a>
								{else}
									{$mitem.name}
								{/if}						
							</h3>
							{$mitem.content}
						</div>	
					</div>
					
				</div>
				{$mitem.after}	        
		    {/foreach}
		</div>	
	</div>
	{$module_after}
{/if}
