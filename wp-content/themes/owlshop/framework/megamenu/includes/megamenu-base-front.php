<?php

class Megamenu_Buider_Front {
	
	protected $menu_items= null ;
	protected $children = array();
	protected $items = array();
	protected $output = '';
	protected $params = null;
	protected $settings = null;
	protected $top_level_caption =  false;
	protected $front_end = false;
	protected $args = array();
	
	protected $menu_id;
	
	
	public function __construct($menu_id=null){
		if(!empty($menu_id)){
			$this->menu_id = $menu_id;
			$menu_object = wp_get_nav_menu_object($menu_id);
			if ( $menu_object && ! is_wp_error($menu_object)){
				$this->menu_items = wp_get_nav_menu_items( $menu_object->term_id, array( 'update_post_term_cache' => false ) );
			}
		}
	}
	
	protected function _render_menu_items($menu_items){
		
		if(empty($menu_items))
			return '';

		
		_wp_menu_item_classes_by_context($menu_items);

		$children = array();
		foreach ($menu_items as $item){
			
            $pt = $item->menu_item_parent;
            $list = (isset($children[$pt]) && !empty($children[$pt])) ? $children[$pt] : array();
            array_push($list, $item);
            $children[$pt] = $list;
		}
		
		$lists = $this->menu_treerecurse(0, array(), $children);
		
		
		foreach ($lists as $item){
			$item->title = esc_html($item->title);
			$item->level = $item->level + 1;
			$key = 'item-'.$item->ID;
			$setting = isset($this->settings[$key]) ? $this->settings[$key] : array();
			// decode html tag
			if (isset($setting['caption']) && $setting['caption']) $setting['caption'] = str_replace(array('[lt]','[gt]'), array('<','>'), $setting['caption']);
			if ($item->level == 1 && isset($setting['caption']) && $setting['caption']) $this->top_level_caption = true;
				
			
			
			$item->class = '';
			$item->mega = 0;
			$item->group = 0;
			$item->dropdown = 0;
				
			//$item->target = '';
			if (isset($setting['group'])) {
				$item->group = 1;
			} else {
				if ($this->front_end){
					if (($item->children && (!isset($setting['hidesub']))) || isset($setting['sub'])) {
						$item->dropdown = 1;
					}
				}else{
					if ($item->children || isset($setting['sub'])) {
						$item->dropdown = 1;
					}
				}
			}
		
				
			$item->mega = $item->group || $item->dropdown;
				
				
			if ($item->mega) {
				if (!isset($setting['sub'])) $setting['sub'] = array();
				if ($item->children && (!isset($setting['sub']['rows']) || !count($setting['sub']['rows']))) {
					$c = $item->frist_children->ID;
					$setting['sub'] = array('rows'=>array(array(array('width'=>12, 'item'=>$c))));
				}
			}
				
			$item->setting = $setting;
		
			$item->url  = esc_url($item->url);
				
			$parent = isset($this->children[$item->menu_item_parent]) ? $this->children[$item->menu_item_parent] : array();
			$parent[] = $item;
			$this->children[$item->menu_item_parent] = $parent;
			$this->items[$item->ID] = $item;
		}
	}
	
	protected function _render_nav($pitem, $start = 0, $end = 0) {
	
		if ($start > 0) {
			if (!isset($this->items[$start]))
				return;
			$pid     = $this->items[$start]->menu_item_parent;
			$items   = array();
			$started = false;
			foreach ($this->children[$pid] as $item) {
				if ($started) {
					if ($item->ID == $end)
						break;
					$items[] = $item;
				} else {
					if ($item->ID == $start) {
						$started = true;
						$items[] = $item;
					}
				}
			}
			if (!count($items))
				return;
		} else if ($start === 0) {
			$pid = $pitem->ID;
			if (!isset($this->children[$pid]))
				return;
			$items = $this->children[$pid];
		} else {
			//empty menu
			return;
		}
	
		$beginnav = $this->tmpl('beginnav', array(
				'item' => $pitem
		));
		$itemHtml = '';
		foreach ($items as $item) {
			$itemHtml .= $this->_render_item($item);
		}
	
		$endnav = $this->tmpl('endnav', array(
				'item' => $pitem
		));
		if ($itemHtml == ''){
			return '';
		}
		return $beginnav.$itemHtml.$endnav;
	}
	
