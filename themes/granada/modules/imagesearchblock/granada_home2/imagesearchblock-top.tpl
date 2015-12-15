
<div class="search-container">
	<form method="get" action="{$link->getPageLink('search')}" id="searchbox" class="search-form">
		<input type="hidden" name="controller" value="search" />
		<input type="hidden" name="orderby" value="position" />
		<input type="hidden" name="orderway" value="desc" />		  
	   	<input id="search_query_top" type="search" name="search_query" class="s" placeholder="{l s='Search' mod='imagesearchblock'}"> 
	   	<a href="#" title="Close Search" class="search-close-btn"></a> 
	   	<input type="submit" value="Submit" class="search-submit-btn">
   	</form>
</div>
<a href="#" class="header-search-btn" title="Search"><span class="hidden-sm hidden-xs">{l s='Search' mod='imagesearchblock'}</span></a>
{include file="$self/imagesearchblock-instantsearch.tpl"}