<?php /* Smarty version Smarty-3.1.19, created on 2015-10-21 12:05:25
         compiled from "/home/u481889647/public_html/admin/themes/default/template/controllers/request_sql/list_action_export.tpl" */ ?>
<?php /*%%SmartyHeaderCode:199410362056277f85032079-20939951%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2211e7b34c240a669e0f6850237228d5514439c0' => 
    array (
      0 => '/home/u481889647/public_html/admin/themes/default/template/controllers/request_sql/list_action_export.tpl',
      1 => 1445407900,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '199410362056277f85032079-20939951',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56277f85058522_42856914',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56277f85058522_42856914')) {function content_56277f85058522_42856914($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
" class="btn btn-default">
	<i class="icon-cloud-upload"></i> <?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a><?php }} ?>
