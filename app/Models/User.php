<?php
declare(strict_types=1);

namespace BananaPHP\Models;

use BananaPHP\Services\Auth\PasswordService;

class User extends BaseModel
{
    protected string $table = 'users';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'name', 'email', 'password'
    ];
    protected array $hidden = [
        'password'
    ];

    public static function register(array $data): int
    {
        $data['password'] = PasswordService::hash($data['password']);
        return parent::create($data);
    }

    public static function verifyCredentials(string $email, string $password): ?array
    {
        $user = static::query()
            ->where('email', '=', $email)
            ->first();

        if ($user && PasswordService::verify($password, $user['password'])) {
            unset($user['password']);
            return $user;
        }

        return null;
    }
}