<?php
declare(strict_types=1);

use BananaPHP\Services\Database\Migration;
use BananaPHP\Services\Database\Schema;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        $this->schema->createTable('users', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    public function down(): void
    {
        $this->schema->dropTableIfExists('users');
    }
}