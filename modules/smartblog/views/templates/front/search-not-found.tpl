<div id="pagenotfound" class="row">
	<div class="center_column col-xs-12 col-sm-12" id="center_column">
		<div class="pagenotfound">
			<h2 class="color2">{l s="Sorry, but nothing matched your search terms." mod="smartblog"}</h2>
			<p>{l s="Please try again with some different keywords." mod="smartblog"}</p>
			<form class="std" method="post" action="{smartblog::GetSmartBlogLink('smartblog_search')}">
				<div>				
					<input type="hidden" value="0" name="smartblogaction">
					<input type="text" class="form-control grey" value="{$smartsearch}" name="smartsearch" id="search_query">
					<button class="btn btn-default button button-small button_111_hover" value="OK" name="smartblogsubmit" type="submit"><span>{l s="Search" mod="smartblog"}</span></button>
				</div>
			</form>			
		</div>
	</div>
</div>