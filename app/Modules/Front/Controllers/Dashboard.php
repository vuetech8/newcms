<?php namespace App\Modules\Front\Controllers;

use App\Modules\Front\Models\UserModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    private $userModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
	{
		$data = [
		    'title' => 'Dashboard Page',
            'view' => 'front/dashboard',
            'data' => $this->userModel->getUsers(),
        ];

		return view('template/layout', $data);
	}

}
