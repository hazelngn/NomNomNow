<?php namespace App\Controllers\Rest_APIs;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EducationModel;

class Orders extends ResourceController
{
    use ResponseTrait;

    /**
     * Handle GET requests to list order entries or filter by order_id.
     */
    public function index()
    {
        $model = new \App\Models\OrderModel();

        // Retrieve 'order_id' from query parameters if provided.
        $orderId = $this->request->getGet('order_id');
        $page = $this->request->getGet('page');

        // Filter the data by order_id if provided, otherwise retrieve all entries.
        if ($page) {
            $data = $model->paginate(10, 'default', $page);
        } else {
            $data = $orderId ? $model->find($orderId) : $model->findAll();
        }
        

        // Use HTTP 200 to return data.
        return $this->respond($data);
    }

    /**
     * Handle GET requests to retrieve a single order entry by its ID.
     */
    public function show($id = null)
    {
        $model = new \App\Models\OrderModel();

        // Attempt to retrieve the specific order entry by ID.
        $data = $model->find($id);

        // Check if data was found.
        if ($data) {
            return $this->respond($data);
        } else {
            // Return a 404 error if no data is found.
            return $this->failNotFound("No order entry found with ID: {$id}");
        }
        
    }

    /**
     * Handle POST requests to create a new order entry.
     */
    public function create()
    {
        $model = new \App\Models\OrderModel();
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
            return $this->respondCreated($data, 'Order entry created successfully.');
        } else {
            return $this->failServerError('Failed to create Order entry.');
        }
    }

    /**
     * Handle PUT requests to update an existing order entry by its ID.
     */
    public function update($id = null)
    {
        $model = new \App\Models\OrderModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Check if the record exists before attempting update.
        if (!$model->find($id)) {
            return $this->failNotFound("No Order entry found with ID: {$id}");
        }

        
        // Update the record and handle the response.
        if ($model->update($id, $data)) {
            return $this->respondUpdated($data, 'Order entry updated successfully.');
        } else {
            return $this->failServerError('Failed to update Order entry.');
        }
    }

    /**
     * Handle DELETE requests to remove an existing order entry by its ID.
     */
    public function delete($id = null)
    {
        $model = new \App\Models\OrderModel();

        // Check if the record exists before attempting deletion.
        if (!$model->find($id)) {
            return $this->failNotFound("No Order entry found with ID: {$id}");
        }

        // Attempt to delete the record.
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Order entry deleted successfully.']);
        } else {
            return $this->failServerError('Failed to delete Order entry.');
        }
    }
}