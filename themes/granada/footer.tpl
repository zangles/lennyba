{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('footer.tpl')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}
			{if !isset($content_only) || !$content_only}		        
				{if isset($HOOK_FOOTER)}				
					<footer id="footer" class="footer5">
					    <div class="row">
					    	<div class="col-sm-4 col-sm-offset-4">
                                <p>ATENCION AL CLIENTE</p>
                                <ul class="list-unstyled">
                                    <li>Contactanos</li>
                                    <li>Informacion de envios</li>
                                    <li>Devoluciones y Cambios</li>
                                    <li>Seguridad</li>
                                    <li>GIFT Card</li>
                                    <li>FAQs</li>
                                </ul>
                            </div>
					    	<div class="col-sm-4">
                                <p>LENNY</p>
                                <ul class="list-unstyled">
                                    <li>La Empresa</li>
                                    <li>Showroom</li>
                                    <li>Politicas de Privacidad</li>
                                    <li>Terminos y Condiciones</li>
                                </ul>
                            </div>
					    	<div class="col-sm-4">
                                <p>SEGUINOS</p>
                            </div>
					    	<div class="col-sm-4">
                                FACEBOOK
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-16 col-sm-offset-4" style="border-top: 1px solid #979388; padding-top: 30px">
                                <p>2014 Developed by Sunday Morning LAB Design. All Rights Reerved.</p>
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
