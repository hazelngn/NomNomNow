<?php namespace App\Controllers\Rest_APIs;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EducationModel;

class DietPrefItems extends ResourceController
{
    use ResponseTrait;

    /**
     * Handle GET requests to list education entries or filter by user_id.
     */
    public function index()
    {
        $model = new \App\Models\DietaryPrefItemModel();

        // Retrieve 'user_id' from query parameters if provided.
        $diet_pr_id = $this->request->getGet('diet_pr_id');
        $item_id = $this->request->getGet('item_id');

        // Filter the data by user_id if provided, otherwise retrieve all entries.
        $data = $item_id ? $model->where('item_id', $item_id)->findAll() : $model->findAll();
        $data = $diet_pr_id ? $model->where('diet_pr_id', $diet_pr_id)->findAll() : $model->findAll();

        // Use HTTP 200 to return data.
        return $this->respond($data);
    }

    public function show($item_id = null)
    {
        $model = new \App\Models\DietaryPrefItemModel();

        // Attempt to retrieve the specific education entry by ID.
        $data = $model->where('item_id', $item_id)->findAll();

        // Check if data was found.
        if ($data) {
            return $this->respond($data);
        } else {
            // Return a 404 error if no data is found.
            return $this->failNotFound("No Education entry found with ID: {$id}");
        }
        
    }

    /**
     * Handle POST requests to create a new education entry.
     */
    public function create()
    {
        $model = new \App\Models\DietaryPrefItemModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Validate input data before insertion.
        if (empty($data)) {
            return $this->failValidationErrors('No data provided.');
        }

        // Insert data and check for success.
        $inserted = $model->insert($data);
        // inserted is 0 when successful??
        // if ($inserted) {
        //     return $this->respondCreated($data, 'User data created successfully.');
        // } else {
        //     return $this->failServerError('Failed to create user data.');
        // }
    }

    /**
     * Handle PUT requests to update an existing education entry by its ID.
     */
    public function update($id = null)
    {
        $model = new \App\Models\DietaryPrefItemModel();
        // update based on item_id
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Check if the record exists before attempting update.
        if (!$model->where('item_id', $id)->findAll()) {
            return $this->failNotFound("No Users entry found with ID: {$id}");
        }

        // Update the record and handle the response.
        if ($model
        ->where('item_id', $id)
        ->set(['diet_pr_id' => $data['diet_pr_id']])
        ->update()) {
            return $this->respondUpdated($data, 'User data updated successfully.');
        } else {
            return $this->failServerError('Failed to update user data.');
        }
    }

}

