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

    public function index($name = null)
    {
        if ($name == null ){
            return view('landingpage');
        } else {
            $data['businessName'] = $name;
            return view('business_landingpage', $data);
        }
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

    public function menu($id = null)
    {
        $data['menu'] = null;
        $data['businessName'] = 'haeduri';
        $data['categories'] = [
            'Entrees' => 'images/menu/entrees.png',
            'Sides' => 'images/menu/sides.png',
            'Main Dishes' => 'images/menu/maindish.png',
            'Desserts' => 'images/menu/dessert.png',
            'Alcoholic Beverages' => 'images/menu/alcoholicBV.png',
            'Coffee & Tea' => 'images/menu/coffee&tea.png',
            'Soft Drinks' => 'images/menu/softdrink.png',
            
        ];
        $data['step'] = 2;
        // [', 'Sides', 'Main Dishes', 'Desserts', 'Alcoholic Beverage', 'Coffee & Tea', 'Soft Drinks'];
        return view('menu', $data);
    }
}
