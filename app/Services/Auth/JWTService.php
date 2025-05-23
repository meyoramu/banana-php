<?php
declare(strict_types=1);

namespace BananaPHP\Services\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use BananaPHP\Exceptions\AuthenticationException;

class JWTService
{
    private string $secret;
    private string $algo;
    private int $ttl;
    private int $refreshTtl;

    public function __construct()
    {
        $this->secret = env('JWT_SECRET');
        $this->algo = env('JWT_ALGO', 'HS256');
        $this->ttl = env('JWT_TTL', 60);
        $this->refreshTtl = env('JWT_REFRESH_TTL', 20160);
    }

    public function generateToken(array $payload): string
    {
        $now = time();
        $payload = array_merge([
            'iss' => env('APP_URL'),
            'iat' => $now,
            'exp' => $now + ($this->ttl * 60),
            'nbf' => $now,
        ], $payload);

        return JWT::encode($payload, $this->secret, $this->algo);
    }

    public function validateToken(string $token): array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secret, $this->algo));
            return (array) $decoded;
        } catch (\Exception $e) {
            throw new AuthenticationException('Invalid token: ' . $e->getMessage());
        }
    }

    public function refreshToken(string $token): string
    {
        $payload = $this->validateToken($token);
        $now = time();
        
        if ($payload['exp'] < ($now - ($this->refreshTtl * 60))) {
            throw new AuthenticationException('Token cannot be refreshed');
        }

        unset($payload['iat'], $payload['exp'], $payload['nbf']);
        return $this->generateToken($payload);
    }
}