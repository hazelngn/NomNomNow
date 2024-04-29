<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\Config\Services;

class OwnerFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = Services::session();
        
        // Check if the user is not logged in
        if (!($session->get('usertype') == "owner")) {
            // Prepare a response object to return a message
            $response = Services::response();
            $response->setStatusCode(401); // You can set this to 401 if it's an unauthorized access
            $response->setBody("Access Denied");
            return redirect()->to('/'); // Return the response object with the message
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after the controller method is executed
    }
}