<?php
declare(strict_types=1);

namespace BananaPHP\Services\Database;

use BananaPHP\Services\Database\Schema;
use BananaPHP\Services\Database\Connection;
use PDO;

abstract class Migration
{
    protected PDO $pdo;
    protected Schema $schema;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
        $this->schema = new Schema($this->pdo);
    }

    /**
     * Run the migrations
     */
    abstract public function up(): void;

    /**
     * Reverse the migrations
     */
    abstract public function down(): void;

    /**
     * Create migrations table if not exists
     */
    public function ensureMigrationsTableExists(): void
    {
        $this->schema->createTableIfNotExists('migrations', function (Blueprint $table) {
            $table->id();
            $table->string('migration');
            $table->timestamp('created_at')->useCurrent();
        });
    }
}