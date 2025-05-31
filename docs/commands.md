# BANANA-PHP Command Reference  
*(Adaptable Next-Generation Advanced Nimble Architecture PHP)*  

| Command            | Description                                                                 | Status          |
|--------------------|-----------------------------------------------------------------------------|-----------------|
| `make:model`       | Creates a new **Eloquent-style model** for database interactions.           | ✅ Available    |
| `make:migration`   | Generates a **database migration** file for schema changes.                 | ✅ Available    |
| `make:seeder`      | *(RESTRICTED)* Creates a database seeder for dummy data.                    | ❌ Restricted   |
| `make:factory`     | *(RESTRICTED)* Generates a model factory for testing/scaling data.          | ❌ Restricted   |
| `make:request`     | *(RESTRICTED)* Creates a **form request** with validation logic.            | ❌ Restricted   |
| `make:resource`    | *(RESTRICTED)* Generates an **API resource** (JSON transformation layer).   | ❌ Restricted   |
| `make:view`        | *(RESTRICTED)* Scaffolds a **Blade-compatible view** template.              | ❌ Restricted   |
| `make:auth`        | *(RESTRICTED)* Installs **authentication boilerplate** (e.g., login/logout).| ❌ Restricted   |
| `make:middleware`  | Creates a **middleware** class for HTTP request filtering.                  | ✅ Available    |
| `make:job`         | *(RESTRICTED)* Generates a **queueable job** for async tasks.               | ❌ Restricted   |
| `make:listener`    | *(RESTRICTED)* Creates an **event listener** for subscribed events.         | ❌ Restricted   |
| `make:event`       | *(RESTRICTED)* Generates a custom **event** class.                          | ❌ Restricted   |
| `make:policy`      | *(RESTRICTED)* Creates an **authorization policy** (e.g., user permissions).| ❌ Restricted   |
| `make:controller`  | Generates a **controller** for application logic/routing.                   | ✅ Available    |
| `make:provider`    | *(RESTRICTED)* Creates a **service provider** for dependency injection.     | ❌ Restricted   |

### Key:  
- ✅ **Available**: Ready for use in BANANA-PHP.  
- ❌ **Restricted**: Disabled by design (see [Framework Philosophy](#) for reasoning).  

> **Note**: Restricted commands may be enabled via **extensions** or **configuration overrides**.  
> Contribute on [GitHub](https://github.com/meyoramu/banana-php) to discuss feature flags!