<?php namespace App\Modules\Mypanel\Controllers;

use App\Modules\Mypanel\Models\MypanelModel;
use App\Modules\Mypanel\Models\MypanelMenuModel;

class Action extends BaseController{
    public function __construct(){
        //getAdminAuth();
    }
    public function nav($for='',$actionid=''){
        $array=[];
        $array['cff']=csrf_token();
        $array['cfv']=csrf_hash();
        $request = service('request');
        $postData = $request->getPost();

        $rules = [
            "name" => [
                "label" => "Name", 
                "rules" => "required"
            ],
            "slug" => [
                "label" => "Password", 
                "rules" => "required"
            ],
            "status" => [
                "label" => "Status", 
                "rules" => "required"
            ],
            "sorting" => [
                "label" => "Sorting", 
                "rules" => "required"
            ]
        ];    
        if ($this->validate($rules)) {    
            $session = session();
            $mypanel = new MypanelModel();
            $email = $this->request->getVar('loginid');
            $password = $this->request->getVar('loginpassword');
            
            $tranStatus = $mypanel->manageNav($postData,$for);

            if($tranStatus=='success'){
                $array['success']='<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Updated:</strong> You have successfully updated.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                $array['redirect']=site_url('/mypanel/nav');
            }else{
                $array['errors'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">'.$tranStatus.'</div>';
            }
        } else {
            $array['errors'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">'.$this->validator->listErrors().'</div>';
        }

        
        return $this->response->setJSON($array);
    }
    public function navigation($for='',$actionid=''){
        $array=[];
        $array['cff']=csrf_token();
        $array['cfv']=csrf_hash();

        $mypanel = new MypanelModel();

        if (strtolower($this->request->getMethod()) == 'post') {
            //$request = service('request');
            $postData = $this->request->getPost(NULL);
            $rules = [
                "data_name" => ["label" => "Name", "rules" => "required"],
                "data_status" => ["label" => "Status", "rules" => "required"],
            ];

            if ($this->validate($rules)) {    
                $tranStatus = $mypanel->manageNavigation($postData,$for);

                if($tranStatus=='success'){
                    $array['success']='<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Updated:</strong> You have successfully updated.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                    $array['redirect']=site_url('/mypanel/navigation');
                }else{
                    $array['errors'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">'.$tranStatus.'</div>';
                }
            } else {
                $array['errors'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">'.$this->validator->listErrors().'</div>';
            }
        }

        
        return $this->response->setJSON($array);
    }

}

?>