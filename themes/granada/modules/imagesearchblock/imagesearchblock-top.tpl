{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('imagesearchblock-top.tpl','imagesearchblock')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}
    <div class="search-container pull-left">
		<form action="{$link->getPageLink('search')}" id="searchbox" class="search-form">
			<input type="hidden" name="controller" value="search" />
			<input type="hidden" name="orderby" value="position" />
			<input type="hidden" name="orderway" value="desc" />
			<input type="search" id="search_query_top" name="search_query" placeholder="{l s='Buscar' mod='imagesearchblock'}" style="border: 0px; font-size: 15px; color: white;" />
			<input type="submit" value="Submit" class="search-submit-btn">		
		</form>
	</div>
    {include file="$self/imagesearchblock-instantsearch.tpl"}
{/if}

