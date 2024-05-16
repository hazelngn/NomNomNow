<?php namespace App\Controllers\Rest_APIs;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Customers extends ResourceController
{
    use ResponseTrait;

    /**
     * Handle GET requests to list users entries or filter by customer_id.
     */
    public function index()
    {
        $model = new \App\Models\CustomerModel();

        // Retrieve 'customer_id' from query parameters if provided.
        $customerId = $this->request->getGet('customer_id');

        // Filter the data by customer_id if provided, otherwise retrieve all entries.
        $data = $customerId ? $model->where('id', $customerId)->findAll() : $model->findAll();

        // Use HTTP 200 to return data.
        return $this->respond($data);
    }

    /**
     * Handle GET requests to retrieve a single customer entry by its ID.
     */
    public function show($id = null)
    {
        $model = new \App\Models\CustomerModel();

        // Attempt to retrieve the specific customer entry by ID.
        $data = $model->find($id);

        // Check if data was found.
        if ($data) {
            return $this->respond($data);
        } else {
            // Return a 404 error if no data is found.
            return $this->failNotFound("No customer entry found with ID: {$id}");
        }
        
    }

    /**
     * Handle POST requests to create a new customer entry.
     */
    public function create()
    {
        $model = new \App\Models\CustomerModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Validate input data before insertion.
        if (empty($data)) {
            return $this->failValidationErrors('No data provided.');
        }

        // Insert data and check for success.
        $inserted = $model->insert($data);
        $id = $model->getInsertID();
        $data = $model->find($id);
        
        if ($inserted) {
            $response = $this->respondCreated($data, 'User entry created successfully.');
            $response->setHeader(csrf_token(), csrf_hash());
            return $response;
            // return $this->respondCreated($data, 'Customer data created successfully.');
        } else {
            return $this->failServerError('Failed to create Customer data.');
        }
    }

    /**
     * Handle PUT requests to update an existing customer entry by its ID.
     */
    public function update($id = null)
    {
        $model = new \App\Models\CustomerModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Check if the record exists before attempting update.
        if (!$model->find($id)) {
            return $this->failNotFound("No Customer entry found with ID: {$id}");
        }

        // Update the record and handle the response.
        if ($model->update($id, $data)) {
            return $this->respondUpdated($data, 'Customer data updated successfully.');
        } else {
            return $this->failServerError('Failed to update Customer data.');
        }
    }

    /**
     * Handle DELETE requests to remove an existing customer entry by its ID.
     */
    public function delete($id = null)
    {
        $model = new \App\Models\CustomerModel();

        // Check if the record exists before attempting deletion.
        if (!$model->find($id)) {
            return $this->failNotFound("No Users entry found with ID: {$id}");
        }

        // Attempt to delete the record.
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Customer data deleted successfully.']);
        } else {
            return $this->failServerError('Failed to delete Customer data.');
        }
    }
}