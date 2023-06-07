<?php namespace App\Modules\Mypanel\Controllers;

use App\Modules\Mypanel\Models\MypanelModel;

class Login extends BaseController{
    
    public function index(){
        $data=[];
        if ($this->request->is('post')) {
            $array=array();
            $array['cff']=csrf_token();
            $array['cfv']=csrf_hash();
            $request = service('request');
            $postData = $request->getPost();


            $rules = [
                "loginid" => [
                    "label" => "Login ID", 
                    "rules" => "required|min_length[3]|max_length[100]"
                ],
                "loginpassword" => [
                    "label" => "Password", 
                    "rules" => "required|min_length[8]|max_length[20]"
                ]
            ];    
            if ($this->validate($rules)) {    
                $session = session();
                $mypanel = new MypanelModel();
                $email = $this->request->getVar('loginid');
                $password = $this->request->getVar('loginpassword');
                
                $data = $mypanel->where('ipy_email', (isset($email) && $email!='' ? $email : '-'))->first();

                if($data){
                    $pass = $data['ipy_password'];
                    $authenticatePassword = getPassword($password, $pass);
                    if($authenticatePassword){
                        $ses_data = [
                            'pnl_id' => $data['ipy_id'],
                            'pnl_name' => $data['ipy_name'],
                            'pnl_email' => $data['ipy_email'],
                            'pnl_otps' => $data['ipy_otps'],
                            'pnl_token' => $data['ipy_token'],
                        ];
                        $session->set('isAdmLogged',true);
                        $session->set('admUser',$ses_data);

                        $array['success']='<div class="alert alert-success alert-dismissible fade show" role="alert">
										<strong>Updated:</strong> You have successfully logged.
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button>
									</div>';
                                    $array['redirect']=site_url('/mypanel/dashboard');//
                    }else{
                        $array['errors'] = "Wrong login credential.";
                    }
                }else{
                    $array['errors'] = "Wrong login credential.";
                }
            } else {
                $array['errors'] = $this->validator->listErrors();
            }
            //echo json_encode($array);
            return $this->response->setJSON($array);
        }else{
            return view('App\Modules\Mypanel\Views\login-page',$data);
        }
    }
   


}

?>