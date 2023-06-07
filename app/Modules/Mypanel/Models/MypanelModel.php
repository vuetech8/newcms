<?php 
namespace App\Modules\Mypanel\Models;  
use CodeIgniter\Model;
  
class MypanelModel extends Model{
	protected $DBGroup              = 'default';
	protected $table                = 'mypanel';
	protected $primaryKey           = 'ipy_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['ipy_id','ipy_dept_id','ipy_role','ipy_title','ipy_name','ipy_gender','ipy_contact','ipy_thumbnail','ipy_address','ipy_email','ipy_password','ipy_status','ipy_access','ipy_data','ipy_otps','ipy_token','ipy_crby','ipy_crdate','ipy_mddate'];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'ipy_crdate';
	protected $updatedField         = 'ipy_mddate';
	protected $deletedField         = '';//deleted_at

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	function getData($param=array()){
		$builder = $this->db->table($param['table']);
		$builder->select('*');
		if(isset($param['id']) && $param['id']!=''){
			$builder->where('ipy_id',$param['id']);
		}
		if(isset($param['orderby']) && $param['orderby']!=''){
			$builder->orderBy($param['order'],$param['order']);
		}

		$query = $builder->get();

		return $query;
	}
	public function getNavigation($data=array()){
		$builder = $this->db->table('navigation nav');
		$builder->select('nav.*,parent.ipy_id as parent_id,parent.ipy_name as parent_name');
		$builder->join('navigation parent', 'parent.ipy_id = nav.ipy_parent','left');

		if(isset($data['id']) && $data['id']!=''){
			$builder->where('nav.ipy_id', $data['id']);
		}
		if(isset($data['status']) && $data['status']!=''){
			$builder->where('nav.ipy_status', $data['status']);
		}
		if(isset($data['orderby']) && $data['orderby']!=''){
			$builder->order_by($data['orderby'],$data['order']);
		}
		if(isset($data['groupby']) && $data['groupby']!=''){
			$builder->group_by($data['groupby']);
		}		
		$query = $builder->get();
		return $query;
	}
	function manageNav($post=array(),$actionfor=''){
		$db      = \Config\Database::connect();
		$builder = $db->table('mypanel_menu');

		if($actionfor=='add'){			
			$this->db->transStart();
			//$newslug=$this->my_function->create_AdminSlug('',(isset($post['name']) && $post['name']!='' ? $post['name'] : time()));
			$insertData=array(
				'ipy_parent'=>(isset($post['parent']) && $post['parent']!='' ? $post['parent'] : ''),
				'ipy_name'=>(isset($post['name']) && $post['name']!='' ? $post['name'] : ''),
				'ipy_slug'=>(isset($post['slug']) && $post['slug']!='' ? $post['slug'] : ''),
				'ipy_sorting'=>(isset($post['sorting']) && $post['sorting']!='' ? $post['sorting'] : ''),
				'ipy_status'=>(isset($post['status']) && $post['status']!='' ? $post['status'] : ''),
				'ipy_data'=>(isset($post) && !empty($post) ? json_encode($post) : ''),
				'ipy_crby'=>(isset($post['crby']) && $post['crby']!='' ? $post['crby'] : ''),
				'ipy_crdate'=>date("Y-m-d H:i:s")
			);
			$builder->insert($insertData);
			if ($this->db->transStatus() === TRUE){
				$this->db->transCommit();
				return 'success';
			}else{
				$this->db->transRollback();
				return 'Failed please try later 001';
			}
			$this->db->transComplete();
		}//add section end here
		if($actionfor=='update'){			
			$this->db->transStart();			
			$data=$this->getData(array('table'=>'mypanel_menu','id'=>(isset($post['editid']) && $post['editid']!='' ? $post['editid'] : '0')))->getRow();
			if(!empty($data)){
				$updateData=array(
					'ipy_parent'=>(isset($post['parent']) && $post['parent']!='' ? $post['parent'] : ''),
					'ipy_name'=>(isset($post['name']) && $post['name']!='' ? $post['name'] : ''),
					'ipy_slug'=>(isset($post['slug']) && $post['slug']!='' ? $post['slug'] : ''),
					'ipy_sorting'=>(isset($post['sorting']) && $post['sorting']!='' ? $post['sorting'] : ''),
					'ipy_status'=>(isset($post['status']) && $post['status']!='' ? $post['status'] : ''),
					'ipy_data'=>(isset($post) && !empty($post) ? json_encode($post) : ''),
					'ipy_mddate'=>date("Y-m-d H:i:s")
				);
				$builder->where('ipy_id', $data->ipy_id);
				$builder->update($updateData);
				
				if ($this->db->transStatus() === TRUE){
					$this->db->transCommit();
					return 'success';
				}else{
					$this->db->transRollback();
					return 'Failed please try later 001';
				}
			}else{
				$this->db->transRollback();
				return 'Failed please try later 002';
			}
			$this->db->transComplete();
		}
	}
	function manageNavigation($post=array(),$actionfor=''){
		$db      = \Config\Database::connect();
		$builder = $db->table('navigation');
		$dbSlug = $db->table('slug');
				
		if($actionfor=='add'){			
			$this->db->transStart();
			$newslug=create_slug('',(isset($post['data_name']) && $post['data_name']!='' ? $post['data_name'] : time()));
			$insertData=array(
				'ipy_slug'=>$newslug ?? '',
				'ipy_parent'=>$post['data_parent'] ?? '',
				'ipy_department'=>$post['data_department'] ?? '',
				'ipy_name'=>$post['data_name'] ?? '',
				'ipy_type'=>$post['data_type'] ?? '',
				'ipy_value'=>$post['data_pageid'] ?? '',
				'ipy_file'=>$post['data_file'] ?? '',
				'ipy_link'=>$post['data_link'] ?? '',
				'ipy_visible'=>$post['data_visible'] ?? '',
				'ipy_banner'=>$post['data_banner'] ?? '',
				'ipy_template'=>$post['data_template'] ?? '',
				'ipy_for'=>$post['data_for'] ?? '',
				'ipy_status'=>$post['data_status'] ?? '',
				'ipy_sorting'=>$post['data_sorting'] ?? '',
				'ipy_data'=>(isset($post) && !empty($post) ? json_encode($post) : ''),
				'ipy_crby'=>$post['crby'] ?? '',
				'ipy_crdate'=>date("Y-m-d H:i:s")
			);
			$builder->insert($insertData);
			$lastid = $db->insertID();
			if ($this->db->transStatus() === TRUE){
				$insertSlug=array(
					'ipy_parent'=>(isset($lastid) && $lastid!='' ? $lastid : ''),
					'ipy_slug'=>(isset($newslug) && $newslug!='' ? $newslug : ''),
					'ipy_name'=>$post['data_name'] ?? '',
					'ipy_table'=>'navigation',
					'ipy_status'=>$post['data_status'] ?? '',
					'ipy_crby'=>$post['crby'] ?? '',
					'ipy_crdate'=>date("Y-m-d H:i:s")
				);
				$dbSlug->insert($insertSlug);
				if ($this->db->transStatus() === TRUE){
					$this->db->transCommit();
					return 'success';
				}else{
					$this->db->transRollback();
					return 'Failed please try later 001';
				}
			}else{
				$this->db->transRollback();
				return 'Failed please try later 002';
			}
			$this->db->transComplete();
		}//add section end here
		if($actionfor=='update'){			
			$this->db->transStart();			
			$data=$this->getData(array('table'=>'navigation','id'=>(isset($post['editid']) && $post['editid']!='' ? $post['editid'] : '0')))->getRow();
			if(!empty($data)){
				$newslug=$post['oldslug'];
				if($post['newslug']!=$post['oldslug']){
					$newslug=create_slug('',(isset($post['newslug']) && $post['newslug']!='' ? $post['newslug'] : time()));
				}
				$updateData=array(
					'ipy_slug'=>$newslug ?? '',
					'ipy_parent'=>$post['data_parent'] ?? '',
					'ipy_department'=>$post['data_department'] ?? '',
					'ipy_name'=>$post['data_name'] ?? '',
					'ipy_type'=>$post['data_type'] ?? '',
					'ipy_value'=>$post['data_pageid'] ?? '',
					'ipy_file'=>$post['data_file'] ?? '',
					'ipy_link'=>$post['data_link'] ?? '',
					'ipy_visible'=>$post['data_visible'] ?? '',
					'ipy_banner'=>$post['data_banner'] ?? '',
					'ipy_template'=>$post['data_template'] ?? '',
					'ipy_for'=>$post['data_for'] ?? '',
					'ipy_status'=>$post['data_status'] ?? '',
					'ipy_sorting'=>$post['data_sorting'] ?? '',
					'ipy_data'=>(isset($post) && !empty($post) ? json_encode($post) : ''),
					'ipy_crby'=>$post['crby'] ?? '',
					'ipy_crdate'=>date("Y-m-d H:i:s")
				);
				$builder->where('ipy_id', $data->ipy_id);
				$builder->update($updateData);
				$lastid=$data->ipy_id;

				if ($this->db->transStatus() === TRUE){
					$updateSlug=array(
						'ipy_parent'=>(isset($lastid) && $lastid!='' ? $lastid : ''),
						'ipy_slug'=>(isset($newslug) && $newslug!='' ? $newslug : ''),
						'ipy_name'=>$post['data_name'] ?? '',
						'ipy_table'=>'navigation',
						'ipy_status'=>$post['data_status'] ?? '',
						'ipy_crby'=>$post['crby'] ?? '',
						'ipy_crdate'=>date("Y-m-d H:i:s")
					);
					$dbSlug->where('ipy_table', 'navigation');
					$dbSlug->where('ipy_parent', $lastid);
					$dbSlug->update($updateSlug);
					if ($this->db->transStatus() === TRUE){
						$this->db->transCommit();
						return 'success';
					}else{
						$this->db->transRollback();
						return 'Failed please try later 001';
					}
				}else{
					$this->db->transRollback();
					return 'Failed please try later 002';
				}
			}else{
				$this->db->transRollback();
				return 'Failed please try later 003';
			}
			$this->db->transComplete();
		}
	}

}