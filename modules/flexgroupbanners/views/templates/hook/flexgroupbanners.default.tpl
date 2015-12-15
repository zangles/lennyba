{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('flexgroupbanners.default.tpl','flexgroupbanners')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}
    <div class="banner-group {$custom_class} clearfix">
    
    	{if $display_name == '1'}<h3 class="module-name">{$module_name}</h3>{/if}	
    
    	{if isset($rowContents) && $rowContents|@count >0}
    
    		<div class="flexgroupbanners-rows">	
    
    		{foreach from=$rowContents item=row name=rows}
    
    			<div class="flexgroupbanners-row {$row.custom_class} {if $row.width >0}col-sm-{$row.width}{/if} clearfix">
    
    				{if $row.display_title == "1"}<h3 class="row-title"><span>{$row.name}</span></h3>{/if}
    
    				{if isset($row.groups) && $row.groups|@count >0}
    
    				{assign var='totalwidth' value=0}
    
    				<div class="flexgroupbanners-groups clearfix">					
    
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
    
    			            <!-- group banners -->                                                        
    
                            <div class="flexgroupbanners-group {if $group.width >0} col-sm-{$group.width} {else} clearfix {/if}">
                                
                                <div class="{$group.custom_class}">                            
                                {if isset($group.items) && $group.items|@count >0}
    
                                    <!-- banner items -->
    
                                    <div class="flexgroupbanners-banners">
    
                                        {foreach from=$group.items item=banneritem name=banneritems}
    
    										<div class="banner-item {$banneritem.custom_class}">
    
    											{if $banneritem.full_path}
    
    								                <a href="{$banneritem.link}" target="_blank" title="{$banneritem.alt}">
    
    								                	<img class="img-responsive" src="{$banneritem.full_path}" alt="{$banneritem.alt}" />
    
    								                </a>
    
    							                {/if}
    
    							                {if $banneritem.description}
    
    							                <div class="flex-banner-description">{$banneritem.description}</div>
    
    							                {/if}
    
    							            </div> 
    
                                        {/foreach}
    
                                    </div>
    
                                    <!-- end banner item -->
    
                                {/if}  
                                </div>
    
                            </div>
    
                            <!-- end group banners -->
    
    					{/foreach}								
    
    				</div>
    
    				{/if}			
    
    			</div>	
    
    		{/foreach}
    
    		</div>	
    
    	{/if}
    
    	
    
    </div>
{/if}








