<?php namespace App\Controllers\Rest_APIs;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EducationModel;

class Businesses extends ResourceController
{
    use ResponseTrait;

    /**
     * Handle GET requests to business entries or filter by business_id.
     */
    public function index()
    {
        $model = new \App\Models\BusinessModel();

        // Retrieve 'user_id' from query parameters if provided.
        $businessId = $this->request->getGet('business_id');

        // Filter the data by user_id if provided, otherwise retrieve all entries.
        $data = $businessId ? $model->where('id', $businessId)->findAll() : $model->findAll();

        // Use HTTP 200 to return data.
        return $this->respond($data);
    }

    /**
     * Handle GET requests to retrieve a single business entry by its ID.
     */
    public function show($id = null)
    {
        $model = new \App\Models\BusinessModel();

        // Attempt to retrieve the specific Business entry by ID.
        $data = $model->find($id);

        // Check if data was found.
        if ($data) {
            // Since only file name is stored in the database, this block
            // reads the file and pass it as base64
            if ($data['logo']) {
                $imagePath = WRITEPATH . 'uploads/' . $data['logo'];
                $data['logoURL'] = $data['logo'];
                $data['logo'] = base64_encode(file_get_contents($imagePath));
            }
            return $this->respond($data);
        } else {
            // Return a 404 error if no data is found.
            return $this->failNotFound("No Business entry found with ID: {$id}");
        }
        
    }

    /**
     * Handle POST requests to create a new Business entry.
     */
    public function create()
    {
        $model = new \App\Models\BusinessModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Validate input data before insertion.
        if (empty($data)) {
            return $this->failValidationErrors('No data provided.');
        }

        // Insert data and check for success.
        $inserted = $model->insert($data);
        if ($inserted) {
            $id = $model->getInsertID();
            $data = $model->find($id);
            return $this->respondCreated($data, 'Business entry created successfully.');
        } else {
            return $this->failServerError('Failed to create Business entry.');
        }
    }

    /**
     * Handle PUT requests to update an existing Business entry by its ID.
     */
    public function update($id = null)
    {
        $model = new \App\Models\BusinessModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Check if the record exists before attempting update.
        if (!$model->find($id)) {
            return $this->failNotFound("No Business entry found with ID: {$id}");
        }

        // Update the record and handle the response.
        if ($model->update($id, $data)) {
            return $this->respondUpdated($data, 'Business entry updated successfully.');
        } else {
            return $this->failServerError('Failed to update Business entry.');
        }
    }

    /**
     * Handle DELETE requests to remove an existing Business entry by its ID.
     */
    public function delete($id = null)
    {
        $model = new \App\Models\BusinessModel();

        // Check if the record exists before attempting deletion.
        if (!$model->find($id)) {
            return $this->failNotFound("No Users entry found with ID: {$id}");
        }

        // Attempt to delete the record.
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Business entry deleted successfully.']);
        } else {
            return $this->failServerError('Failed to delete Business entry.');
        }
    }
}