<?php namespace App\Controllers\Rest_APIs;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EducationModel;

class Categories extends ResourceController
{
    use ResponseTrait;

    /**
     * Handle GET requests to list category entries or filter by user_id.
     */
    public function index()
    {
        $model = new \App\Models\CategoryModel();

        // Retrieve 'category_id' from query parameters if provided.
        $categoryId = $this->request->getGet('category_id');

        // Filter the data by category_id if provided, otherwise retrieve all entries.
        $data = $categoryId ? $model->where('id', $categoryId)->findAll() : $model->findAll();

        // Use HTTP 200 to return data.
        return $this->respond($data);
    }

    /**
     * Handle GET requests to retrieve a single category entry by its ID.
     */
    public function show($id = null)
    {
        $model = new \App\Models\CategoryModel();

        // Attempt to retrieve the specific category entry by ID.
        $data = $model->find($id);

        // Check if data was found.
        if ($data) {
            return $this->respond($data);
        } else {
            // Return a 404 error if no data is found.
            return $this->failNotFound("No category entry found with ID: {$id}");
        }
        
    }

    /**
     * Handle POST requests to create a new category entry.
     */
    public function create()
    {
        $model = new \App\Models\CategoryModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Validate input data before insertion.
        if (empty($data)) {
            return $this->failValidationErrors('No data provided.');
        }

        // Insert data and check for success.
        $inserted = $model->insert($data);
        if ($inserted) {
            return $this->respondCreated($data, 'Category entry created successfully.');
        } else {
            return $this->failServerError('Failed to create Category entry.');
        }
    }

    /**
     * Handle PUT requests to update an existing category entry by its ID.
     */
    public function update($id = null)
    {
        $model = new \App\Models\CategoryModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Check if the record exists before attempting update.
        if (!$model->find($id)) {
            return $this->failNotFound("No Category entry found with ID: {$id}");
        }

        // Update the record and handle the response.
        if ($model->update($id, $data)) {
            return $this->respondUpdated($data, 'Category entry updated successfully.');
        } else {
            return $this->failServerError('Failed to update Category entry.');
        }
    }

    /**
     * Handle DELETE requests to remove an existing category entry by its ID.
     */
    public function delete($id = null)
    {
        $model = new \App\Models\CategoryModel();

        // Check if the record exists before attempting deletion.
        if (!$model->find($id)) {
            return $this->failNotFound("No Category entry found with ID: {$id}");
        }

        // Attempt to delete the record.
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Category entry deleted successfully.']);
        } else {
            return $this->failServerError('Failed to delete Category entry.');
        }
    }
}