<?php
	require_once(dirname(__FILE__).'../../../config/config.inc.php');
	require_once(dirname(__FILE__).'../../../init.php');
	require_once(dirname(__FILE__).'/megaboxs.php');
	$module = new MegaBoxs();	
	$megaboxAjax = new MegaBoxsAjax();
	if (!Tools::isSubmit('secure_key') || Tools::getValue('secure_key') != $module->secure_key){
		$response->status = 0;		
		$response->msg =  $module->l("Error: not prosess.");
	}
	if (!Tools::isSubmit('action') || !Tools::getValue('action')){
		$response->status = 0;		
		$response->msg =  $module->l("Error: not action.");
	}
	$action = Tools::getValue('action');
	if(method_exists ($megaboxAjax, $action)){
		$megaboxAjax->$action();	
	}else{
		$response->status = 0;
		$response->msg =  $module->l("Error: not method.");
	}	
	
	class MegaBoxsAjax{
		public $errors = array();
		public $context = null;
		public function __construct(){
			$this->context = Context::getContext(); 
		}
		protected function getOrder()
		{
			$id_order = false;
			if (!is_numeric($reference = Tools::getValue('id_order')))
			{
				$reference = ltrim($reference, '#');
				$orders = Order::getByReference($reference);
				if ($orders)
					foreach ($orders as $order)
					{
						$id_order = $order->id;
						break;
					}
			}
			else
				$id_order = Tools::getValue('id_order');
			return (int)$id_order;
		}
		public function saveContact(){			
			$message = Tools::getValue('message'); // Html entities is not usefull, iscleanHtml check there is no bad html tags.
			if (!($from = trim(Tools::getValue('email'))) || !Validate::isEmail($from))
				$this->errors[] = Tools::displayError('Invalid email address.');
			elseif (!$message)
				$this->errors[] = Tools::displayError('The message cannot be blank.');
			elseif (!Validate::isCleanHtml($message))
				$this->errors[] = Tools::displayError('Invalid message');
			elseif (!($id_contact = (int)Tools::getValue('id_contact')) || !(Validate::isLoadedObject($contact = new Contact($id_contact, $this->context->language->id))))
				$this->errors[] = Tools::displayError('Please select a subject from the list provided. ');			
			else
			{
				$customer = $this->context->customer;
				if (!$customer->id)
					$customer->getByEmail($from);

				$id_order = (int)$this->getOrder();

				if (!((
						($id_customer_thread = (int)Tools::getValue('id_customer_thread'))
						&& (int)Db::getInstance()->getValue('
						SELECT cm.id_customer_thread FROM '._DB_PREFIX_.'customer_thread cm
						WHERE cm.id_customer_thread = '.(int)$id_customer_thread.' AND cm.id_shop = '.(int)$this->context->shop->id.' AND token = \''.pSQL(Tools::getValue('token')).'\'')
					) || (
						$id_customer_thread = CustomerThread::getIdCustomerThreadByEmailAndIdOrder($from, $id_order)
					)))
				{
					$fields = Db::getInstance()->executeS('
					SELECT cm.id_customer_thread, cm.id_contact, cm.id_customer, cm.id_order, cm.id_product, cm.email
					FROM '._DB_PREFIX_.'customer_thread cm
					WHERE email = \''.pSQL($from).'\' AND cm.id_shop = '.(int)$this->context->shop->id.' AND ('.
						($customer->id ? 'id_customer = '.(int)$customer->id.' OR ' : '').'
						id_order = '.(int)$id_order.')');
					$score = 0;
					foreach ($fields as $key => $row)
					{
						$tmp = 0;
						if ((int)$row['id_customer'] && $row['id_customer'] != $customer->id && $row['email'] != $from)
							continue;
						if ($row['id_order'] != 0 && $id_order != $row['id_order'])
							continue;
						if ($row['email'] == $from)
							$tmp += 4;
						if ($row['id_contact'] == $id_contact)
							$tmp++;
						if (Tools::getValue('id_product') != 0 && $row['id_product'] == Tools::getValue('id_product'))
							$tmp += 2;
						if ($tmp >= 5 && $tmp >= $score)
						{
							$score = $tmp;
							$id_customer_thread = $row['id_customer_thread'];
						}
					}
				}
				$old_message = Db::getInstance()->getValue('
					SELECT cm.message FROM '._DB_PREFIX_.'customer_message cm
					LEFT JOIN '._DB_PREFIX_.'customer_thread cc on (cm.id_customer_thread = cc.id_customer_thread)
					WHERE cc.id_customer_thread = '.(int)$id_customer_thread.' AND cc.id_shop = '.(int)$this->context->shop->id.'
					ORDER BY cm.date_add DESC');
				if ($old_message == $message)
				{
					$this->context->smarty->assign('alreadySent', 1);
					$contact->email = '';
					$contact->customer_service = 0;
				}

				if ($contact->customer_service)
				{
					if ((int)$id_customer_thread)
					{
						$ct = new CustomerThread($id_customer_thread);
						$ct->status = 'open';
						$ct->id_lang = (int)$this->context->language->id;
						$ct->id_contact = (int)$id_contact;
						$ct->id_order = (int)$id_order;
						if ($id_product = (int)Tools::getValue('id_product'))
							$ct->id_product = $id_product;
						$ct->update();
					}
					else
					{
						$ct = new CustomerThread();
						if (isset($customer->id))
							$ct->id_customer = (int)$customer->id;
						$ct->id_shop = (int)$this->context->shop->id;
						$ct->id_order = (int)$id_order;
						if ($id_product = (int)Tools::getValue('id_product'))
							$ct->id_product = $id_product;
						$ct->id_contact = (int)$id_contact;
						$ct->id_lang = (int)$this->context->language->id;
						$ct->email = $from;
						$ct->status = 'open';
						$ct->token = Tools::passwdGen(12);
						$ct->add();
					}

					if ($ct->id)
					{
						$cm = new CustomerMessage();
						$cm->id_customer_thread = $ct->id;
						$cm->message = $message;
						
						$cm->ip_address = (int)ip2long(Tools::getRemoteAddr());
						$cm->user_agent = $_SERVER['HTTP_USER_AGENT'];
						if (!$cm->add())
							$this->errors[] = Tools::displayError('An error occurred while sending the message.');
					}
					else
						$this->errors[] = Tools::displayError('An error occurred while sending the message.');
				}

				if (!count($this->errors))
				{
					$var_list = array(
									'{order_name}' => '-',
									'{attached_file}' => '-',
									'{message}' => Tools::nl2br(stripslashes($message)),
									'{email}' =>  $from,
									'{product_name}' => '',
								);

					if (isset($file_attachment['name']))
						$var_list['{attached_file}'] = $file_attachment['name'];

					$id_product = (int)Tools::getValue('id_product');

					if (isset($ct) && Validate::isLoadedObject($ct) && $ct->id_order)
					{
						$order = new Order((int)$ct->id_order);
						$var_list['{order_name}'] = $order->getUniqReference();
						$var_list['{id_order}'] = (int)$order->id;
					}

					if ($id_product)
					{
						$product = new Product((int)$id_product);
						if (Validate::isLoadedObject($product) && isset($product->name[Context::getContext()->language->id]))
							$var_list['{product_name}'] = $product->name[Context::getContext()->language->id];
					}

					if (empty($contact->email))
						Mail::Send($this->context->language->id, 'contact_form', ((isset($ct) && Validate::isLoadedObject($ct)) ? sprintf(Mail::l('Your message has been correctly sent #ct%1$s #tc%2$s'), $ct->id, $ct->token) : Mail::l('Your message has been correctly sent')), $var_list, $from, null, null, null);
					else
					{
						if (!Mail::Send($this->context->language->id, 'contact', Mail::l('Message from contact form').' [no_sync]',
							$var_list, $contact->email, $contact->name, $from, ($customer->id ? $customer->firstname.' '.$customer->lastname : '')) ||
								!Mail::Send($this->context->language->id, 'contact_form', ((isset($ct) && Validate::isLoadedObject($ct)) ? sprintf(Mail::l('Your message has been correctly sent #ct%1$s #tc%2$s'), $ct->id, $ct->token) : Mail::l('Your message has been correctly sent')), $var_list, $from, null, $contact->email, $contact->name))
									$this->errors[] = Tools::displayError('An error occurred while sending the message.');
					}
				}
				$response = new stdClass();
				if($this->errors){
					$response->status = '0';
					$response->msg = implode('<br />', $this->errors);
				}else{
					$response->status = 1;
					$response->msg = "Send message success!";
				}
				die(Tools::jsonEncode($response));
				
				/*
				if (count($this->errors) > 1)
					array_unique($this->errors);
				elseif (!count($this->errors))
					$this->context->smarty->assign('confirmation', 1);
				* 
				*/
			}
			
			
			
			
			
		}
		
		
	}
	
?>