{*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<li class="{if isset($first) && $first  == true}open{/if}">
	<a href="{$node.link|escape:'html':'UTF-8'}" title="{$node.desc|strip_tags|trim|escape:'html':'UTF-8'}">{$node.name|escape:'html':'UTF-8'} {if isset($node.children) && $node.children|@count >0}<span class="category-widget-btn"></span>{/if}</a>       
   <ul>
   	{foreach from=$node.children item=child name=categoryTreeBranch}
        {if $smarty.foreach.categoryTreeBranch.first}
			{include file="$branche_tpl_path" node=$child first='true' level=$level+1}
		{elseif $smarty.foreach.categoryTreeBranch.last}
			{include file="$branche_tpl_path" node=$child first='false' last='true' level=$level+1}
		{else}
			{include file="$branche_tpl_path" node=$child first='false' last='false' level=$level+1}
		{/if}
	{/foreach}	
   </ul>
</li>
