<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];



    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    /**
     * @return void
     */
    protected function logRequest()
    {
        $url = current_url();

        $method = $this->request->getMethod();
        $params = $this->request->uri->getSegments();

        $body = $method == 'get' && $this->request->getJSON() ?? $this->request->getPost();

        $getData = $this->request->getGet();
        $postData = $this->request->getPost();

        $requestData = [
            'url'    => $url,
            'method' => $method,
            'params' => $params,
            'body'   => $body,
            'get'    => $getData,
            'post'   => $postData,
            'date' => date('Y-m-d H:i:s'),
        ];
        $jsonFilePath = WRITEPATH . 'logs/request_data.json';
        $jsonData = [];
        if (file_exists($jsonFilePath)) {
            $jsonData = json_decode(file_get_contents($jsonFilePath), true);
        }
        $jsonData[] = $requestData;
        file_put_contents($jsonFilePath, json_encode($jsonData, JSON_PRETTY_PRINT));

    }
}
