<?php

use App\Models\Product;
use CodeIgniter\Test\CIUnitTestCase;

class ProductModelTest extends CIUnitTestCase
{
    private $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Product();
    }

    public function testGetProducts()
    {
        $limit = 5;
        $offset = 0;

        $result = $this->model->getProducts($limit, $offset);

        $this->assertIsArray($result);
    }

    public function testCreateProduct()
    {
        $data = [
            'id' => 9999999,
            'title' => 'Test Product',
            'price' => 10.99,
        ];

        $initialCount = count($this->model->getProducts(5, 0));

        $this->model->createProduct($data);

        $finalCount = count($this->model->getProducts(5, 0));

        $this->assertGreaterThan($initialCount, $finalCount);
    }

    public function testUpdateProduct()
    {
        $idToUpdate = 9999999;
        $data = [
            'title' => 'Updated Product',
            'price' => 15,
        ];

        $result = $this->model->updateProduct($idToUpdate, $data);

        $this->assertTrue($result);
    }

    /**
     * @throws Exception
     */
    public function testUpdateNonExistingProduct()
    {
        $nonExistingId = 99999999999;
        $data = [
            'title' => 'Updated Product',
            'price' => 15,
        ];

        $result = $this->model->updateProduct($nonExistingId, $data);

        $this->assertFalse($result);
    }

    public function testDeleteProduct()
    {
        $idToDelete = 9999999;

        $initialCount = count($this->model->getProducts(5, 0));

        $this->model->deleteProduct($idToDelete);

        $finalCount = count($this->model->getProducts(5, 0));

        $this->assertLessThan($initialCount, $finalCount);
    }

    public function testDeleteNonExistingProduct()
    {
        $nonExistingId = 99999999999;

        $initialCount = count($this->model->getProducts(5, 0));

        $this->model->deleteProduct($nonExistingId);

        $finalCount = count($this->model->getProducts(5, 0));

        $this->assertSame($initialCount, $finalCount);
    }
}
