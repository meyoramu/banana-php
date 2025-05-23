<?php
declare(strict_types=1);

namespace BananaPHP\Services\View;

use BananaPHP\Exceptions\ViewException;

class View
{
    private string $viewsPath;
    private array $sharedData = [];

    public function __construct(string $viewsPath)
    {
        $this->viewsPath = rtrim($viewsPath, '/');
    }

    public function share(string $key, $value): void
    {
        $this->sharedData[$key] = $value;
    }

    public function render(string $template, array $data = []): string
    {
        $templatePath = $this->viewsPath . '/' . ltrim($template, '/') . '.php';
        
        if (!file_exists($templatePath)) {
            throw new ViewException("View [{$template}] not found");
        }

        extract(array_merge($this->sharedData, $data));
        
        ob_start();
        try {
            include $templatePath;
        } catch (Throwable $e) {
            ob_end_clean();
            throw new ViewException("Error rendering view: " . $e->getMessage(), 0, $e);
        }
        
        return ob_get_clean();
    }
}