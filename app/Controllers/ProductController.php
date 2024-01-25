<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Product;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
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
    public function index(): string
    {
        return view('product/index/index');
    }

    /**
     * @return string
     */
    public function getProductTable(): string
    {
        $this->logRequest();

        $limit = $this->request->getGet('limit') ?? 6;
        $page = $this->request->getGet('page') ?? 1;
        $offset = ($page - 1) * $limit;

        $title = $this->request->getGet('title');
        $price = $this->request->getGet('price');
        $createdAt = $this->request->getGet('created_at');

        $products = $this->filterProducts($this->model->getProducts($limit, $offset), $title, $price, $createdAt);
        $totalProducts = count($products);

        $pager = service('pager');
        $pager->setPath('');
        $pagination = $pager->makeLinks($page, $limit, $totalProducts, 'default_full');

        $data = [
            'data' => $products,
            'pagination' => $pagination
        ];
        return view('product/index/table', $data);
    }

    /**
     * @param $products
     * @param $title
     * @param $price
     * @param $createdAt
     * @return array
     */
    public function filterProducts($products, $title, $price, $createdAt): array
    {
        $filteredData = array_filter($products, function ($item) use ($title) {
            return empty($title) || stripos($item['title'], $title) !== false;
        });

        $filteredData = array_filter($filteredData, function ($item) use ($price) {
            return empty($price) || $item['price'] == $price;
        });

        return array_filter($filteredData, function ($item) use ($createdAt) {
            return empty($createdAt) || stripos($item['created_at'], $createdAt) !== false;
        });
    }

    /**
     * @param $id
     * @return ResponseInterface
     */
    public function show($id): ResponseInterface
    {
        $this->logRequest();

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
     * @param $id
     * @return ResponseInterface
     */
    public function edit($id): ResponseInterface
    {
        $this->logRequest();

        try {
            $product = $this->model->getProductById($id);

            if (!$product) {
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Producto no encontrado']);
            }

            return $this->response->setJSON(['data' => $product]);
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
        $this->logRequest();

        $validation = Services::validation();
        $validation->setRules([
            'title' => 'required|min_length[3]|max_length[255]',
            'price' => 'required|numeric',
        ]);

        $data = $this->request->getPost();

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
        $this->logRequest();

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
