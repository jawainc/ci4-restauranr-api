<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = ['name', 'slug', 'is_active'];

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'slug' => 'required|alpha_dash|max_length[120]|is_unique[categories.slug,id,{id}]',
    ];

    protected $validationMessages = [
        'slug' => [
            'is_unique' => 'That slug is already in use by another category.',
        ],
    ];
}
