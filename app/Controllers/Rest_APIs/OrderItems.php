<?php namespace App\Controllers\Rest_APIs;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EducationModel;

class OrderItems extends ResourceController
{
    use ResponseTrait;

    /**
     * Handle GET requests to list order item entries or filter by irder_item_id.
     */
    public function index()
    {
        $model = new \App\Models\OrderItemModel();

        // Retrieve 'irder_item_id' from query parameters if provided.
        $order_item_id = $this->request->getGet('order_item_id');

        // Filter the data by irder_item_id if provided, otherwise retrieve all entries.
        $data = $order_item_id ? $model->where('id', $order_item_id)->findAll() : $model->findAll();

        // Use HTTP 200 to return data.
        return $this->respond($data);
    }

    /**
     * Handle GET requests to retrieve a single order item entry by its ID.
     */
    public function show($id = null)
    {
        $model = new \App\Models\OrderItemModel();

        // Attempt to retrieve the specific order item entry by ID.
        $data = $model->find($id);

        // Check if data was found.
        if ($data) {
            return $this->respond($data);
        } else {
            // Return a 404 error if no data is found.
            return $this->failNotFound("No order item entry found with ID: {$id}");
        }
        
    }

    /**
     * Handle POST requests to create a new order item entry.
     */
    public function create()
    {
        $model = new \App\Models\OrderItemModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Validate input data before insertion.
        if (empty($data)) {
            return $this->failValidationErrors('No data provided.');
        }

        // Insert data and check for success.
        $inserted = $model->insert($data);
        if ($inserted) {
            return $this->respondCreated($data, 'Order item entry created successfully.');
        } else {
            return $this->failServerError('Failed to create Order item entry.');
        }
    }

    /**
     * Handle PUT requests to update an existing order item entry by its ID.
     */
    public function update($id = null)
    {
        $model = new \App\Models\OrderItemModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Check if the record exists before attempting update.
        if (!$model->find($id)) {
            return $this->failNotFound("No Order Item entry found with ID: {$id}");
        }

        // Update the record and handle the response.
        if ($model->update($id, $data)) {
            return $this->respondUpdated($data, 'Order item entry updated successfully.');
        } else {
            return $this->failServerError('Failed to update Order item entry.');
        }
    }

    /**
     * Handle DELETE requests to remove an existing order item entry by its ID.
     */
    public function delete($id = null)
    {
        $model = new \App\Models\OrderItemModel();

        // Check if the record exists before attempting deletion.
        if (!$model->find($id)) {
            return $this->failNotFound("No Order Item entry found with ID: {$id}");
        }

        // Attempt to delete the record.
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Order item entry deleted successfully.']);
        } else {
            return $this->failServerError('Failed to delete Order item entry.');
        }
    }
}