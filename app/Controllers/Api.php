<?php

namespace App\Controllers;

class Api extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }
    public function autoupload(){
        helper(['form', 'url']);
        $array=[];
        $array['cff']=csrf_token();
        $array['cfv']=csrf_hash();

        $validationRule = [
            'fileup' => [
                'label' => 'File',
                'rules' => [
                    'uploaded[fileup]',
                    'is_image[fileup]',
                    'mime_in[fileup,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                    /*'max_size[fileup,100]',*/
                    /*'max_dims[fileup,1024,768]',*/
                ],
            ],
        ];
        if (! $this->validate($validationRule)) {
            $data['errors']=$this->validator->listErrors();
        } else {
            $img = $this->request->getFile('fileup');
            $img->move(FU_URL);
            //$path = $this->request->getFile('fileup')->store("public/uploads/");

            $array['filename'] = FU_URL.$img->getName();
            //$array['type']  = $img->getClientMimeType();
            $array['success']='Uploaded';
    
            //$save = $db->insert($data);
            //print_r('File has successfully uploaded');        
        }
        return $this->response->setJSON($array);
    }

}
