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
            $userId = $this->session->get('userId');
            $businessModel = new \App\Models\BusinessModel();
            $menuModel = new \App\Models\MenuModel();
            $business = $businessModel->where('user_id', $userId)->first();
            $menus = $menuModel->where('business_id', $business['id'])->findAll();
            $data['menus'] = $menus;
            $data['business'] = $business;
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

    public function menu($menuId) {
        $menuModel = new \App\Models\MenuModel();
        $businessModel = new \App\Models\BusinessModel();

        $menu = $menuModel->find($menuId);
        $businessId = $menu['business_id'];
        $business = $businessModel->find($businessId);

        $data['menu_viewing'] = TRUE;
        $data['menu'] = $menu;
        $data['business'] = $business;
        return view('menu_view', $data);
    }

    public function menu_addedit($menuId = null, $step = null)
    {
        $businessModel = new \App\Models\BusinessModel();
        $menuModel = new \App\Models\MenuModel();
        $dietaryPreferencesModel = new \App\Models\DietaryPreferencesModel();

        $userId = $this->session->get('userId');
        $business = $businessModel->where('user_id', $userId)->first();
        $prefs = $dietaryPreferencesModel->findAll();
        $data['business'] = $business;
        $data['prefs'] = $prefs;


        if ($menuId != null) {
            $menu = $menuModel->find($menuId);
            $data['menu'] = $menu;
        }

        $step == null ? $data['step'] = 1 : $data['step'] = intval($step);

        if ($step == 4) {
            $this->session->setFlashData('success', 'Menu created successfully');
            return redirect()->to("/");
        }

        return view('menu_addedit', $data);
    }

    public function customer_view($menuId) {
        $businessModel = new \App\Models\BusinessModel();
        $menuModel = new \App\Models\MenuModel();

        $menu = $menuModel->find($menuId);
        if (!$menu) {
            // Should redirect to no page found
            return redirect()->to("/");
        }
        $business = $businessModel->find($menu['business_id']);
        $data['menu'] = $menu;
        $data['business'] = $business;

        $data['customer_view']= TRUE;
        $data['menu_viewing'] = TRUE;

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

    public function checkout() {

        if ($this->request->getMethod() === 'post') {
            $postData = $this->request->getJSON();

            $this->session->set(['order_items' => json_encode($postData)]);
            return $this->response->setJSON(['success' => $postData]);
        }

        $businessModel = new \App\Models\BusinessModel();
        if ($this->session->get('order_items')) {
            $orderItems = json_decode($this->session->get('order_items'), true);
            foreach($orderItems as $item) {
                if (isset($item['businessId'])) {
                    $businessId = $item['businessId'];
                    $menuId = $item['menuId'];
                }
            };
            $business = $businessModel->find($businessId);
            $data['menuId'] =  $menuId;
            $data['business'] = $business;
            $data['checkout'] = TRUE;
            return view('checkout', $data);    
        } else {
            return redirect()->to(('/'));
        }
        
        
    }
}