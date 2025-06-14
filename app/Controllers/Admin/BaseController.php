<?php

namespace App\Controllers\Admin;

use PHPFramework\Controller;

class BaseController extends Controller
{

    public string $layout = 'admin';

    public function __construct()
    {
        if (!is_admin()) {
            session()->setFlash('error', 'Forbidden');
            response()->redirect(base_url('/'));
        }
    }

}