<?php
declare(strict_types=1);

namespace App\Models;

use BananaPHP\Models\BaseModel;

class User extends BaseModel
{
    protected string $table = 'users';
    protected string $primaryKey = 'id';
    protected array $fillable = [];
    protected array $hidden = [];
}