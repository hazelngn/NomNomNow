<?php

namespace App\Controllers;

/**
 * Class NomNomController
 *
 * The main controller for NomNomNow, containing
 * controller functions for all pages.
 * 
 */
class NomNomController extends BaseController
{
    public function __construct()
    {
        // $businessModel = new \App\Models\BusinessModel();
        // $userModel = new \App\Models\UserModel();
        helper('url'); 
        $this->session = session();
        // $this->userId = $this->session->get('userId');
        // if ($this->userId) {
        //     $this->user = $userModel->find($this->userId);
        //     $this->business = $businessModel->find($this->user['business_id']);
        // }
        // At the moment, every owner only has 1 business, this is only used when user is owner
    }

    /**
     * Controller method for the landing page.
     *
     * This method retrieves data based on the user's session and loads the appropriate view.
     *
     * @param int|null $id The ID parameter (optional).
     * @return View Returns a view for the landing page.
     */
    public function index($id = null)
    {
        if ($id == null && $this->session->get('usertype') != "owner"){
            return view('landingpage');
        } else {
            $businessModel = new \App\Models\BusinessModel();
            $userModel = new \App\Models\UserModel();
            $menuModel = new \App\Models\MenuModel();

            $userId = $this->session->get('userId');
            $user = $userModel->find($userId);
            $business = $businessModel->find($user['business_id']);
            $menus = $menuModel->where('business_id', $business['id'])->findAll();

            $data['menus'] = $menus;
            $data['business'] = $business;
            return view('business_landingpage', $data);
        }
    }


    /**
     * Controller method for the login page.
     *
     * @return View Returns a view for the login page.
     */
    public function login()
    {
        return view('login');
    }

    /**
     * Controller method for the business sign up page.
     * 
     * When user first registered on NomNomNow, they will be redirected to this page
     * to register their business
     *
     * @return View Returns a view for the business sign up page.
     */
    public function business_signup()
    {
        return view('signup');
    }

    /**
     * Controller method for displaying a menu.
     *
     * This method retrieves a menu based on the provided menu ID and loads the menu view.
     *
     * @param int $menuId The ID of the menu to display.
     * @return View Returns the menu view with the needed data
     */
    public function menu($menuId) {
        $businessModel = new \App\Models\BusinessModel();
        $userModel = new \App\Models\UserModel();
        $menuModel = new \App\Models\MenuModel();

        $userId = $this->session->get('userId');
        $user = $userModel->find($userId);
        $business = $businessModel->find($user['business_id']);

        $menu = $menuModel->find($menuId);

        // menu_viewing = TRUE disables the ability to edit/ delete menu items.
        $data['menu_viewing'] = TRUE;
        $data['menu'] = $menu;
        $data['business'] = $business;
        return view('menu_view', $data);
    }

    /**
     * Controller method for adding or editing a menu.
     *
     * This method allows users to add or edit a menu. It handles multiple steps of the menu creation process.
     * After completing the process, it redirects to the home page with a success message.
     *
     * @param int|null $menuId The ID of the menu to edit (optional).
     *                 When $menuId is null in step 1, it's adding a new menu. 
     *                      Otherwise, it's editing an existing menu
     * @param int|null $step The current step of the menu creation process (optional).
     *                 When $step is null, the process is in step 1
     * @return View|\CodeIgniter\HTTP\RedirectResponse  
     *          Returns the menu add/edit view with the needed data
     *          OR Redirects to the home page with a success message.
     **/
    public function menu_addedit($menuId = null, $step = null)
    {
        $businessModel = new \App\Models\BusinessModel();
        $userModel = new \App\Models\UserModel();
        $menuModel = new \App\Models\MenuModel();

        $userId = $this->session->get('userId');
        $user = $userModel->find($userId);
        $business = $businessModel->find($user['business_id']);

        $data['business'] = $business;


        if ($menuId != null) {
            $menu = $menuModel->find($menuId);
            $data['menu'] = $menu;
        }

        $data['step'] = $step == null ?  1 : ( intval($step) > 4 ? 1 : intval($step) );

        if ($step == 4) {
            $this->session->setFlashData('success', 'Menu created successfully');
            return redirect()->to("/");
        }

        return view('menu_addedit', $data);
    }

    /**
     * Controller method for displaying the customer view of a menu.
     *
     * This method retrieves the menu and business information based on the provided menu ID.
     * It then loads the customer_view view, passing along necessary data.
     *
     * @param int $menuId The ID of the menu to display.
     * @param int $tableNumber The table number associated with the customer view.
     * @return View|\CodeIgniter\HTTP\RedirectResponse  
     *       Returns the digital menu view for customer 
     *              or redirect to NomNomNow's landing page when the needed
     *              parameters are not defined
     *       OR Redirects to the homepage
     */
    public function customer_view($menuId, $tableNumber) {
        $menuModel = new \App\Models\MenuModel();
        $businessModel = new \App\Models\BusinessModel();

        $menu = $menuModel->find($menuId);
        $businessId = $menu['business_id'];
        $business = $businessModel->find($businessId);

        if (!$menu || !$tableNumber) {
            // Should redirect to no page found
            return redirect()->to("/");
        }


        $data['menu'] = $menu;
        $data['business'] = $business;
        // Display the check out cart
        $data['customer_view']= TRUE;
        // Disable the ability to edit items
        $data['menu_viewing'] = TRUE;
        $data['tableNum'] = $tableNumber;

        return view('customer_view', $data);    
    }

    /**
     * Controller method for the live order management page.
     *
     * @return View Returns a view for the order management page.
     */
    public function order_system() {
        return view('order_system');    
    }

    /**
     * Controller method for displaying the admin page.
     *
     * This method checks if a user ID is provided. If provided, it loads the admin view with business data.
     * If not provided, it loads the admin view without business data.
     *
     * @param int|null $userId The ID of the user (optional). 
     *                  This applies when the owner of a business navigates 
     *                  to their business admin page
     * @return View Returns a view for the admin page.
     */
    public function admin($userId = null) {
        if ($userId) {
            $businessModel = new \App\Models\BusinessModel();
            $userModel = new \App\Models\UserModel();
    
            $userId = $this->session->get('userId');
            $user = $userModel->find($userId);
            $business = $businessModel->find($user['business_id']);

            $data['business'] = $business;
            return view('admin', $data);    
        }
        return view('admin');    
    }

    /**
     * Controller method for handling the checkout process.
     *
     * This method retrieves order items from the session data and prepares data for the checkout view.
     * 
     * If the request method is POST, it saves order items to the session and returns a success response.
     * 
     * If order items are found in the session, it loads the checkout view with necessary data.
     * If no order items are found, it redirects to the home page.
     *
     * @return JSON|View|\CodeIgniter\HTTP\RedirectResponse 
     *          Returns a success JSON 
     *          OR Returns a view for the check out page
     *          OR redirects to homepage.
     */
    public function checkout() {

        $businessModel = new \App\Models\BusinessModel();
        $menuModel = new \App\Models\MenuModel();


        if ($this->request->getMethod() === 'post') {
            // Save data to session
            $postData = $this->request->getJSON();

            $this->session->set(['order_items' => json_encode($postData)]);
            return $this->response->setJSON(['success' => $postData]);
        }

        if ($this->session->get('order_items')) {
            $orderItems = json_decode($this->session->get('order_items'), true);
            // Retrieve needed data for the models
            foreach($orderItems as $item) {
                if (isset($item['menuId'])) {
                    $menuId = $item['menuId'];
                    $businessId = $item['businessId'];
                    $tableNum = $item['tableNum'];
                }
            };

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