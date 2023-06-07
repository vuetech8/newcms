<?php

    function getAdminMenuListPage($parentid='',$access='',$returnHTML='',$round=0){
        $baseurl=base_url();
        //$session_data = session()->get('admUser');
        $db      = \Config\Database::connect();
        
        $getCurrentPage='';
        $query = $db->query("SELECT a.ipy_id,a.ipy_parent, a.ipy_name, a.ipy_slug, a.ipy_sorting, a.ipy_status,a.ipy_crby, 
        a.ipy_crdate, a.ipy_mddate, (SELECT count(ipy_id) FROM ".$db->prefixTable('mypanel_menu')." pr WHERE a.ipy_id = pr.ipy_parent) Count
        FROM ".$db->prefixTable('mypanel_menu')." a  
        WHERE a.ipy_parent=" . $parentid." order by ipy_sorting asc, ipy_id asc");
        
        $returnHTML='<ul class="admin-menu-list-view" id="navigation-'.$round.'">';

        foreach ($query->getResult() as $result){
            $round++;
            $colorRow='';
            $menuStatus='';
            if($result->ipy_status==1){
                $colorRow='text-success';
                $menuStatus='<span class="text-success"><strong>(Active)</strong></span>';
            }else{
                $colorRow='text-danger';
                $menuStatus='<span class="text-danger"><strong>(Draft)</strong></span>';
            }
            if ($result->Count > 0) {
                $returnHTML.='<li class="has-sub '.$colorRow.'"><a href="#"><i class="feather icon-briefcase"></i>
                    <span class="menu-title" data-i18n="'.$result->ipy_name.'">'.$result->ipy_name.' '.$menuStatus.'</span></a>';
                    $returnHTML.='<div class="btn-group pull-right"><a href="'.site_url('mypanel/nav/edit/'.$result->ipy_id).'" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a><a href="'.site_url('mypanel/nav/delete/'.$result->ipy_id).'" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></div>';
                $returnHTML.=getAdminMenuListPage($result->ipy_id,$access,$returnHTML,$round);
                $returnHTML.='</li>';
            }else{
                $returnHTML.='<li '.(isset($getCurrentPage) && $getCurrentPage==$result->ipy_slug ? 'class="active '.$colorRow.'"' : 'class="'.$colorRow.'"').'><a href="'.site_url($result->ipy_slug).'"><i class="feather icon-mail"></i> <span class="menu-title" data-i18n="Email">'.$result->ipy_name.' '.$menuStatus.'</span></a>';
                $returnHTML.='<div class="btn-group pull-right"><a href="'.site_url('mypanel/nav/edit/'.$result->ipy_id).'" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a><a href="'.site_url('mypanel/nav/delete/'.$result->ipy_id).'" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></div>';
                $returnHTML.='</li>';
            }
        }
        $returnHTML.='</ul>';
        return $returnHTML;
    }
    function getSidebarMenu($parentid='',$returnHTML='',$round=0,$isChild=''){
        $baseurl=base_url();
        //$session_data = session()->get('admUser');
        $db      = \Config\Database::connect();
        
        $getCurrentPage='';
        $query = $db->query("SELECT a.ipy_id,a.ipy_parent, a.ipy_name, a.ipy_slug, a.ipy_sorting, a.ipy_status,a.ipy_crby, 
        a.ipy_crdate, a.ipy_mddate, (SELECT count(ipy_id) FROM ".$db->prefixTable('mypanel_menu')." pr WHERE a.ipy_id = pr.ipy_parent) Count
        FROM ".$db->prefixTable('mypanel_menu')." a  
        WHERE a.ipy_parent=" . $parentid." order by ipy_sorting asc, ipy_id asc");
        
        if($isChild=='yes'){
            $returnHTML='<div class="collapse" id="collapseLayouts-'.$round.'" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">';
            $returnHTML.='<nav class="sb-sidenav-menu-nested nav">';
        }else{
            $returnHTML='';
        }

        foreach ($query->getResult() as $result){
            $round++;
            $colorRow='';
            $menuStatus='';
            /*if($result->ipy_status==1){
                $colorRow='text-success';
                $menuStatus='<span class="text-success"><strong>(Active)</strong></span>';
            }else{
                $colorRow='text-danger';
                $menuStatus='<span class="text-danger"><strong>(Draft)</strong></span>';
            }*/
            if ($result->Count > 0) {
                $returnHTML.='<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts-'.$round.'" aria-expanded="false" aria-controls="collapseLayouts-'.$round.'">';
                $returnHTML.='<div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>';
                $returnHTML.=$result->ipy_name;
                $returnHTML.='<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>';
                $returnHTML.='</a>';
                $returnHTML.=getSidebarMenu($result->ipy_id,$returnHTML,$round,'yes');
            }else{
                //$returnHTML.='<li '.(isset($getCurrentPage) && $getCurrentPage==$result->ipy_slug ? 'class="active '.$colorRow.'"' : 'class="'.$colorRow.'"').'><a href="'.site_url($result->ipy_slug).'"><i class="feather icon-mail"></i> <span class="menu-title" data-i18n="Email">'.$result->ipy_name.' '.$menuStatus.'</span></a>';
                //$returnHTML.='<div class="btn-group pull-right"><a href="'.site_url('mypanel/nav/edit/'.$result->ipy_id).'" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a><a href="'.site_url('mypanel/nav/delete/'.$result->ipy_id).'" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></div>';
                //$returnHTML.='</li>';
                $returnHTML.='<a class="nav-link" href="'.site_url($result->ipy_slug).'">';
                $returnHTML.=$result->ipy_name;
                $returnHTML.='</a>';
            }
        }
        if($isChild=='yes'){
            $returnHTML.='</nav>';
            $returnHTML.='</div>';
        }
        //$returnHTML.='</ul>';
        return $returnHTML;
    }

    function getAdminAuth(){
        return true;
    }
    function adminBreadcum($id=''){
        $baseurl=base_url();
        $db      = \Config\Database::connect();
        $uri = service('uri');

		$slug='';
		if($id==''){
			$slug=(null!==($uri->getSegment(1)) && $uri->getSegment(1)!='' ? $uri->getSegment(1) : '').(null!==($uri->getSegment(2)) && $uri->getSegment(2)!='' ? '/'.$uri->getSegment(2) : '');//.(null!==($uri->getSegment(3)) && $uri->getSegment(3)!='' ? '/'.$uri->getSegment(3) : '');
		}
		if($slug!='' || $id!=''){
			$allname='';
			if($id!=''){
				$result=$db->query("select * from ".$db->prefixTable('mypanel_menu')." where ipy_id='".$id."'");
			}else{
				$result=$db->query("select * from ".$db->prefixTable('mypanel_menu')." where ipy_slug='".$slug."'");
			}
			
			//create a multidimensional array to hold a list of menu and parent menu
			$menu = array();
			//build the array lists with data from the menu table
			foreach($result->getResult() as $row){
				//creates entry into menus array with current menu id ie. $menus['menus'][1]
				
				//creates entry into parent_menus array. parent_menus array contains a list of all menus with children
				if($row->ipy_parent!='0'){
					$allname.=$menu['allname']=$row->ipy_name.',';
					$allname.=adminBreadcum($row->ipy_parent);
				}else{
					$allname.=$menu['allname']=$row->ipy_name;
				}
			}
		}
		return $allname;
	}
    function getSortingNav($parent='',$label='',$tablename='',$title='',$for=''){
        $baseurl=base_url();
        $db      = \Config\Database::connect();
        $uri = service('uri');

        $query = $db->query("SELECT a.ipy_id,a.ipy_parent, a.ipy_slug, a.ipy_name, a.ipy_type, a.ipy_value,a.ipy_sorting, (SELECT count(ipy_id) FROM ".$db->prefixTable($tablename)." pr WHERE a.ipy_id = pr.ipy_parent) Count,c.ipy_slug FROM ".$db->prefixTable($tablename)." a  
        LEFT OUTER JOIN ".$db->prefixTable('slug')." c ON a.ipy_id = c.ipy_parent
        WHERE a.ipy_parent=" . $parent." and a.ipy_for='".$for."' and c.ipy_table='navigation' and a.ipy_status='active' order by (CASE WHEN ipy_sorting='' OR ipy_sorting='0' then 9999999999 END), ipy_sorting asc, ipy_id asc");
        
        echo "<ul>";
        foreach ($query->getResult() as $result){
            if ($result->Count > 0) {
                    echo "<li class='has-sub'><input type='number' name='sortids[]' value='".$result->ipy_sorting."' class='sortno'/><input type='hidden' name='editsotingids[]' value='".$result->ipy_id."'/>&nbsp" . $result->$title. "";
                        getSortingNav($result->ipy_id, $label + 1,$tablename,$title,$for);
                    echo '</li>';
                }
            else{
                echo "<li><input type='number' name='sortids[]' value='".$result->ipy_sorting."' class='sortno'/><input type='hidden' name='editsotingids[]' value='".$result->ipy_id."'/>&nbsp". $result->$title. "</li>";
            }
        }
        echo '</ul>';
    }
    function totalParent($id,$table=''){
		$db      = \Config\Database::connect();
        $uri = service('uri');
		if($id!='' && $table!=''){
			$allid='';
			$result=$db->query("select * from ".$db->prefixTable($table)." where ipy_id=".$id."");
			//create a multidimensional array to hold a list of menu and parent menu
			$menu = array();
			//build the array lists with data from the menu table
			foreach($result->getResult() as $row){
				//creates entry into menus array with current menu id ie. $menus['menus'][1]
				$allid.=$menu['allid']=$row->ipy_id.' ';
				//creates entry into parent_menus array. parent_menus array contains a list of all menus with children
				if($row->ipy_parent!='0'){
					$allid.=totalParent($row->ipy_parent,$table);
				}
			}
		}
		return $allid;
	}
    function current_menu(){
		$db      = \Config\Database::connect();
        $uri = service('uri');

		$baseurl=base_url();
		$return=array();

		$getCurrentPage=(null!==($uri->getSegment(1)) && $uri->getSegment(1)!='' ? $uri->getSegment(1) : '').(null!==($uri->getSegment(2)) && $uri->getSegment(2)!='' ? '/'.$uri->getSegment(2) : '');
		
		$childParent = $db->query("SELECT * FROM ".$db->prefixTable('mypanel_menu')." where ipy_slug='".$getCurrentPage."'")->getRow();
		if(!empty($childParent)){
			$return['menu']=$childParent;
			$totalParent=totalParent($childParent->ipy_id,'mypanel_menu');
			$totalParent=(isset($totalParent) && $totalParent!='' ? explode(' ',$totalParent) : '');

			$return['parents']=$totalParent;
		}
		return $return;
	}
    function create_slug($id='', $name=''){
        $db      = \Config\Database::connect();
        $builder = $db->table('slug');
        $count = 0;
        $name = url_title($name);
        $slug_name = $name;             // Create temp name
        while(true) {
            $query=$db->query("SELECT * FROM ".$db->prefixTable('slug')." where ipy_slug='".$slug_name."'")->getRow();
            if (empty($query)) break;
            $slug_name = $name . '-' . (++$count);  // Recreate new temp name
        }
        return strtolower($slug_name);      // Return temp name
    }
?>