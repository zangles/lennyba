<?php /* Smarty version Smarty-3.1.19, created on 2015-10-21 12:05:23
         compiled from "/home/u481889647/public_html/admin/themes/default/template/helpers/list/list_action_supply_order_create_from_template.tpl" */ ?>
<?php /*%%SmartyHeaderCode:212991631756277f83172ee7-67974874%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '64f685a51538ed7ebc17ce6030235a9ebfe71bb6' => 
    array (
      0 => '/home/u481889647/public_html/admin/themes/default/template/helpers/list/list_action_supply_order_create_from_template.tpl',
      1 => 1445407990,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '212991631756277f83172ee7-67974874',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'confirm' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56277f831abbe4_06399088',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56277f831abbe4_06399088')) {function content_56277f831abbe4_06399088($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" onclick="return confirm('<?php echo $_smarty_tpl->tpl_vars['confirm']->value;?>
');" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
">
	<i class="icon-copy"></i> <?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a><?php }} ?>
