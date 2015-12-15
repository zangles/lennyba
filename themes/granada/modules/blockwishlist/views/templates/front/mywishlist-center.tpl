{if $id_customer|intval neq 0}
	<form method="post" class="std box" id="form_wishlist">		
		<h2 class="color2">{l s='New wishlist' mod='blockwishlist'}</h2>
		<div class="row">
			<div class="col-sm-6 padding-right-md">
				<div class="form-group">
					<input type="hidden" name="token" value="{$token|escape:'html':'UTF-8'}" />
					<input type="text" id="name" name="name" placeholder="Wishlist name" class="inputTxt form-control input-lg" value="{if isset($smarty.post.name) and $errors|@count > 0}{$smarty.post.name|escape:'html':'UTF-8'}{/if}" />
				</div>
				<button id="submitWishlist" class="btn btn-lg btn-custom-5" type="submit" name="submitWishlist"><span>{l s='Save new wishlist' mod='blockwishlist'}<i class="icon-chevron-right right"></i></span></button>		
			</div>            
		</div>				
	</form>
	<div class="xlg-margin"></div>
	{if $wishlists}
		<div id="block-history" class="block-center">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th class="first_item">{l s='Name' mod='blockwishlist'}</th>
						<th class="item mywishlist_first">{l s='Qty' mod='blockwishlist'}</th>
						<th class="item mywishlist_first">{l s='Viewed' mod='blockwishlist'}</th>
						<th class="item mywishlist_second">{l s='Created' mod='blockwishlist'}</th>
						<th class="item mywishlist_second">{l s='Direct Link' mod='blockwishlist'}</th>
						<th class="last_item mywishlist_first">{l s='Delete' mod='blockwishlist'}</th>
					</tr>
				</thead>
				<tbody>
					{section name=i loop=$wishlists}
						<tr id="wishlist_{$wishlists[i].id_wishlist|intval}">
							<td style="width:200px;">
								<a href="javascript:;" onclick="javascript:WishlistManage('block-order-detail', '{$wishlists[i].id_wishlist|intval}');">
									{$wishlists[i].name|truncate:30:'...'|escape:'html':'UTF-8'}
								</a>
							</td>
							<td class="bold align_center">
								{assign var=n value=0}
								{foreach from=$nbProducts item=nb name=i}
									{if $nb.id_wishlist eq $wishlists[i].id_wishlist}
										{assign var=n value=$nb.nbProducts|intval}
									{/if}
								{/foreach}
								{if $n}
									{$n|intval}
								{else}
									0
								{/if}
							</td>
							<td>{$wishlists[i].counter|intval}</td>
							<td>{$wishlists[i].date_add|date_format:"%Y-%m-%d"}</td>
							<td>
								<a  href="javascript:;"  onclick="javascript:WishlistManage('block-order-detail', '{$wishlists[i].id_wishlist|intval}');">
									{l s='View' mod='blockwishlist'}
								</a>
							</td>
							<td class="wishlist_delete">
								<a class="close-button" href="javascript:;" onclick="return (WishlistDelete('wishlist_{$wishlists[i].id_wishlist|intval}', '{$wishlists[i].id_wishlist|intval}', '{l s='Do you really want to delete this wishlist ?' mod='blockwishlist' js=1}'));"><i class="icon-remove"></i></a>
							</td>
						</tr>
					{/section}
				</tbody>
			</table>
		</div>
		<div id="block-order-detail">&nbsp;</div>
		{/if}
	{/if}
	<div class="xs-margin"></div>
	<div class="footer_links clearfix text-center">	
		<a class="btn btn-default button button-small button_111_hover" href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}"><span><i class="icon-chevron-left"></i>{l s='Back to Your Account' mod='blockwishlist'}</span></a>	
		<a class="btn btn-default button button-small button_111_hover" href="{$base_dir|escape:'html':'UTF-8'}"><span><i class="icon-chevron-left"></i>{l s='Home' mod='blockwishlist'}</span></a>
	</div>