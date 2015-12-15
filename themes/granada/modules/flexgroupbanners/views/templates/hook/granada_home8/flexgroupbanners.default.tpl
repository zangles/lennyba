<div class="{$custom_class}">
	{if $display_name == '1'}<h3 class="module-name">{$module_name}</h3>{/if}	
	{if isset($rowContents) && $rowContents|@count >0}		
		{foreach from=$rowContents item=row name=rows}			
				<div class="{$row.custom_class} {if $row.width >0}col-md-{$row.width}{/if} clearfix">
					{if $row.display_title == "1"}<h3 class="row-title"><span>{$row.name}</span></h3>{/if}
					{if isset($row.groups) && $row.groups|@count >0}
					{assign var='totalwidth' value=0}
						{foreach from=$row.groups item=group name=groups}
													                                                 
	                        <div class="{$group.custom_class} {if $group.width >0} col-md-{$group.width}{/if}">	                                      
                            {if isset($group.items) && $group.items|@count >0}                                
                                {foreach from=$group.items item=banneritem name=banneritems}
									<div class="{$banneritem.custom_class}">                                                                                        
                                        {if $banneritem.full_path}
							                <a href="{$banneritem.link}" target="_blank" title="{$banneritem.alt}">
							                	<img class="img-responsive" src="{$banneritem.full_path}" alt="{$banneritem.alt}" />
							                </a>
						                {/if}
						                {if $banneritem.description}
						                	{$banneritem.description}
						                {/if}
						            </div> 
                                {/foreach}                                
                            {/if}
	                        </div>
						{/foreach}								
					
					{/if}			
				</div>
					
		{/foreach}
	{/if}
</div>