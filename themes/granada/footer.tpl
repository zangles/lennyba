{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('footer.tpl')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}
			{if !isset($content_only) || !$content_only}		        
				{if isset($HOOK_FOOTER)}				
					<footer id="footer" class="footer5">
					    <div class="row">
					    	<div class="col-sm-4 col-sm-offset-4">
                                <p style="font-size: 14px;">ATENCION AL CLIENTE</p>
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="{$link->getCMSLink('11-envios' )|escape:'html':'UTF-8'}" style="font-size: 11px;">
                                            Informacion de envios
                                        </a>
                                    </li>
                                    <li>

                                        <a href="{$link->getCMSLink('12-devoluciones' )|escape:'html':'UTF-8'}" style="font-size: 11px;">
                                            Devoluciones y Cambios
                                        </a>
                                    </li>
                                </ul>
                            </div>
					    	<div class="col-sm-4">
                                <p style="font-size: 14px;">LENNY</p>
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="{$link->getCMSLink('9-about' )|escape:'html':'UTF-8'}" style="font-size: 11px;">
                                            La Empresa
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$link->getPageLink('contact-form.php', true)}" style="font-size: 11px;">
                                            Showroom
                                        </a>
                                    </li>
                                </ul>
                            </div>
					    	<div class="col-sm-4">
                                <p style="font-size: 14px;">SEGUINOS</p>
                                <ul class="social-links clearfix">
                                    <li class="facebook">
                                        <a class="ps-social-icon icon-facebook" target="_blank" href="https://www.facebook.com/lennybuenosaires/?fref=ts">
                                            <span>{l s='Facebook' mod='blocksocial'}</span>
                                        </a>
                                    </li>
                                    <li class="instagram">
                                        <a class="ps-social-icon icon-instagram" target="_blank"  href="https://www.instagram.com/lennyleatherba/">
                                            <span>{l s='Instagram' mod='blocksocial'}</span>
                                        </a>
                                    </li>
                                    <li class="instagram">
                                        <a class="ps-social-icon icon-email" target="_blank"  href="mailto:info@lennyba.com.ar">
                                            <span>{l s='Email' mod='blocksocial'}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
					    	<div class="col-sm-4">
                                FACEBOOK
                                {*<a class="facebook-like-btn" id="facebook-like-btn" href="#">Like!</a>*}

                                <div id="fb-root"></div>
                                <script>(function(d, s, id) {
                                  var js, fjs = d.getElementsByTagName(s)[0];
                                  if (d.getElementById(id)) return;
                                  js = d.createElement(s); js.id = id;
                                  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.5";
                                  fjs.parentNode.insertBefore(js, fjs);
                                }(document, 'script', 'facebook-jssdk'));</script>
                                <script >
                                    $(document).ready(function(){
                                        $("#facebook-like-btn").click(function(){
                                              $(".fb-like").find("a.connect_widget_like_button").click();
                                              // You can look elements in facebook like button with firebug or developer tools.
                                              return false;
                                        });
                                    });
                                </script>
                                <div style="display:none" class="fb-like" data-href="https://www.facebook.com/lennybuenosaires/?fref=ts" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-16 col-sm-offset-4" style="border-top: 1px solid #979388; padding-top: 30px">
                                <p style="font-size: 14px;">2016 Developed by Sunday Morning LAB Design. All Rights Reerved.</p>
                            </div>
                        </div>
					</footer>
				{/if}			
				<a href="#header" id="scroll-top" class="color2 fixed" title="Go to top">Top</a>
			{/if}
		</div>
	{include file="$tpl_dir./global.tpl"}
	</body>
</html>
{/if}
