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
        $this->session = session();
    }

    public function index($id = null)
    {
        if ($id == null && !$this->session->get('isLoggedIn')){
            return view('landingpage');
        } else {
            return view('business_landingpage');
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

    public function menu() {
        $json = file_get_contents("content.json");
        $data = json_decode($json, true);
        $data['preview'] = TRUE;
        return view('menu_view', $data);
    }

    public function menu_addedit($menuId = null, $step = null)
    {
        $businessModel = new \App\Models\BusinessModel();
        $menuModel = new \App\Models\MenuModel();
        $menuItemModel = new \App\Models\MenuItemModel();
        $categoryModel = new \App\Models\CategoryModel();
        $DietaryPreferencesModel = new \App\Models\DietaryPreferencesModel();
        $DietaryPrefItemModel = new \App\Models\DietaryPrefItemModel();


        if ($menuId != null) {
            $menu = $menuModel->find($menuId);
            $data['menu'] = $menu;
        }
        $step == null ? $data['step'] = 1 : $data['step'] = intval($step);

        
        return view('menu_addedit', $data);
    }

    public function customer_view($resId) {
        $json = file_get_contents("content.json");
        $data = json_decode($json, true);
        $data['preview'] = TRUE;
        $data['customer_view']= TRUE;
        return view('customer_view', $data);    
    }

    public function order_system() {
        $json = file_get_contents("content.json");
        $data = json_decode($json, true);
        return view('order_system', $data);    
    }

    public function admin() {
        $json = file_get_contents("content.json");
        $data = json_decode($json, true);
        return view('admin', $data);    
    }
}