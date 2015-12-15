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


{capture name=path}
	<li><a href="{$base_dir}" title="{l s='Home'}">{l s='Home'}</a></li>
	<li class="active">{l s='Error 404'}</li>
{/capture}
<section id="content" class="no-content parallax" style="background-image:url({$img_dir}img-404.jpg)" data-stellar-background-ratio="0.4"  role="main">
	{include file="$tpl_dir./breadcrumb.tpl"}
	<div class="vcenter-container">
	   <div class="vcenter">
	      <div class="container">
	         <div class="row">
	            <div class="col-sm-8 col-sm-push-2 col-md-8 col-md-push-2 col-lg-6 col-lg-push-3 text-center">
	               <h3>{l s='404 error'}</h3>
	               <h2>{l s='This page cannot be found'}</h2>
	               <p>{l s='Sorry, the page you are looking for is not available. Maybe you want to perform a search?'}</p>
	               <form action="{$link->getPageLink('search')|escape:'html':'UTF-8'}" method="post" class="std">
	                  <div class="form-group">
	                  	<input id="search_query" name="search_query" type="text" class="form-control input-lg" placeholder="search">
	                  	<!-- <input id="search_query" name="search_query" type="text" class="form-control grey" /> --> 
	                  	<button type="submit" name="Submit" value="OK" class="submit-btn">{l s='Search'}</button>
	                  </div>
	               </form>
	            </div>
	         </div>
	      </div>
	   </div>
	</div>	
</section>
