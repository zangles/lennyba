<?php /* Smarty version Smarty-3.1.19, created on 2015-10-21 11:28:32
         compiled from "/home/u481889647/public_html/themes/granada/modules/blockwishlist/blockwishlist-extra.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9096233775627a110ec23f6-99878928%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '88e541c0207edc2a91e3de4a7b2b68066f0371c6' => 
    array (
      0 => '/home/u481889647/public_html/themes/granada/modules/blockwishlist/blockwishlist-extra.tpl',
      1 => 1445437516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9096233775627a110ec23f6-99878928',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id_product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5627a110ec8640_73938230',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5627a110ec8640_73938230')) {function content_5627a110ec8640_73938230($_smarty_tpl) {?>


	<a id="wishlist_button" class="product-btn product-favorite" href="#" onclick="WishlistCart('wishlist_block_list', 'add', '<?php echo intval($_smarty_tpl->tpl_vars['id_product']->value);?>
', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;" data-wl="nofollow"  title="<?php echo smartyTranslate(array('s'=>'Add to my wishlist','mod'=>'blockwishlist'),$_smarty_tpl);?>
">
		<?php echo smartyTranslate(array('s'=>'Add to wishlist','mod'=>'blockwishlist'),$_smarty_tpl);?>

	</a>
<?php }} ?>