	protected function _render_item ($item) {
		// item content
		$setting = $item->setting;
	
	
		$megaHtml = '';
		if ($item->mega) {
			$megaHtml .= $this->_render_mega($item);
		}
		if ($megaHtml == ''){
			$item->group = 0;
			$item->dropdown = 0;
			$item->mega = 0;
		}
	
		$html = $this->tmpl('beginitem', array ('item'=>$item, 'setting'=>$setting));
	
		$itemHtml = $this->tmpl('item', array ('item'=>$item, 'setting'=>$setting));
		$html .= $itemHtml;
		if ($megaHtml != ''){
			$html .= $megaHtml;
		}
		$html .= $this->tmpl('enditem', array ('item'=>$item));
		return $html;
	}
	
	protected  function _render_mega ($item) {

		
		$key       = 'item-' . $item->ID;
		$setting   = $item->setting;
		$sub       = $setting['sub'];
		$items     = isset($this->children[$item->ID]) ? $this->children[$item->ID] : array();
		$firstitem = count($items) ? $items[0]->ID : 0;
	
	
		$endItems = array();
		$k1       = $k2 = 0;
		foreach ($sub['rows'] as $row) {
			foreach ($row as $col) {
				//var_dump($col);
				$col = $this->set_col_empty($col);

				if ( !isset($col['position']) ) {
					if ($k1) {
						$k2 = $col['item'];
						if (!isset($this->items[$k2]) || $this->items[$k2]->menu_item_parent != $item->ID)
							break;
						$endItems[$k1] = $k2;
					}
					$k1 = $col['item'];
				}
			}
		}
	
		$html = '';
		$endItems[$k1] = 0;
		$beginmega = $this->tmpl('beginmega', array(
				'item' => $item
		));
		$firstitemscol = true;
		$rowHtml = '';
		foreach ($sub['rows'] as $row) {
			$beginrow = $this->tmpl('beginrow');
			$colHtml = '';
			foreach ($row as $col) {
				$col = $this->set_col_empty($col);
				if ( isset($col['position']) ) {
					$beginwidget = $this->tmpl('begincol', array('setting' => $col));
					$endwidget = $this->tmpl('endcol');
					$colHtml .= $beginwidget.$this->_render_widget($col).$endwidget;
				}else {
					if (!isset($endItems[$col['item']])){
						continue;
					}
						
					$begincol = $this->tmpl('begincol', array('setting' => $col));
					$toitem    = $endItems[$col['item']];
					$startitem = $firstitemscol ? $firstitem : $col['item'];
					$subNav = $this->_render_nav($item, $startitem, $toitem);
					$firstitemscol = false;
					$endcol = $this->tmpl('endcol');
					if ($subNav != ''){
						$colHtml .= $begincol.$subNav.$endcol;
					}
				}
	
			}
			$endrow = $this->tmpl('endrow');
			if ($colHtml != ''){
				$rowHtml .= $beginrow.$colHtml.$endrow;
			}
		}
		$endmega =$this->tmpl('endmega');
		if ($rowHtml == ''){
			return '';
		}
		return $beginmega.$rowHtml.$endmega;
	}
	
	protected function _render_widget($col){
		$widget = $col['position'];
		$dwidgets = PGL_Megamenu_Widget::getInstance()->loadWidgets();
		$shortcode =   PGL_Shortcodes::getInstance();
		$output = '';
		$o = $dwidgets->getWidgetById( $widget );
		if( $o ){
			$output .= '<div class="pgl-module module">';
			$output .= $shortcode->renderContent( $o->type, $o->params );
			$output .= '</div>';
		}
		return $output;
	}
	
	protected function tmpl($tmpl, $args = array()) {
		$args ['menu'] = $this;
		$func = '_'.$tmpl;
		if (method_exists($this, $func)) {
			return $this->$func($args)."\n";
		} else {
			return "$tmpl\n";
		}
	}
	
