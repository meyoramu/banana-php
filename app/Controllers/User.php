<?php
declare(strict_types=1);

namespace App\Controllers;

use BananaPHP\Services\Http\Request;
use BananaPHP\Services\Http\Response;
use BananaPHP\Services\View\View;

class User
{
    protected Request $request;
    protected Response $response;
    protected View $view;

    public function __construct(Request $request, Response $response, View $view)
    {
        $this->request = $request;
        $this->response = $response;
        $this->view = $view;
    }

    // Example action method
    public function index(): Response
    {
        return $this->view->render('welcome', [
            'message' => 'Hello from your new controller!'
        ]);
    }
}