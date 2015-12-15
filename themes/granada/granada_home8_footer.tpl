			{if !isset($content_only) || !$content_only}		        
				
				{if isset($HOOK_FOOTER)}				
					<footer id="footer" class="footer4">
						
							<div id="footer-inner">
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
				
				<a href="#header" id="scroll-top" class="color2 fixed" title="Go to top">Top</a>
			{/if}
		</div>
	{include file="$tpl_dir./global.tpl"}
	</body>
</html>
