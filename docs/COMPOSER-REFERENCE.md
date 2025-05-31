# 🍌 BananaPHP Composer Reference
*`composer.json` Architecture Guide*  
![Version](https://img.shields.io/badge/version-1.0-blue) ![PHP](https://img.shields.io/badge/PHP-%3E%3D8.1-777BB4)

```mermaid
graph TD
    A[composer.json] --> B[Core Dependencies]
    A --> C[Autoloading]
    A --> D[CLI Configuration]
    A --> E[Optimization]
    B --> F["symfony/* components"]
    B --> G["php-di/php-di"]
    D --> H["bin/banana"]
```

## 🛠️ Configuration Overview
### 📦 Package Definition
```json
{
  "name": "meyoramu/banana-php",
  "type": "project",
  "license": "MIT"
}
```
- **Purpose**: Identifies the package and its open-source license  
- **Best Practice**: Matches [PHP-FIG package naming](https://www.php-fig.org/)

---

### 🔗 Dependency Graph
```mermaid
pie
    title Required Packages
    "Symfony Components" : 35
    "Security (JWT/Encryption)" : 25
    "Utilities (Dates/UUIDs)" : 20
    "DI/Logging" : 20
```

---

## 🧩 Key Sections

### 1. Core Requirements (`require`)
```json
"require": {
  "php": "^8.1",
  "symfony/console": "^7.2",
  "php-di/php-di": "^7.0"
}
```
| Package | Purpose | Color Code |
|---------|---------|------------|
| `symfony/*` | Framework infrastructure | ![#0d6efd](https://via.placeholder.com/10/0d6efd/000000?text=+) `#0d6efd` |
| `php-di/*` | Dependency injection | ![#20c997](https://via.placeholder.com/10/20c997/000000?text=+) `#20c997` |

---

### 2. CLI Configuration
```json
"bin": ["banana"],
"scripts": {
  "post-create-project-cmd": [
    "BananaPHP\\Installer::postInstall"
  ]
}
```
🔄 **Workflow**:  
```mermaid
sequenceDiagram
    User->>Composer: create-project
    Composer->>Installer: postInstall()
    Installer->>System: Sets up 'banana' CLI
```

---

## 🎨 Color Standards
| Section | Hex Color | Usage |
|---------|----------|-------|
| **Critical** | `#dc3545` | Required PHP/extensions |
| **Framework** | `#0d6efd` | Symfony components |
| **Utilities** | `#20c997` | Helper packages |
| **Dev** | `#6f42c1` | Development tools |

---

## 📊 Version Policy
```mermaid
gantt
    title Version Support Timeline
    dateFormat  YYYY-MM
    section PHP
    8.1+ :active, 2023-01, 2025-12
    section Symfony
    6.2+ :crit, 2022-11, 2026-11
```

---

## Best Practices Checklist
- [x] PSR-4 autoloading compliant
- [x] `bin-dir` explicitly set
- [x] Separate `require-dev` for tooling
- [x] License declared
- [x] Stability constraints defined

[🔗 Back to Main README](../README.md)