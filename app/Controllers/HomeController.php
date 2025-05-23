<?php
declare(strict_types=1);

namespace BananaPHP\Controllers;

class HomeController extends BaseController
{
    public function index(): Response
    {
        return $this->view('pages/home', [
            'title' => 'BANANA-PHP Framework',
            'message' => 'Welcome to the Adaptable Next-Generation Advanced Nimble Architecture PHP Framework'
        ]);
    }

    public function about(): Response
    {
        return $this->view('pages/about', [
            'title' => 'About BANANA-PHP'
        ]);
    }
}