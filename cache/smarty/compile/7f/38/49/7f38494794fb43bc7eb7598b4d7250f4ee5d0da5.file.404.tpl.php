<?php /* Smarty version Smarty-3.1.19, created on 2015-10-21 23:31:26
         compiled from "/home/u481889647/public_html/themes/granada/404.tpl" */ ?>
<?php /*%%SmartyHeaderCode:197672240656284a7e368584-61595288%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7f38494794fb43bc7eb7598b4d7250f4ee5d0da5' => 
    array (
      0 => '/home/u481889647/public_html/themes/granada/404.tpl',
      1 => 1445437516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '197672240656284a7e368584-61595288',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'base_dir' => 0,
    'img_dir' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56284a7e441c87_22389017',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56284a7e441c87_22389017')) {function content_56284a7e441c87_22389017($_smarty_tpl) {?>


<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?>
	<li><a href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
" title="<?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>
</a></li>
	<li class="active"><?php echo smartyTranslate(array('s'=>'Error 404'),$_smarty_tpl);?>
</li>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<section id="content" class="no-content parallax" style="background-image:url(<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
img-404.jpg)" data-stellar-background-ratio="0.4"  role="main">
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./breadcrumb.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	<div class="vcenter-container">
	   <div class="vcenter">
	      <div class="container">
	         <div class="row">
	            <div class="col-sm-8 col-sm-push-2 col-md-8 col-md-push-2 col-lg-6 col-lg-push-3 text-center">
	               <h3><?php echo smartyTranslate(array('s'=>'404 error'),$_smarty_tpl);?>
</h3>
	               <h2><?php echo smartyTranslate(array('s'=>'This page cannot be found'),$_smarty_tpl);?>
</h2>
	               <p><?php echo smartyTranslate(array('s'=>'Sorry, the page you are looking for is not available. Maybe you want to perform a search?'),$_smarty_tpl);?>
</p>
	               <form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('search'), ENT_QUOTES, 'UTF-8', true);?>
" method="post" class="std">
	                  <div class="form-group">
	                  	<input id="search_query" name="search_query" type="text" class="form-control input-lg" placeholder="search">
	                  	<!-- <input id="search_query" name="search_query" type="text" class="form-control grey" /> --> 
	                  	<button type="submit" name="Submit" value="OK" class="submit-btn"><?php echo smartyTranslate(array('s'=>'Search'),$_smarty_tpl);?>
</button>
	                  </div>
	               </form>
	            </div>
	         </div>
	      </div>
	   </div>
	</div>	
</section>
<?php }} ?>
