<?php
declare(strict_types=1);

namespace App\Models;

use BananaPHP\Models\BaseModel;

class NewModel extends BaseModel
{
    protected string $table = 'new_models';
    protected string $primaryKey = 'id';
    protected array $fillable = [];
    protected array $hidden = [];
}