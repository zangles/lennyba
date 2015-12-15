{if isset($rowContents) && $rowContents|@count >0}
	<div class="{$custom_class} clearfix">
		{foreach from=$rowContents item=row name=rows}
			<div class="{$row.custom_class}">
				{if $row.display_title == "1"}<h3 class="row-title"><span>{$row.name}</span></h3>{/if}
				{if isset($row.groups) && $row.groups|@count >0}
					{assign var='totalwidth' value=0}					
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
                        <div class="{$group.custom_class} {if $group.width >0} col-md-{$group.width} {else} col-dm-12 {/if}">                            
                            {if isset($group.items) && $group.items|@count >0}                               
                                {foreach from=$group.items item=banneritem name=banneritems}
									<div class="item">
										<div class="item-bg {$banneritem.custom_class}">                                            			                                            
	                                        {if $banneritem.full_path}							                
								                <img class="img-responsive" src="{$banneritem.full_path}" alt="{$banneritem.alt}" />							                
							                {/if}			                                            										
							                {if $banneritem.description}
							                	{$banneritem.description}
							                {/if}
							            </div>
									</div> 
                                {/foreach}                            
                            {/if}                            
                        </div>
					{/foreach}								
				{/if}			
			</div>		
		{/foreach}		
	</div>
	<div class="lg-margin2x"></div>
				
{/if}
