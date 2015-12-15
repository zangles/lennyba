<?php /* Smarty version Smarty-3.1.19, created on 2015-10-21 11:27:47
         compiled from "/home/u481889647/public_html/themes/granada/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4619130715627a0e3bd8b88-21545351%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '100663c7331f19e255cdd3714d10ebdcb3a73b7a' => 
    array (
      0 => '/home/u481889647/public_html/themes/granada/footer.tpl',
      1 => 1445437516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4619130715627a0e3bd8b88-21545351',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'option_tpl' => 0,
    'content_only' => 0,
    'HOOK_FOOTER' => 0,
    'page_name' => 0,
    'HOME_BOTTOM_COLUMN' => 0,
    'BOTTOM_COLUMN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5627a0e3bf0742_26844389',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5627a0e3bf0742_26844389')) {function content_5627a0e3bf0742_26844389($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['option_tpl'] = new Smarty_variable(OvicLayoutControl::getTemplateFile('footer.tpl'), null, 0);?>
<?php if ($_smarty_tpl->tpl_vars['option_tpl']->value!==null) {?>
    <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['option_tpl']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php } else { ?>
			<?php if (!isset($_smarty_tpl->tpl_vars['content_only']->value)||!$_smarty_tpl->tpl_vars['content_only']->value) {?>		        
				<?php if (isset($_smarty_tpl->tpl_vars['HOOK_FOOTER']->value)) {?>				
					<footer id="footer" class="footer5">
						<?php if ($_smarty_tpl->tpl_vars['page_name']->value=='index') {?>
			                <?php if (isset($_smarty_tpl->tpl_vars['HOME_BOTTOM_COLUMN']->value)&&trim($_smarty_tpl->tpl_vars['HOME_BOTTOM_COLUMN']->value)) {?>
								<div id="footer-top">
									<div class="container">
										<div class="row"><?php echo $_smarty_tpl->tpl_vars['HOME_BOTTOM_COLUMN']->value;?>
</div>
									</div>								
								</div>
			                <?php }?>
						<?php }?>
						<div id="footer-inner">
							<div class="container">
								<div class="row"><?php echo $_smarty_tpl->tpl_vars['BOTTOM_COLUMN']->value;?>
</div>							
							</div>							
						</div>
						<div id="footer-bottom-container">
							<div class="container">
								<div class="row">
									<div class="col-xs-12">
										<div id="footer-bottom" class="clearfix">
											<?php echo $_smarty_tpl->tpl_vars['HOOK_FOOTER']->value;?>
					
										</div>
									</div>								
								</div>							
							</div>
						</div>					
					</footer>				
				<?php }?>			
				<a href="#header" id="scroll-top" class="color2 fixed" title="Go to top">Top</a>
			<?php }?>
		</div>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./global.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</body>
</html>
<?php }?>
<?php }} ?>