	protected function _beginmenu ($args) {
		$menu = $args['menu'];
		$duration = $menu->_get_param('duration',300);
		$animation = $menu->_get_param('animation','');

		$cls = ' class="'.$menu->_get_param('container_class','collapse navbar-collapse navbar-ex1-collapse').'"';

		$html = '<nav id="pgl-mainnav" data-duration="'.$duration.'" class="pgl-megamenu '.$animation.' animate navbar navbar-main">';
		if( $menu->_get_param('show_toggle', false )==true){
        	$html .= '<a href="javascript:;" class="off-canvas-toggle icon-toggle" data-uk-offcanvas="{target:\'#pgl-off-canvas\'}">
                        <i class="fa fa-bars"></i>
                    </a>';
        }
        $html .= '<div'.$cls.'>';
        
		return $html;
	}

		protected function _endmenu ($args) {
			return '</div></nav>';
		}

		protected function _beginnav ($args) {
			$item = $args['item'];
			$menu = $args['menu'];
			$cls = '';
			
			if (!$item) {
				$cls = $menu->_get_param('menu_class', 'nav navbar-nav megamenu');
			} else {
				$cls .= ' mega-nav';
				$cls .= ' level'.$item->level;
			}
			 
			if ($cls) $cls = 'class="'.esc_attr( trim($cls) ) .'"';

			return '<ul '.$cls.'>';
		}

		protected function _endnav ($args) {
			return '</ul>';
		}

		protected function _beginmega ($args) {
			$item = $args['item'];
			$setting = $item->setting;
			$sub = $setting['sub'];
			$cls = 'nav-child '.($item->dropdown ? 'dropdown-menu mega-dropdown-menu' : 'mega-group-ct');
			$style = '';
			$data = '';
			//if (isset($setting['class'])) $data .= " data-class=\"{$setting['class']}\"";
			if (isset($sub['class'])) {
				$data .= " data-class=\"{$sub['class']}\"";
				$cls  .= " {$sub['class']}";
			}
			
			if (isset($sub['width'])) {
				if ($item->dropdown) $style = " style=\"width:{$sub['width']}px\"";
				$data .= " data-width=\"{$sub['width']}\"";
			}

			if ($cls) $cls = 'class="'.trim($cls).'"';

			return "<div $cls $style $data><div class=\"mega-dropdown-inner\">";
	}
	
	protected function _endmega ($args) {
		return '</div></div>';
	}
	
	protected function _beginrow ($args) {
		return '<div class="row">';
	}
	
	protected function _endrow ($args) {
		return '</div>';
	}
	
	protected  function _begincol ($args) {
		$setting = isset($args['setting']) ? $args['setting'] : array();
		$width = isset($setting['width']) ? $setting['width'] : '12';
		$data = '';
		if (!$this->front_end)
			$data = "data-width=\"$width\"";
		
		$cls = "mega-col-nav col-sm-$width";
		
		if (isset($setting['position'])) {
			$cls .= " mega-col-widget";
		}

		if (isset($setting['class'])) {
			$cls .= " {$setting['class']}";
		}
		if (isset($setting['hidewcol'])) {
			$cls .= " hidden-collapse";
		}
		return "<div class=\"$cls\" $data><div class=\"mega-inner\">";
	}
	
	protected function _endcol ($args) {
		return '</div></div>';
	}
	
