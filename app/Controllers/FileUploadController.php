<?php
// File sourced from week 6 lecture code

namespace App\Controllers;

use CodeIgniter\Controller;

class FileUploadController extends Controller
{
    public function __construct()
    {
        // Load the URL helper, it will be useful in the next steps
        // Adding this within the __construct() function will make it 
        // available to all views
        helper('url'); 

    }

    public function index()
    {
        return view('uploadform');
    }

    public function upload()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);


            // Store the file information in the database or perform other operations

            return $this->response->setJSON(['data' => $newName]);
        } else {
            return $this->response->setJSON(['data' => false]);
        }
    }
}
