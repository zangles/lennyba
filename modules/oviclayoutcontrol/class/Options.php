<?php if (!defined('_PS_VERSION_')) exit;
class Options extends ObjectModel
{
    /**
     *  *  * @var integer id_item */
    public $id_option;
    /**
     *  *  * @var String theme */
    public $theme;
    /**
     *  *  * @var String name */
    public $name;
    /**
     *  *  * @var String directory */
    public $alias;
    /**
     *  *  * @var String image name*/
    public $image;
    /**
     *  *  * @var String column selected  */
    public $column;
    /**
     *  *  * @var int active status */
    public $active;
    public static $definition = array(
        'table' => 'ovic_options',
        'primary' => 'id_option',        
        'fields' => array(
            'image' => array('type' => self::TYPE_STRING, 'validate' => 'isMessage'),
            'theme' => array('type' => self::TYPE_STRING, 'validate' => 'isMessage','required' => true),
            'alias' => array('type' => self::TYPE_STRING, 'validate' => 'isMessage','required' => true),
            'column' => array('type' => self::TYPE_STRING, 'validate' => 'isMessage','required' => true),
            'active' => array(
                'type' => self::TYPE_BOOL,
                'validate' => 'isBool',
                'required' => true),
            'name' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isMessage',
                'required' => true)));

    public function delete()
    {
        $context = Context::getContext();
        $res = true;
        $image = $this->image;
        if ($image && file_exists(dirname(__file__) . '/../thumbnails/' . $image)) $res &= @unlink(dirname(__file__) .
                '/../thumbnails/' . $image);
        $where = "`theme` = '".$this->theme. "' AND `alias` = '".$this->alias."'";
        //$where = "`id_option` = ".(int)$this->id_option. " AND `id_shop` = ".(int)$context->shop->id;
        $res &= Db::getInstance()->delete('ovic_options_hook_module', $where);
        $res &= Db::getInstance()->delete('ovic_options_style', $where);
        $res &= parent::delete();
        return $res;
    }
}
