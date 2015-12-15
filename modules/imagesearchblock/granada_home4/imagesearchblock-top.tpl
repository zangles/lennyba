<div class="search-container">
	<form method="get" action="{$link->getPageLink('search')}" id="searchbox" class="search-form">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<input type="hidden" name="controller" value="search" />
					<input type="hidden" name="orderby" value="position" />
					<input type="hidden" name="orderway" value="desc" />		  
				   	<input id="search_query_top" type="search" name="search_query" class="s" placeholder="{l s='Search entry site here...' mod='imagesearchblock'}"> 
				   	<a href="#" title="Close Search" class="search-close-btn"></a> 
				   	<input type="submit" value="Submit" class="search-submit-btn">								
				</div>				
			</div>
		</div>
		
   	</form>
</div>
{include file="$self/imagesearchblock-instantsearch.tpl"}