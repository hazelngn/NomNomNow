<?php

namespace App\Controllers;

class NomNomController extends BaseController
{
    public function __construct()
    {
        // Load the URL helper, it will be useful in the next steps
        // Adding this within the __construct() function will make it 
        // available to all views in the PortfolioController
        $businessModel = new \App\Models\BusinessModel();
        $userModel = new \App\Models\UserModel();
        helper('url'); 
        $this->session = session();
        // $this->session->destroy();
        $this->userId = $this->session->get('userId');
        if ($this->userId) {
            $this->user = $userModel->find($this->userId);
            $this->business = $businessModel->find($this->user['business_id']);
        }
        // At the moment, every owner only has 1 business, this is only used when user is owner
    }

    public function index($id = null)
    {
        if ($id == null && !$this->session->get('isLoggedIn')){
            return view('landingpage');
        } else {
            // $userId = $this->session->get('userId');
            $menuModel = new \App\Models\MenuModel();
            log_message('info', 'test: ' . json_encode($this->business));
            $menus = $menuModel->where('business_id', $this->business['id'])->findAll();
            $data['menus'] = $menus;
            $data['business'] = $this->business;
            return view('business_landingpage', $data);
        }
    }

    public function login()
    {
        return view('login');
    }

    public function business_signup()
    {
        return view('signup');
    }

    public function menu($menuId) {
        $menuModel = new \App\Models\MenuModel();
        $menu = $menuModel->find($menuId);

        $data['menu_viewing'] = TRUE;
        $data['menu'] = $menu;
        $data['business'] = $this->business;
        return view('menu_view', $data);
    }

    public function menu_addedit($menuId = null, $step = null)
    {
        $menuModel = new \App\Models\MenuModel();
        $dietaryPreferencesModel = new \App\Models\DietaryPreferencesModel();

        $prefs = $dietaryPreferencesModel->findAll();
        $data['business'] = $this->business;
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

    public function customer_view($menuId, $tableNumber) {
        $menuModel = new \App\Models\MenuModel();
        $businessModel = new \App\Models\BusinessModel();

        $menu = $menuModel->find($menuId);
        $businessId = $menu['business_id'];
        $business = $businessModel->find($businessId);

        if (!$menu) {
            // Should redirect to no page found
            return redirect()->to("/");
        }


        $data['menu'] = $menu;
        $data['business'] = $business;
        $data['customer_view']= TRUE;
        $data['menu_viewing'] = TRUE;
        $data['tableNum'] = $tableNumber;

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

        $businessModel = new \App\Models\BusinessModel();
        $menuModel = new \App\Models\MenuModel();


        if ($this->request->getMethod() === 'post') {
            $postData = $this->request->getJSON();

            $this->session->set(['order_items' => json_encode($postData)]);
            return $this->response->setJSON(['success' => $postData]);
        }

        // $businessModel = new \App\Models\BusinessModel();
        if ($this->session->get('order_items')) {
            $orderItems = json_decode($this->session->get('order_items'), true);
            foreach($orderItems as $item) {
                if (isset($item['menuId'])) {
                    // $businessId = $item['businessId'];
                    $menuId = $item['menuId'];
                    $businessId = $item['businessId'];
                    $tableNum = $item['tableNum'];
                }
            };

            // $business = $businessModel->find($businessId);

            $menu = $menuModel->find($menuId);
            $data['menu'] =  $menu;
            $business = $businessModel->find($businessId);
            $data['business'] = $business;
            $data['checkout'] = TRUE;
            $data['customer_view'] = TRUE;
            $data['tableNum'] = $tableNum;

            return view('checkout', $data);    
        } else {
            return redirect()->to(('/'));
        }
        
        
    }
}