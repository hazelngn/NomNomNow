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

    public function menu($resId, $step = null)
    {
        $businessModel = new \App\Models\BusinessModel();
        $menuModel = new \App\Models\MenuModel();
        $menuItemModel = new \App\Models\MenuItemModel();
        $categoryModel = new \App\Models\CategoryModel();
        $DietaryPreferencesModel = new \App\Models\DietaryPreferencesModel();
        $DietaryPrefItemModel = new \App\Models\DietaryPrefItemModel();

        $step == null ? $data['step'] = 1 : $data['step'] = intval($step);
        $data['business'] = $businessModel->find($resId);

        if ($this->request->getMethod() === 'post') {
            if ($step == '2') {
                $menu = $this->request->getPost();
                // $data['menu'] = $menu;
                $data['menu'] = $menuModel->find(1);
                $items = $menuItemModel->where('menu_id', 1)->findAll();
                foreach ($items as &$item) {
                    $diet_ids = $DietaryPrefItemModel->where('item_id', $item['id'])->findAll();
                    $dietaries = [];
                    foreach ($diet_ids as $id) {
                        $values = $DietaryPreferencesModel->where('id', $id['diet_pr_id'])->findColumn('name');
                        foreach ($values as $value) {
                            $dietaries[] = $value;
                        }
                    }
                    $item['dietaries'] = $dietaries;
                }
                $data['items'] = $items;
            }
        }
        
        // [', 'Sides', 'Main Dishes', 'Desserts', 'Alcoholic Beverage', 'Coffee & Tea', 'Soft Drinks'];
        return view('menu', $data);
    }
}
