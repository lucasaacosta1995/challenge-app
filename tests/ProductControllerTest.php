<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTester;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;

class ProductControllerTest extends CIUnitTestCase
{
    use ControllerTester;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testIndex()
    {
        // Instancia del controlador
        $controller = new \App\Controllers\ProductController();

        // Ejecutar el método index
        $result = $this->executeController($controller, 'index');

        // Verificar que la respuesta sea exitosa (código de estado 200)
        $this->assertInstanceOf(Response::class, $result);
        $this->assertEquals(200, $result->getStatusCode());

        // Verificar que el contenido de la respuesta sea en formato JSON
        $this->assertJSON($result->getBody());
    }

    // Puedes seguir creando pruebas similares para los otros métodos (show, create, update, delete).
    // Asegúrate de adaptar según tus necesidades específicas.
}
