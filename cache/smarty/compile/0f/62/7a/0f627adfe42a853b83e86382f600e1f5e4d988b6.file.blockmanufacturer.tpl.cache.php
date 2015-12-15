<?php /* Smarty version Smarty-3.1.19, created on 2015-10-21 11:27:47
         compiled from "/home/u481889647/public_html/themes/granada/modules/blockmanufacturer/granada_left/blockmanufacturer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17961468635627a0e36ee429-57942301%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0f627adfe42a853b83e86382f600e1f5e4d988b6' => 
    array (
      0 => '/home/u481889647/public_html/themes/granada/modules/blockmanufacturer/granada_left/blockmanufacturer.tpl',
      1 => 1445437516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17961468635627a0e36ee429-57942301',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'manufacturers' => 0,
    'text_list_nb' => 0,
    'manufacturer' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5627a0e370df82_95870347',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5627a0e370df82_95870347')) {function content_5627a0e370df82_95870347($_smarty_tpl) {?><div class="widget side-menu-container">
	<h3><?php echo smartyTranslate(array('s'=>'Brands','mod'=>'blockmanufacturer'),$_smarty_tpl);?>
</h3>
	<div class="side-menu">
		<ul>
			<?php  $_smarty_tpl->tpl_vars['manufacturer'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['manufacturer']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['manufacturers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['manufacturer_list']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['manufacturer']->key => $_smarty_tpl->tpl_vars['manufacturer']->value) {
$_smarty_tpl->tpl_vars['manufacturer']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['manufacturer_list']['iteration']++;
?>
				<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['manufacturer_list']['iteration']<=$_smarty_tpl->tpl_vars['text_list_nb']->value) {?>
					<li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink($_smarty_tpl->tpl_vars['manufacturer']->value['id_manufacturer'],$_smarty_tpl->tpl_vars['manufacturer']->value['link_rewrite']), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['manufacturer']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['manufacturer']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</a></li>
                <?php }?>
            <?php } ?>           
      </ul>
   </div>
</div><?php }} ?>
