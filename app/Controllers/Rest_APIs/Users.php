<?php namespace App\Controllers\Rest_APIs;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EducationModel;

class Users extends ResourceController
{
    use ResponseTrait;

    /**
     * Handle GET requests to list education entries or filter by user_id.
     */
    public function index()
    {
        $model = new \App\Models\UserModel();
        $pager = \Config\Services::pager();

        // Retrieve 'user_id' from query parameters if provided.
        $userId = $this->request->getGet('user_id');

        // Retrieve 'business_id' from query parameters if provided.
        $businessId = $this->request->getGet('business_id');

        // Retrieve 'page' from query parameters if provided.
        $page = $this->request->getGet('page')??1;


        // Filter the data by user_id if provided, otherwise retrieve all entries.
        $data = $userId ? $model->find('id', $userId) : $model->paginate(3, 'default', $page);

        // When business_id is provided, only return users from that business
        if ($businessId){
            $data = $model->where('business_id', $businessId)->paginate(3, 'default', $page);
            // $businessUsers = $businessModel->where('user_id', )
        }
        
        // When the page required goes over the existing page numbers
        if ($page > $model->pager->getPageCount()) {
            $data = [];
        }
        // Use HTTP 200 to return data.
        return $this->respond($data);
    }

    /**
     * Handle GET requests to retrieve a single user entry by its ID.
     */
    public function show($id = null)
    {
        $model = new \App\Models\UserModel();

        // Attempt to retrieve the specific user entry by ID.
        $data = $model->find($id);

        // Check if data was found.
        if ($data) {
            return $this->respond($data);
        } else {
            // Return a 404 error if no data is found.
            return $this->failNotFound("No user entry found with ID: {$id}");
        }
        
    }

    /**
     * Handle POST requests to create a new user entry.
     */
    public function create()
    {
        $model = new \App\Models\UserModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Validate input data before insertion.
        if (empty($data)) {
            return $this->failValidationErrors('No data provided.');
        }

        // Insert data and check for success.
        $inserted = $model->insert($data);
        if ($inserted) {
            return $this->respondCreated($data, 'User entry created successfully.');
        } else {
            return $this->failServerError('Failed to create User entry.');
        }
    }

    /**
     * Handle PUT requests to update an existing user entry by its ID.
     */
    public function update($id = null)
    {
        $model = new \App\Models\UserModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Check if the record exists before attempting update.
        if (!$model->find($id)) {
            return $this->failNotFound("No Users entry found with ID: {$id}");
        }

        // Update the record and handle the response.
        if ($model->update($id, $data)) {
            $data = $model->find($id);
            // if (sesison()->get('userId') == $id) {
            //     // session()->set([
            //     //     'usertype' => $data['usertype']
            //     // ]);
            //     log_mesasge('info', 'usertype: '. sesison()->get('usertype'));
            // }
            return $this->respondUpdated($data, 'User entry updated successfully.');
        } else {
            return $this->failServerError('Failed to update User entry.');
        }
    }

    /**
     * Handle DELETE requests to remove an existing user entry by its ID.
     */
    public function delete($id = null)
    {
        $model = new \App\Models\UserModel();

        // Check if the record exists before attempting deletion.
        if (!$model->find($id)) {
            return $this->failNotFound("No Users entry found with ID: {$id}");
        }

        // Attempt to delete the record.
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'User entry deleted successfully.']);
        } else {
            return $this->failServerError('Failed to delete User entry.');
        }
    }
}