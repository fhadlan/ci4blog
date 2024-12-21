<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Faker\Extension\Helper;

class BlogController extends BaseController
{
    protected $helpers = ['form', 'url', 'CIMail', 'CIFunctions'];
    public function index()
    {
        $data = [
            'pageTitle' => get_settings()->blog_title
        ];
        return view('frontend/example.php', $data);
    }
}
