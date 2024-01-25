<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['title', 'price', 'created_at'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    protected string $jsonFilePath = WRITEPATH . 'products.json';


    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getProducts(int $limit, int $offset): array
    {

        $products = $this->loadProducts();

        return array_slice($products, $offset, $limit);
    }

    /**
     * @return array|null
     */
    public function loadProducts() : ?array
    {
        $products = [];

        if (file_exists($this->jsonFilePath) & !empty(file_get_contents($this->jsonFilePath))) {
            $products = json_decode(file_get_contents($this->jsonFilePath), true);
        }

        return $products;
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function getProductById(int $id): ?array
    {
        $products = $this->loadProducts();
        foreach ($products as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }
        return null;
    }

    /**
     * @param array $data
     * @return void
     * @throws \Exception
     */
    public function createProduct(array $data)
    {
        $products = $this->loadProducts();
        $products[] = array_merge(array(
            'id' => $data['id'] ?? $this->generateId(),
            'created_at' => Time::now()->toLocalizedString('yyyy-MM-dd HH:mm'),
            'modified_at' => ''), $data);
        $this->updateFileJson($products);
    }

    /**
     * @return int|mixed|string
     */
    private function generateId(): int
    {
        $products = $this->loadProducts();

        $lastProducts = end($products);

        return $lastProducts ? $lastProducts['id'] + 1 : 1;
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function updateProduct(int $id, array $data): bool
    {
        $products = $this->loadProducts();
        foreach ($products as &$product) {
            if ($product['id'] == $id) {
                $product['modified_at'] = Time::now()->toLocalizedString('yyyy-MM-dd HH:mm');
                $product = array_merge($product, $data);
                $this->updateFileJson($products);
                return true;
            }
        }
        return false;
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteProduct(int $id)
    {
        $products = $this->loadProducts();
        $products = array_filter($products, function ($product) use ($id) {
            return $product['id'] != $id;
        });
        $this->updateFileJson($products);
    }

    /**
     * @param array $data
     * @return void
     */
    private function updateFileJson(array $data)
    {
        $jsonString = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($this->jsonFilePath, $jsonString);
    }

}
