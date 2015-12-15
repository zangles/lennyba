
			{if !isset($content_only) || !$content_only}		        
				{if isset($HOOK_FOOTER)}				
					<footer id="footer">
						{if $page_name =='index'}
			                {if isset($HOME_BOTTOM_COLUMN) && $HOME_BOTTOM_COLUMN|trim}
								{$HOME_BOTTOM_COLUMN}
			                {/if}
						{/if}						
						<div id="footer-inner" class="cleafix">
							<div class="container">
								<div class="row">{$BOTTOM_COLUMN}</div>							
							</div>							
						</div>
						<div id="footer-bottom-container">
							<div class="container">
								<div class="row">
									<div class="col-xs-12">
										<div id="footer-bottom" class="clearfix">
											{$HOOK_FOOTER}					
										</div>
									</div>								
								</div>							
							</div>
						</div>					
					</footer>				
				{/if}			
				<a href="#header" id="scroll-top" class="color2 fixed" title="{l s='Go to top'}">{l s='Top'}</a>
			{/if}
		</div>
	{include file="$tpl_dir./global.tpl"}
	</body>
</html>

