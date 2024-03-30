<?php

namespace App\Controllers;

class NomNomController extends BaseController
{
    public function __construct()
    {
        // Load the URL helper, it will be useful in the next steps
        // Adding this within the __construct() function will make it 
        // available to all views in the PortfolioController
        helper('url'); 
    }

    public function index()
    {
        return view('landingpage');
    }

    public function login()
    {
        return view('login');
    }

    public function signup($step = null)
    {
        if ($step === null) {
            $data['step'] = 1;
        } else {
            $data['step'] = intval($step);
        }
        return view('signup', $data);
    }
}
