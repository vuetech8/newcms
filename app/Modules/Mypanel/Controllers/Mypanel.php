<?php namespace App\Modules\Mypanel\Controllers;

use App\Modules\Mypanel\Models\MypanelModel;
use App\Modules\Mypanel\Models\MypanelMenuModel;

class Mypanel extends BaseController{
    
    public function index(){
        echo 'This is my panel index dashboard mytpanel url auth';
    }
    public function dashboard($for=''){
        if(!has_permission()){echo show_404();}
		getAdminAuth();
        $session = session();
		$mypanel = new MypanelModel();
		$data['style']='';
		$data['script']='';
		$data['subview']='Welcome to Dashboard';

        return view('App\Modules\Mypanel\Views\_layout_main-page',$data);
    }
	public function logout(){
        $session = session();
        $session->destroy();
        return redirect()->to('/mypanel/login');
    }
    public function nav($for='',$actionid=''){
		if(!has_permission()){echo show_404();}
		getAdminAuth();
        $session = session();
		$mypanel = new MypanelModel();
		$mypanelMenu = new MypanelMenuModel();
		$data['style']='';
		$data['script']='';
		if($for=='edit'){
			if(!has_permission('edit')){echo show_404();}
			$data['action']='edit';
			$data['edit']=$mypanel->getData(array('table'=>'mypanel_menu','id'=>(isset($actionid) && $actionid!='' ? $actionid : '0')))->getRow();
		}
		if ($for=='delete' && $actionid!='') {
			$mypanelMenu->where('ipy_id', $actionid)->delete();
			$session->setFlashdata('getSuccess', '<div class="alert alert-success text-center">Delete Succesfully!</div>');
			return redirect()->to('/mypanel/nav');
		}
		$data['parent']=$mypanel->getData(array('table'=>'mypanel_menu'))->getResult();
		$data['subview']=view('App\Modules\Mypanel\Views\admin-menu-page',$data);

        return view('App\Modules\Mypanel\Views\_layout_main-page',$data);
	}
	public function navigation($for='',$actionid=''){
		if(!has_permission()){echo show_404();}
		getAdminAuth();
        $session = session();
		$mypanel = new MypanelModel();
		$data['style']='';
		$data['script']='';
		$data['parent']=$mypanel->getNavigation(array('status'=>'active'))->getResult();
		$data['current_menu']=current_menu();
		$data['pages']=$mypanel->getData(array('table'=>'pages','status'=>'active'))->getRow();
		if($for=='add'){
			if(!has_permission('add')){echo show_404();}
			$data['subview']=view('App\Modules\Mypanel\Views\navigation/add-navigation-page',$data);
		}else if($for=='edit' && $actionid!=''){
			if(!has_permission('edit')){echo show_404();}
			$data['edit']=$mypanel->getData(array('table'=>'navigation','id'=>(isset($actionid) && $actionid!='' ? $actionid : '0')))->getRow();
			$data['subview']=view('App\Modules\Mypanel\Views\navigation/edit-navigation-page',$data);
		}else if ($for=='delete' && $actionid!='') {
			$db      = \Config\Database::connect();
			$builder = $db->table('navigation');
			$builder->where('ipy_id', $actionid)->delete();
			$session->setFlashdata('getSuccess', '<div class="alert alert-success text-center">Delete Succesfully!</div>');
			return redirect()->to('/mypanel/navigation');
		}else{
			$data['navigation']=$mypanel->getNavigation(array('status'=>'active'))->getResult();
			$data['subview']=view('App\Modules\Mypanel\Views\navigation/navigation-list-page',$data);
		}
		

        return view('App\Modules\Mypanel\Views\_layout_main-page',$data);
	}
}

?>