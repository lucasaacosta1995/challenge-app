<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    /**
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function login()
    {
        if (!session()->get('logged_in')) {
            return view('auth/login');
        }

        return redirect()->to('/producto');

    }

    /**
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function attemptLogin(): \CodeIgniter\HTTP\RedirectResponse
    {
        // Lógica para validar credenciales y realizar el inicio de sesión
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $model = new User();
        $user = $model->getUserByCredential($username);

        if ($user && password_verify($password, $user['password'])) {
            // Iniciar sesión
            session()->set('logged_in', true);
            session()->set('user_id', $user['id']);
            return redirect()->to('/producto');
        } else {
            return redirect()->back()->with('error', 'Credenciales incorrectas');
        }
    }

    /**
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function logout(): \CodeIgniter\HTTP\RedirectResponse
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }

    /**
     * @return ResponseInterface
     */
    public function generateTokenCSRF(): ResponseInterface
    {
        $nuevoToken = csrf_hash();

        return $this->response->setJSON(['token' => $nuevoToken]);
    }
}
