<div class="md-margin2x half hidden-xs"></div>
<div class="sm-margin visible-xs"></div>
<div class="banner-group">
	<div class="container">
		
		
	
			{if isset($rowContents) && $rowContents|@count >0}		
				{foreach from=$rowContents item=row name=rows}
					<div class="row">
						<div class="{$row.custom_class} {if $row.width >0}col-md-{$row.width} {else} col-md-12 {/if} clearfix">
							{if $row.display_title == "1"}<h3 class="row-title"><span>{$row.name}</span></h3>{/if}
							{if isset($row.groups) && $row.groups|@count >0}
							{assign var='totalwidth' value=0}
							<div class="flexgroupbanners-groups row clearfix">					
								{foreach from=$row.groups item=group name=groups}
									{if $group.width == 0}
										<div class="clearfix"></div>
										{assign var='totalwidth' value=0}
									{else}
										{assign var='totalwidth' value=$totalwidth+$group.width}            
							            {if $totalwidth>12 && !$smarty.foreach.groups.last}
							                <div class="clearfix"></div>                
							                {assign var='totalwidth' value=0}            
							            {/if}
									{/if}						                                                 
			                        <div class="{if $group.width >0} col-md-{$group.width} {else} col-md-12 {/if}">	                                      
			                            <div class="{$group.custom_class}">
			                            {if isset($group.items) && $group.items|@count >0}
			                                <div class="flexgroupbanners-banners {if $group.items|@count >1} mul-item {/if}">
			                                    {foreach from=$group.items item=banneritem name=banneritems}
													<div class="banner {$banneritem.custom_class}">                                            			                                            
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
			                                </div>
			                            {/if}
			                            </div> 
			                        </div>
								{/foreach}								
							</div>
							{/if}			
						</div>
					</div>			
				{/foreach}
			{/if}
		
		
		
				
	</div>	
</div>
