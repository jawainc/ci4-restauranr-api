<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;

class ProductController extends BaseController
{
    use ResponseTrait;

    protected ProductModel $model;

    public function __construct()
    {
        $this->model = new ProductModel();
    }

    /**
     * GET /api/products
     * GET /api/products?category_id=3
     */
    public function index()
    {
        $categoryId = $this->request->getGet('category_id');

        $products = $this->model->listProducts(
            $categoryId !== null ? (int) $categoryId : null
        );

        return $this->respond($products);
    }

    /** GET /api/products/{id} */
    public function show($id = null)
    {
        $product = $this->model->find($id);

        if (! $product) {
            return $this->failNotFound("Product #{$id} not found.");
        }

        return $this->respond($product);
    }

    /** POST /api/products */
    public function create()
    {
        $data = $this->request->getJSON(true) ?? $this->request->getPost();

        if (! $this->model->validate($data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        $id = $this->model->insert($data, true);

        return $this->respondCreated($this->model->find($id));
    }

    /** PUT /api/products/{id} */
    public function update($id = null)
    {
        $product = $this->model->find($id);

        if (! $product) {
            return $this->failNotFound("Product #{$id} not found.");
        }

        $data = $this->request->getJSON(true) ?? $this->request->getRawInput();

        if (! $this->model->validate(array_merge($product, $data))) {
            return $this->failValidationErrors($this->model->errors());
        }

        $this->model->update($id, $data);

        return $this->respond($this->model->find($id));
    }

    /** DELETE /api/products/{id} (soft delete) */
    public function delete($id = null)
    {
        $product = $this->model->find($id);

        if (! $product) {
            return $this->failNotFound("Product #{$id} not found.");
        }

        $this->model->delete($id);

        return $this->respondDeleted(['id' => $id]);
    }
}
