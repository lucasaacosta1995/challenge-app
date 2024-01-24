<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Product;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use function PHPUnit\Framework\throwException;

class ProductController extends BaseController
{
    use ResponseTrait;

    /**
     * @var \App\Models\Product
     */
    private $model;

    /**
     *
     */
    public function __construct()
    {
        $this->model = new Product();
    }

    /**
     * @return string
     */
    public function index()
    {
        return view('product/index/index');
    }

    /**
     * @return string
     */
    public function getProductTable(): string
    {
        // Configura y obtén los datos paginados
        $limit = $this->request->getGet('limit') ?? 6;
        $page = $this->request->getGet('page') ?? 1;
        $offset = ($page - 1) * $limit;

        $products = $this->model->getProducts($limit, $offset);
        $totalProducts = $this->model->getTotalProducts();

        $pager = service('pager');
        $pager->setPath('');
        $pagination = $pager->makeLinks($page, $limit, $totalProducts, 'default_full');

        $data = [
            'data' => $this->model->getProducts($limit, $offset),
            'pagination' => $pagination
        ];

        return view('product/index/table', $data);
    }

    /**
     * @param $id
     * @return ResponseInterface
     */
    public function show($id): ResponseInterface
    {
        try {
            $product = $this->model->getProductById($id);

            if (!$product) {
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Producto no encontrado']);
            }

            return $this->response->setJSON($product);
        } catch (\Exception $e) {
            exit;
        }

    }

    /**
     * @return ResponseInterface
     */
    public function create(): ResponseInterface
    {
        $validation = Services::validation();
        $validation->setRules([
            'title' => 'required|min_length[3]|max_length[255]',
            'price' => 'required|numeric',
        ]);


        if ($validation->run($this->request->getPost())) {
            try {
                $data = $this->request->getPost();
                $this->model->createProduct($data);
                return $this->response->setStatusCode(ResponseInterface::HTTP_CREATED)->setJSON(['message' => 'Producto creado exitosamente']);

            } catch (\Exception $e) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)->setJSON(['message' => $e->getMessage()]);
            }
        } else {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)->setJson([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ]);
        }

    }

    /**
     * @param $id
     * @return ResponseInterface
     */
    public function update($id): ResponseInterface
    {
        $validation = Services::validation();
        $validation->setRules([
            'title' => 'required|min_length[3]|max_length[255]',
            'price' => 'required|numeric',
        ]);

        $data = json_decode($this->request->getBody(), true);

        if ($validation->run($data)) {
            try {
                $result = $this->model->updateProduct($id, $data);
                if (!$result) {
                    return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)->setJSON(['error' => 'Producto no encontrado']);
                }
                return $this->response->setJSON(['message' => 'Producto actualizado exitosamente']);

            } catch (\Exception $e) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)->setJSON(['message' => $e->getMessage()]);
            }
        } else {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)->setJSON([$validation->getErrors()]);
        }
    }

    /**
     * @param $id
     * @return ResponseInterface
     */
    public function delete($id): ResponseInterface
    {
        try {
            if (!$this->model->getProductById($id)) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)->setJSON(['message' => 'Producto no encontrado']);
            }
            $this->model->deleteProduct($id);
            return $this->response->setJSON(['message' => 'Producto eliminado exitosamente']);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)->setJSON(['message' => $e->getMessage()]);
        }
    }

}
