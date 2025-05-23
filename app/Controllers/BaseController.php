<?php
declare(strict_types=1);

namespace BananaPHP\Controllers;

use BananaPHP\Services\Http\Request;
use BananaPHP\Services\Http\Response;
use BananaPHP\Services\View\View;

abstract class BaseController
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

    protected function view(string $template, array $data = []): Response
    {
        $content = $this->view->render($template, $data);
        return $this->response->setContent($content);
    }

    protected function json(array $data, int $status = 200): Response
    {
        return Response::json($data, $status);
    }

    protected function redirect(string $url, int $status = 302): Response
    {
        return $this->response->createRedirect($url, $status);
    }
}