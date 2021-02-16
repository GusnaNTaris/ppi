<?php
function buildMenu()
{
	$menu = '';
	$CI =& get_instance();    
	$CI->load->model('admin/M_menu','',TRUE);
	
	$datas = $CI->M_menu->get_allowed_menu(0);
	
	foreach($datas->result() as $data)
	{
		if ($data->IS_PARENT == 0){
			$menu.= '<li><a href="#" onClick="return openUrl(\''.site_url($data->URL).'\');"><i class="fa fa-'.$data->ICON.'"></i> <span>'.$data->TITLE.'</span></a></li>';
		}else{
			$menu.= '<li class="treeview">
						  <a href="#">
							<i class="fa fa-'.$data->ICON.'"></i> <span>'.$data->TITLE.'</span> <i class="fa fa-angle-left pull-right"></i>
						  </a>
						  <ul class="treeview-menu">';
			$datasc = $CI->M_menu->get_allowed_menu($data->PAGE_ID);
			foreach($datasc->result() as $datac)
			{
				$menu.='<li><a href="#" onClick="return openUrl(\''.site_url($datac->URL).'\');">'.$datac->TITLE.'</a></li>';
			}
			$menu.=	'	  </ul>';
			$menu.= '</li>';
		}
	}
	
	return $menu;
}

function buildBreadcrumb()
{
	$out = '<li><a href="'.site_url().'"><i class="fa fa-home"></i> Home</a></li>';
	$CI =& get_instance();    
	$CI->load->model('admin/M_menu','',TRUE);
	$url = $CI->uri->uri_string();
	
	if ($url=='')
		$out.= '<li class="active"> Beranda</li>';
	else
	{
		$datas = $CI->M_menu->get_breadcrumb($url);
		foreach($datas->result() as $data)
		{
			if ($data->PARENT_ID == 0){
				$out.= '<li class="active"> '.$data->TITLE.'</li>';
			}else{
				$out.= '<li><a href="'.site_url($data->URL).'">'.$data->PTITLE.'</a></li>';
				$out.= '<li class="active">'.$data->TITLE.'</li>';
			}
		}
	}
	return $out;
}

function sortMenu()
{
	$menu = '';
	$CI =& get_instance();    	
	$CI->load->model('admin/M_menu','',TRUE);
	$datas = $CI->M_menu->get_child(0);
	
	foreach($datas->result() as $data)
	{
		$menu.= '<div class="s_panel" id="id_'.$data->PAGE_ID.'">
					<div class="h3">'.$data->TITLE.'
						<span class="pull-right">
						<a href="#" title="Edit" onClick="return editMenu('.$data->PAGE_ID.');"><i class="fa fa-edit fa-fw"></i></a>
						&nbsp;
						<a href="#" title="Hapus" onClick="return dropMenu('.$data->PAGE_ID.');"><i class="fa fa-trash fa-fw"></i></a>
						</span>
					</div>';
		if ($data->IS_PARENT == 1){
			$menu.= '<div>';
			$menu.= '	<ul class="sortable">';
			$datasc = $CI->M_menu->get_child($data->PAGE_ID);
			foreach($datasc->result() as $datac)
			{
				$menu.='<li class="ui-state-default" id="id_'.$datac->PAGE_ID.'"><span class="ui-icon ui-icon-arrowthick-2-n-s pull-left"></span>'.$datac->TITLE.'
							<span class="pull-right">
								<a href="#" title="Edit" onClick="return editMenu('.$datac->PAGE_ID.');"><i class="fa fa-edit fa-fw"></i></a>
								&nbsp;
								<a href="#" title="Hapus" onClick="return dropMenu('.$datac->PAGE_ID.');"><i class="fa fa-trash fa-fw"></i></a>
							</span>
						</li>';
			}
			$menu.= '	</ul>
					 </div>';
		}
		$menu.= '</div>';
	
	}
	
	return $menu;
}
?>