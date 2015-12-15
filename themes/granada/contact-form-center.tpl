<div class="row clearfix">
    <div class="col-sm-7 padding-right-larger">
        <div id="map"></div>    
    </div>
	<div class="col-sm-5 contact-container">
        {if isset($confirmation)}
        	<p class="alert alert-success">{l s='Your message has been successfully sent to our team.'}</p>
        	<ul class="footer_links clearfix">
        		<li>
                    <a class="btn btn-default button button-small" href="{$base_dir}">
                        <span>
                            <i class="icon-chevron-left"></i>{l s='Home'}
                        </span>
                    </a>
                </li>
        	</ul>
        {elseif isset($alreadySent)}
        	<p class="alert alert-warning">{l s='Your message has already been sent.'}</p>
        	<ul class="footer_links clearfix">
        		<li>
                    <a class="btn btn-default button button-small" href="{$base_dir}">
                        <span>
                            <i class="icon-chevron-left"></i>{l s='Home'}
                        </span>
                    </a>
                </li>
        	</ul>
        {else}
        	{include file="$tpl_dir./errors.tpl"}
             <div class="clearfix">                
            	<form action="{$request_uri|escape:'html':'UTF-8'}" method="post" class="contact-form-box" enctype="multipart/form-data">
            		<fieldset>
                    	<h2 class="page-subheading">{l s='Write Your Review'}</h2>
	                    <div class="form-group selector1 large-selectbox">
	                    	<label for="id_contact" class="form-label">{l s='Subject Heading'}</label>
		                    {if isset($customerThread.id_contact)}
	                            {foreach from=$contacts item=contact}
	                                {if $contact.id_contact == $customerThread.id_contact}
	                                    <input type="text" class="form-control input-lg" id="contact_name" name="contact_name" value="{$contact.name|escape:'html':'UTF-8'}" readonly="readonly" />
	                                    <input type="hidden" name="id_contact" value="{$contact.id_contact}" />
	                                {/if}
	                            {/foreach}
		                    {else}
		                        <select id="id_contact" class="selectbox" name="id_contact">
		                            <option value="0">{l s='-- Choose --'}</option>
		                            {foreach from=$contacts item=contact}
		                                <option value="{$contact.id_contact|intval}" {if isset($smarty.request.id_contact) && $smarty.request.id_contact == $contact.id_contact}selected="selected"{/if}>{$contact.name|escape:'html':'UTF-8'}</option>
		                            {/foreach}
		                        </select>
	                        {/if}
	                    </div>	                                     
	                    <div class="form-group">
	                        <label for="email" class="form-label">{l s='Email address'}</label>
	                        {if isset($customerThread.email)}
	                            <input class="form-control grey input-lg" type="text" id="email" name="from" value="{$customerThread.email|escape:'html':'UTF-8'}" readonly="readonly" />
	                        {else}
	                            <input class="form-control grey input-lg validate" type="text" id="email" name="from" data-validate="isEmail" value="{$email|escape:'html':'UTF-8'}" />
	                        {/if}
	                    </div>
                    {if !$PS_CATALOG_MODE}
                        {if (!isset($customerThread.id_order) || $customerThread.id_order > 0)}
                            <div class="form-group selector1 large-selectbox">
                                <label class="form-label">{l s='Order reference'}</label>
                                {if !isset($customerThread.id_order) && isset($is_logged) && $is_logged}
                                    <select name="id_order" class="selectbox">
                                        <option value="0">{l s='-- Choose --'}</option>
                                        {foreach from=$orderList item=order}
                                            <option value="{$order.value|intval}"{if $order.selected|intval} selected="selected"{/if}>{$order.label|escape:'html':'UTF-8'}</option>
                                        {/foreach}
                                    </select>
                                {elseif !isset($customerThread.id_order) && empty($is_logged)}
                                    <input class="form-control grey input-lg" type="text" name="id_order" id="id_order" value="{if isset($customerThread.id_order) && $customerThread.id_order|intval > 0}{$customerThread.id_order|intval}{else}{if isset($smarty.post.id_order) && !empty($smarty.post.id_order)}{$smarty.post.id_order|escape:'html':'UTF-8'}{/if}{/if}" />
                                {elseif $customerThread.id_order|intval > 0}
                                    <input class="form-control grey input-lg" type="text" name="id_order" id="id_order" value="{$customerThread.id_order|intval}" readonly="readonly" />
                                {/if}
                            </div>
                        {/if}
                        {if isset($is_logged) && $is_logged}
                            <div class="form-group selector1">
                                <label class="unvisible" class="form-label">{l s='Product'}</label>
                                {if !isset($customerThread.id_product)}
                                    {foreach from=$orderedProductList key=id_order item=products name=products}
                                        <select name="id_product" id="{$id_order}_order_products" class="unvisible product_select form-control"{if !$smarty.foreach.products.first} style="display:none;"{/if}{if !$smarty.foreach.products.first} disabled="disabled"{/if}>
                                            <option value="0">{l s='-- Choose --'}</option>
                                            {foreach from=$products item=product}
                                                <option value="{$product.value|intval}">{$product.label|escape:'html':'UTF-8'}</option>
                                            {/foreach}
                                        </select>
                                    {/foreach}
                                {elseif $customerThread.id_product > 0}
                                    <input class="form-control grey input-lg" type="text" name="id_product" id="id_product" value="{$customerThread.id_product|intval}" readonly="readonly" />
                                {/if}
                            </div>
                        {/if}
                    {/if}
                    {if $fileupload == 1}
                        <p class="form-group hidden">
                            <label for="fileUpload" class="form-label">{l s='Attach File'}</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                            <input type="file" name="fileUpload" id="fileUpload" class="form-control" />
                        </p>
                    {/if}
                    <div class="form-group">
                        <label for="message" class="form-label">{l s='Write Your Review'}</label>
                        <textarea class="form-control input-lg min-height" id="message" name="message">{if isset($message)}{$message|escape:'html':'UTF-8'|stripslashes}{/if}</textarea>
                    </div>
                    <div class="submit">
                        <button type="submit" name="submitMessage" id="submitMessage" class="btn btn-lg btn-custom-5"><span>{l s='Send contact'}</span></button>
            		</div>
            	   </fieldset>
                </form>
			</div>
        {/if}
    </div>
