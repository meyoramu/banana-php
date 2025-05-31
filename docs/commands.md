# BANANA-PHP Command Reference  
*(Adaptable Next-Generation Advanced Nimble Architecture PHP)*  

## 🟢 Available Commands  
| Command            | Description                                                                 | Status          | Usage Example                     |
|--------------------|-----------------------------------------------------------------------------|-----------------|-----------------------------------|
| `make:model`       | Creates a new model class.                                                  | ✅ Available    | `php banana make:model Product`   |
| `make:migration`   | Creates a new database migration file.                                      | ✅ Available    | `php banana make:migration create_products_table` |
| `make:middleware`  | Creates a new middleware class.                                             | ✅ Available    | `php banana make:middleware AuthCheck` |
| `make:controller`  | Creates a new controller class.                                             | ✅ Available    | `php banana make:controller ProductController` |
| `migrate`          | Runs all pending database migrations.                                       | ✅ Available    | `php banana migrate`              |
| `serve`            | Starts the development server (`http://localhost:8000`).                    | ✅ Available    | `php banana serve --port=8080`    |

---

## 🔴 Restricted Commands  
*(Disabled by default for performance/security reasons)*  

| Command            | Description                                                                 | Status          | Restriction Reason               |
|--------------------|-----------------------------------------------------------------------------|-----------------|----------------------------------|
| `make:seeder`      | Creates a database seeder for dummy data.                                   | ❌ Restricted   | Requires `banana/database-extra` |
| `make:factory`     | Generates a model factory for testing.                                      | ❌ Restricted   | Not enabled in core              |
| `make:request`     | Creates a form request with validation logic.                               | ❌ Restricted   | Install `banana/validation`      |
| `make:resource`    | Generates an API resource (JSON transformation layer).                      | ❌ Restricted   | Needs `banana/api` extension     |
| `make:view`        | Scaffolds a Blade-compatible view template.                                 | ❌ Restricted   | Use standalone `banana/ui`       |
| `make:auth`        | Installs authentication boilerplate.                                        | ❌ Restricted   | Security considerations          |
| `make:job`         | Generates a queueable job for async tasks.                                  | ❌ Restricted   | Requires queue driver            |
| `make:listener`    | Creates an event listener for subscribed events.                            | ❌ Restricted   | Needs `banana/events`            |
| `make:event`       | Generates a custom event class.                                             | ❌ Restricted   | Needs `banana/events`            |
| `make:policy`      | Creates an authorization policy.                                            | ❌ Restricted   | Install `banana/auth`            |
| `make:provider`    | Creates a service provider for DI.                                          | ❌ Restricted   | Advanced use only                |

---

### 🔧 Command Details & Best Practices

#### 📁 Generators
- `make:model ModelName`  
  ✅ **Status**: Always available  
  📍 Location: `app/Models/ModelName.php`  
  🚩 Flags:  
  ```bash
  -f  # Create corresponding factory
  -m  # Create corresponding migration
  ```

#### 🗃 Database
- `migrate`  
  ✅ **Status**: Core feature  
  🔄 Related commands:  
  ```bash
  migrate:rollback  # Undo last migration
  migrate:refresh   # Reset and re-run all
  migrate:status    # Show migration state
  ```

#### 🖥 Development
- `serve`  
  ✅ **Status**: Always ready  
  ⚙️ Options:  
  ```bash
  --port=8080    # Custom port
  --host=0.0.0.0 # External access
  ```

---

### ⚙️ Enabling Restricted Features
1. **Package Installation**:
```bash
composer require banana/database-extra banana/api banana/auth
```

2. **Configuration** (config/banana.php):
```php
'features' => [
    'seeders' => true,       # Enables seeders
    'api_resources' => true  # Enables API tools
]
```

---

### 📜 Key & Notes
| Icon       | Meaning                  |
|------------|--------------------------|
| ✅         | Available by default     |
| ❌         | Requires activation      |

- All commands: `php banana [command]`  
- Get help: `php banana help make:model`  
- Discover commands: `php banana list`  

🚀 **Contribute**: [GitHub](https://github.com/meyoramu/banana-php)  
📚 **Documentation**: [banana-php.dev](https://banana-php.dev)