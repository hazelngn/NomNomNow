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

}