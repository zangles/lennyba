<div class="panel">
    <h3><i class="icon-cogs"></i>{l s=' Setting' mod='blocktestimonial'}
    </h3>
    <div class="main-container">
        <form method="post" action="{$postAction|escape:'htmlall':'UTF-8'}" enctype="multipart/form-data" class="item-form defaultForm  form-horizontal">
    		<div class="well">
                {*}<div class="title item-field form-group">
    				<label for="image" class="control-label col-lg-3 ">Testimonial background</label>
                    <div class="col-lg-9">
                        <div class="form-group">
				            <div class="col-lg-9">
                                {if isset($TESTIMONIAL_IMG) && $TESTIMONIAL_IMG|count_characters > 0}
                                <img class="img-thumbnail" src="{$imgpath}{$TESTIMONIAL_IMG}" alt="" />
                                <input type="hidden" name="testimonial_img_old" value="{$TESTIMONIAL_IMG}" id="testimonial_img_old" />
                                <br /><br />
                                {/if}
            				    <input class="form-control" type="file" id="TESTIMONIAL_IMG" name="TESTIMONIAL_IMG" value="{if isset($TESTIMONIAL_IMG)}{$TESTIMONIAL_IMG}{/if}"/>
                                <p class="help-block">The best image dimensions is 370x415 pixel</p>
				            </div>
							<div class="col-lg-2">
							</div>
                         </div>
    				</div>
    			</div>{*}
    			<div class="title item-field form-group">
    				<label for="image" class="control-label col-lg-3 ">Block title</label>
                    <div class="col-lg-9">
                        <div class="form-group">
                            {foreach from=$langguages.all item=lang}
                                <div class="translatable-field lang-{$lang.id_lang|escape:'htmlall':'UTF-8'}" {if $langguages.default_lang != $lang.id_lang}style="display:none"{/if}>
        				            <div class="col-lg-9">
                                        <input type="text" name="TESTIMONIAL_TITLE_{$lang.id_lang}" value="{$TESTIMONIAL_TITLE[$lang.id_lang]}" id="TESTIMONIAL_TITLE_{$lang.id_lang}" />
        				            </div>
        							<div class="col-lg-2">
        								<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
        									{$lang.iso_code|escape:'htmlall':'UTF-8'}
        									<i class="icon-caret-down"></i>
        								</button>
        								{$lang_ul}
        							</div>
        						</div>
    						  {/foreach}
                         </div>
    				</div>
    			</div>
                <div class="panel-footer">
				    <button type="submit" value="1" id="module_form_submit_btn" name="submitGlobal" class="btn btn-default pull-right">
						<i class="process-icon-save"></i> Save
				    </button>
				</div>
    		</div>
    	</form>
    </div>
</div>