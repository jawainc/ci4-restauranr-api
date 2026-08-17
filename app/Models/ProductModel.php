<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'category_id',
        'name',
        'description',
        'price',
        'image_url',
        'is_available',
    ];

    protected $validationRules = [
        'category_id' => 'required|is_natural_no_zero|is_not_unique[categories.id]',
        'name'        => 'required|min_length[2]|max_length[150]',
        'price'       => 'required|decimal|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'category_id' => [
            'is_not_unique' => 'That category does not exist.',
        ],
    ];

    /**
     * Fetch products with an optional category filter.
     */
    public function listProducts(?int $categoryId = null): array
    {
        $builder = $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id');

        if ($categoryId !== null) {
            $builder->where('products.category_id', $categoryId);
        }

        return $builder->findAll();
    }
}
