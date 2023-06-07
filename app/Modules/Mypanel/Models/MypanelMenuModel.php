<?php 
namespace App\Modules\Mypanel\Models;  
use CodeIgniter\Model;
  
class MypanelMenuModel extends Model{
	protected $DBGroup              = 'default';
	protected $table                = 'mypanel_menu';
	protected $primaryKey           = 'ipy_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['ipy_id','ipy_parent','ipy_name','ipy_slug','ipy_sorting','ipy_status','ipy_data','ipy_crby','ipy_crdate','ipy_mddate'];

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


}