<?php
declare(strict_types=1);

namespace BananaPHP\Services\Http;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Request extends SymfonyRequest
{
    public function all(): array
    {
        return array_merge($this->query->all(), $this->request->all());
    }

    public function input(string $key, $default = null)
    {
        return $this->get($key, $this->request->get($key, $default));
    }

    public function bearerToken(): ?string
    {
        $header = $this->headers->get('Authorization', '');
        
        if (str_starts_with($header, 'Bearer ')) {
            return substr($header, 7);
        }
        
        return null;
    }

    public function isJson(): bool
    {
        return str_contains($this->headers->get('Content-Type', ''), 'json');
    }

    public function wantsJson(): bool
    {
        $acceptable = $this->getAcceptableContentTypes();
        return isset($acceptable[0]) && str_contains($acceptable[0], 'json');
    }
}