	protected function _beginitem ($args) {
		$item = $args['item'];
		$menu = $args['menu'];
		$setting = $item->setting;
		$cls = $item->class;
	
		if ($item->dropdown) {
			$cls .= $item->level == 1 ? 'dropdown' : 'dropdown-submenu';
		}
						
		if ($item->mega) $cls .= ' mega';
		if ($item->group) $cls .= ' mega-group';
	
		$id = $item->ID;
		
		$data = "data-id=\"{$id}\" data-level=\"{$item->level}\"";
			
		if (isset($setting['class'])) {
			$cls .= " {$setting['class']}";
		}
		if (isset($setting['alignsub'])) {
			if($setting['alignsub']=='justify'){
				$cls .= " aligned-fullwidth";
				$data .= ' data-alignsub="fullwidth"';
			}else{
				$cls .= " aligned-{$setting['alignsub']}";
			}
			
		}
		
		if (isset($setting['hidewcol'])) {
			$cls .= " sub-hidden-collapse";
		}
	
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, array() ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . ' '.$cls.'"' : ' class="'.$cls.'"';
	
		return "<li $class_names $data>";
	}
	protected  function _enditem ($args) {
		return '</li>';
	}
	protected function _item ($args) {
		$item = $args['item'];
		$menu = $args['menu'];
		$setting = $item->setting;
	
		$args['title'] = $item->attr_title ? 'title="'.$item->attr_title.'" ' : '';
		$args['dropdown'] = '';
		$args['caret'] = '';
		$args['icon'] = '';
		$args['caption'] = '';
		$args['class'] = '';
	
		if($item->dropdown && $item->level < 2){
			$args['class'] .= ' dropdown-toggle';
			$args['dropdown'] = ' ';
			$args['caret'] = '<i class="fa fa-angle-down"></i>';
		}
	
		if ($item->group) $args['class'] .= ' mega-group-title';
	
	
		$args['label'] = '<span>'.$item->title.'</span>';
		if (isset($setting['xicon']) && $setting['xicon']) {
			$args['icon'] = '<i class="fa '.$setting['xicon'].'"></i>';
				
		}
		if (isset($setting['caption']) && $setting['caption']) {
			$args['caption'] = '<span class="mega-caption">'.$setting['caption'].'</span>';
		} else if ($item->level==1 && $args['menu']->get('top_level_caption')) {
			$args['caption'] = '<span class="mega-caption mega-caption-empty">&nbsp;</span>';
		}
	
		$html = $this->_item_url ($args);
	
		return $html;
	}
	
	protected  function _item_url ($args) {
		$item = $args['item'];
		$menu = $args['menu'];
		$class = $args['class'];
	
		$title = $args['title'];
		$caret = $args['caret'];
		$label = $args['label'];
		$icon = $args['icon'];
		$caption = $args['caption'];
		$dropdown = $args['dropdown'];
	
		//$target = ! empty( $item->target ) ? 'target="_blank"': '';
		$rel    = ! empty( $item->xfn ) ? 'rel="'.$item->xfn.'"': '';
	
		$url = $item->url;
	
		$url = esc_url($url);
		
		$link = "";
		switch ($item->target) :
			default:
				$link = "<a $rel class=\"$class\" href=\"$url\"  $title$dropdown>$icon$label$caret$caption</a>";
			break;
			case '_blank':
				$link = "<a target=\"_blank\" $rel class=\"$class\" href=\"$url\" $title$dropdown>$icon$label$caret$caption</a>";
				break;
		endswitch;
	
		
		return $link;
	}
	
	protected  function _get_param($key,$default=null){
		if (isset($this->params[$key]))
			return $this->params[$key];
		return $default;
	}
	
	protected function get($key){
		if ($this->$key)
			return $this->$key;
		return null;
	}

	private function set_col_empty($col){
		if( isset($col['item']) && $col['item']==-1 ){
			unset($col['item']);
			$col['position']=0;
		}
		return $col;
	}

	private function menu_treerecurse($id, $list, &$children, $maxlevel = 9999, $level = 0){
			if (@$children[$id] && $level <= $maxlevel)
			{
				foreach ($children[$id] as $v)
				{
					$id = $v->ID;
					$list[$id] = $v;
					$children[$id] = isset($children[$id]) && !empty($children[$id]) ? $children[$id] : array();
					$list[$id]->children = $count = count(@$children[$id]);
					if ($count && !isset($list[$id]->frist_children)){
						$list[$id]->frist_children = $children[$id][0];
					}
					$list[$id]->level = $level;
					$list = $this->menu_treerecurse($id,$list, $children, $maxlevel, $level + 1);
				}
			}
			return $list;
		}
	
	public function output($options=array(),$is_front_end = false,$args = array()){

		$this->settings = $options['settings'];
		$this->params = $options['params'];
		$this->front_end = !is_admin();
		$this->args = $args;
		
		$this->_render_menu_items($this->menu_items);
		
		$this->output .= $this->tmpl('beginmenu');
		$keys = array_keys($this->items);
	
		if(count($keys)){
			$this->output .= $this->_render_nav(null, $keys[0]);
		}
		$this->output .= $this->tmpl('endmenu');
	
	
		return $this->output;
	}
	
	
}