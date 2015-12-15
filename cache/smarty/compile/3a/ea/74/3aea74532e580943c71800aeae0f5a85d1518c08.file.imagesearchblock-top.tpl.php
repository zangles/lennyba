<?php /* Smarty version Smarty-3.1.19, created on 2015-10-21 11:27:46
         compiled from "/home/u481889647/public_html/themes/granada/modules/imagesearchblock/imagesearchblock-top.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11637988015627a0e2f3dff5-57287065%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3aea74532e580943c71800aeae0f5a85d1518c08' => 
    array (
      0 => '/home/u481889647/public_html/themes/granada/modules/imagesearchblock/imagesearchblock-top.tpl',
      1 => 1445437516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11637988015627a0e2f3dff5-57287065',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'option_tpl' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5627a0e3007be7_50554482',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5627a0e3007be7_50554482')) {function content_5627a0e3007be7_50554482($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['option_tpl'] = new Smarty_variable(OvicLayoutControl::getTemplateFile('imagesearchblock-top.tpl','imagesearchblock'), null, 0);?>
<?php if ($_smarty_tpl->tpl_vars['option_tpl']->value!==null) {?>
    <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['option_tpl']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php } else { ?>
    <div class="search-container pull-left">
		<form action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('search');?>
" id="searchbox" class="search-form">
			<input type="hidden" name="controller" value="search" />
			<input type="hidden" name="orderby" value="position" />
			<input type="hidden" name="orderway" value="desc" />
			<input type="search" id="search_query_top" name="search_query" placeholder="<?php echo smartyTranslate(array('s'=>'Search','mod'=>'imagesearchblock'),$_smarty_tpl);?>
" />
			<input type="submit" value="Submit" class="search-submit-btn">		
		</form>
	</div>
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['self']->value)."/imagesearchblock-instantsearch.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php }} ?>
