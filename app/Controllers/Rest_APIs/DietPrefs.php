<?php namespace App\Controllers\Rest_APIs;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EducationModel;

class DietPrefs extends ResourceController
{
    use ResponseTrait;

    /**
     * Handle GET requests to list dietary preference entries or filter by diet_pr_id.
     */
    public function index()
    {
        $model = new \App\Models\DietaryPreferencesModel();

        // Retrieve 'diet_pr_id' from query parameters if provided.
        $diet_pr_id = $this->request->getGet('diet_pr_id');

        // Filter the data by diet_pr_id if provided, otherwise retrieve all entries.
        $data = $diet_pr_id ? $model->where('id', $diet_pr_id)->findAll() : $model->findAll();

        // Use HTTP 200 to return data.
        return $this->respond($data);
    }

    /**
     * Handle GET requests to retrieve a single dietary preference entry by its ID.
     */
    public function show($id = null)
    {
        $model = new \App\Models\DietaryPreferencesModel();

        // Attempt to retrieve the specific dietary preference entry by ID.
        $data = $model->find($id);

        // Check if data was found.
        if ($data) {
            return $this->respond($data);
        } else {
            // Return a 404 error if no data is found.
            return $this->failNotFound("No dietary preference entry found with ID: {$id}");
        }
        
    }

    /**
     * Handle POST requests to create a new education entry.
     */
    public function create()
    {
        $model = new \App\Models\DietaryPreferencesModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Validate input data before insertion.
        if (empty($data)) {
            return $this->failValidationErrors('No data provided.');
        }

        // Insert data and check for success.
        $inserted = $model->insert($data);
        if ($inserted) {
            return $this->respondCreated($data, 'Dietary preference entry created successfully.');
        } else {
            return $this->failServerError('Failed to create Dietary preference entry.');
        }
    }

    /**
     * Handle PUT requests to update an existing dietary preference entry by its ID.
     */
    public function update($id = null)
    {
        $model = new \App\Models\DietaryPreferencesModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Check if the record exists before attempting update.
        if (!$model->find($id)) {
            return $this->failNotFound("No Dietary preference entry  found with ID: {$id}");
        }

        // Update the record and handle the response.
        if ($model->update($id, $data)) {
            return $this->respondUpdated($data, 'Dietary preference entry updated successfully.');
        } else {
            return $this->failServerError('Failed to update Dietary preference entry.');
        }
    }

    /**
     * Handle DELETE requests to remove an existing dietary preference entry by its ID.
     */
    public function delete($id = null)
    {
        $model = new \App\Models\DietaryPreferencesModel();

        // Check if the record exists before attempting deletion.
        if (!$model->find($id)) {
            return $this->failNotFound("No Dietary preference entry found with ID: {$id}");
        }

        // Attempt to delete the record.
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Dietary preference entry deleted successfully.']);
        } else {
            return $this->failServerError('Failed to delete Dietary preference entry.');
        }
    }
}