</div>        
<div class="xlg-margin visible-xs clearfix"></div>
<div class="row clearfix">
    {hook h="displayBottomContact"}                
</div>
{addJsDefL name='contact_fileDefaultHtml'}{l s='No file selected' js=1}{/addJsDefL}
{addJsDefL name='contact_fileButtonHtml'}{l s='Choose File' js=1}{/addJsDefL}
{addJsDef map=''}
{addJsDef markers=array()}
{addJsDef infoWindow=''}
{addJsDef defaultLat=$defaultLat}
{addJsDef defaultLong=$defaultLong}
{addJsDef distance_unit=$distanceUnit}
{addJsDef img_store_dir=$img_store_dir}
{addJsDef img_ps_dir=$img_ps_dir}
{addJsDef searchUrl=$searchUrl}
{addJsDef logo_store=$logo_store}
{addJsDef tpl_uri=$tpl_uri}
{addJsDef hasStoreIcon=$hasStoreIcon}
{addJsDefL name=translation_1}{l s='No stores were found. Please try selecting a wider radius.' js=1}{/addJsDefL}
{addJsDefL name=translation_2}{l s='store found -- see details:' js=1}{/addJsDefL}
{addJsDefL name=translation_3}{l s='stores found -- view all results:' js=1}{/addJsDefL}
{addJsDefL name=translation_4}{l s='Phone:' js=1}{/addJsDefL}
{addJsDefL name=translation_5}{l s='Get directions' js=1}{/addJsDefL}
{addJsDefL name=translation_6}{l s='Not found' js=1}{/addJsDefL}