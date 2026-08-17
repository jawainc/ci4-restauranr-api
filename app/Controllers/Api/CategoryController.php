<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use CodeIgniter\API\ResponseTrait;

class CategoryController extends BaseController
{
    use ResponseTrait;

    protected CategoryModel $model;

    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    /** GET /api/categories */
    public function index()
    {
        return $this->respond($this->model->orderBy('name', 'ASC')->findAll());
    }

    /** GET /api/categories/{id} */
    public function show($id = null)
    {
        $category = $this->model->find($id);

        if (! $category) {
            return $this->failNotFound("Category #{$id} not found.");
        }

        return $this->respond($category);
    }

    /** POST /api/categories */
    public function create()
    {
        $data = $this->request->getJSON(true) ?? $this->request->getPost();

        if (! $this->model->validate($data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        $id = $this->model->insert($data, true);

        return $this->respondCreated($this->model->find($id));
    }

    /** PUT /api/categories/{id} */
    public function update($id = null)
    {
        $category = $this->model->find($id);

        if (! $category) {
            return $this->failNotFound("Category #{$id} not found.");
        }

        $data = $this->request->getJSON(true) ?? $this->request->getRawInput();
        $data['id'] = $id; // needed for the is_unique[...,id,{id}] rule

        if (! $this->model->validate($data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        $this->model->update($id, $data);

        return $this->respond($this->model->find($id));
    }

    /** DELETE /api/categories/{id} */
    public function delete($id = null)
    {
        $category = $this->model->find($id);

        if (! $category) {
            return $this->failNotFound("Category #{$id} not found.");
        }

        $this->model->delete($id);

        return $this->respondDeleted(['id' => $id]);
    }
}
