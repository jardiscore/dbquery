# DbQuery

![Build Status](https://github.com/jardisCore/dbquery/actions/workflows/ci.yml/badge.svg)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.2-blue.svg)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-PolyForm%20Noncommercial-blue.svg)](LICENSE)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%208-success.svg)](phpstan.neon)
[![PSR-12](https://img.shields.io/badge/code%20style-PSR--12-orange.svg)](phpcs.xml)

**Enterprise-Grade SQL Query Builder for PHP 8.2+**

Production-proven, type-safe, and truly database-agnostic. Write once, deploy anywhere: MySQL/MariaDB, PostgreSQL, and SQLite.

---

## 🏆 Enterprise-Level Capabilities

DbQuery is not just another query builder – it's an enterprise-grade solution that handles the complexity modern applications demand:

### Advanced SQL Features Out-of-the-Box
- **Window Functions** - ROW_NUMBER, RANK, DENSE_RANK, LAG, LEAD with partitioning and ordering
- **Common Table Expressions (CTEs)** - WITH and WITH RECURSIVE for complex hierarchical queries
- **Subqueries Everywhere** - Nested queries in SELECT, FROM, WHERE, and HAVING clauses
- **Complex JOINs** - All join types (INNER, LEFT, RIGHT, FULL, CROSS) with subquery support
- **JSON Operations** - Database-agnostic JSON querying with automatic dialect translation
- **UNION/UNION ALL** - Combine multiple result sets seamlessly
- **Conflict Handling** - ON DUPLICATE KEY UPDATE (MySQL), ON CONFLICT (PostgreSQL), OR IGNORE/REPLACE (SQLite)
- **Aggregate Functions** - GROUP BY, HAVING with full support for complex aggregations

### 🎯 **True Database Independence**
Switch between database systems **without changing a single line of code**. DbQuery automatically translates your queries into the correct SQL dialect – including advanced features like JSON operations, window functions, and CTEs. Deploy to MySQL today, PostgreSQL tomorrow, SQLite for testing – **one codebase for all**.

This isn't just basic CRUD portability – we handle the hard stuff:
- JSON path differences: `JSON_EXTRACT()` (MySQL) ↔ `->` / `->>` (PostgreSQL)
- Conflict resolution: `ON DUPLICATE KEY` (MySQL) ↔ `ON CONFLICT` (PostgreSQL)
- Window function syntax variations across all dialects
- Data type conversions and function name mappings

### 🔒 **Security by Design**
Prepared statements are **standard, not optional**. Every query is automatically protected against SQL injection attacks. No manual validation, no forgotten sanitization – **secure by default**. Built for enterprises that can't afford security vulnerabilities.

### 📊 **Database-Agnostic JSON Support**
Work with JSON data across all databases with a unified API. The drastically different JSON syntax between MySQL (`JSON_EXTRACT()`), PostgreSQL (`->` / `->>` operators), and SQLite is completely abstracted:

```php
// One code, three dialects
->whereJson('data')->extract('$.user.email')->equals('user@example.com')
```

### ✨ **Modern PHP Excellence**
- **PHPStan Level 8 certified** – the highest static analysis level achievable
- **Full PHP 8.2+ type safety** with strict types and union types
- **PSR-12 compliant** – industry-standard coding style
- **High test coverage** – comprehensive unit and integration tests across all databases
- **Zero runtime dependencies** – only requires PDO (included in PHP)

### 🚀 **Production-Ready Architecture**
Engineered with proven enterprise design patterns:
- **Builder Pattern** – Clean separation of query building and SQL generation
- **State Objects** – Enable efficient caching and query reuse
- **Factory Pattern** – Automatic dialect-specific builder selection
- **Registry Pattern** – Prevents unnecessary object instantiation, improves performance
- **Immutable Queries** – Safe concurrent query building without side effects

### 💪 **Battle-Tested Reliability**
- ✅ Proven in demanding production environments
- ✅ Handles complex enterprise queries (multi-level JOINs, recursive CTEs, window functions)
- ✅ Docker-based development environment for consistency
- ✅ Continuous integration with automated testing
- ✅ Actively maintained and supported

## The Difference in Practice

**Before** (Raw SQL with manual dialect handling):
```php
// MySQL
$sql = "SELECT * FROM users WHERE JSON_EXTRACT(settings, '$.theme') = ? AND age > ?";
// PostgreSQL
$sql = "SELECT * FROM users WHERE settings->>'theme' = ? AND age > ?";
// Manual binding, error-prone
$stmt = $pdo->prepare($sql);
$stmt->execute(['dark', 18]);
```

**After** (DbQuery - one code for all DBs):
```php
$query = new DbQuery();
$query->select('*')
      ->from('users')
      ->whereJson('settings')->extract('$.theme')->equals('dark')
      ->and('age')->greater(18);

$result = $query->sql('mysql');  // Or 'postgres' or 'sqlite'
// Prepared statements automatic, correct dialect syntax guaranteed
```

## Why Choose DbQuery for Enterprise?

### For CTOs and Technical Leaders
- **Reduce Technical Debt** - One query builder for all databases eliminates dialect-specific code sprawl
- **Future-Proof Architecture** - Switch database vendors without rewriting application code
- **Lower Maintenance Costs** - Unified API reduces training time and developer context switching
- **Security Compliance** - Automatic prepared statements eliminate SQL injection attack vectors
- **Type Safety Guarantee** - PHPStan Level 8 certification catches bugs before production

### For Development Teams
- **Faster Development** - Intuitive fluent interface accelerates query construction
- **Less Debugging** - Strong typing and static analysis catch errors at development time
- **Consistent Code** - PSR-12 compliance ensures uniform code style across teams
- **Comprehensive Testing** - Pre-tested against all supported databases reduces QA burden
- **Easy Onboarding** - Clear documentation and examples get developers productive quickly

### For DevOps and Infrastructure
- **Database Flexibility** - Test on SQLite, develop on MySQL, deploy to PostgreSQL – seamlessly
- **Docker-First Development** - Consistent environments from local dev to production
- **Zero Config Needed** - Works out-of-the-box with standard PDO connections
- **Performance Optimized** - Registry pattern and state caching minimize object creation overhead

---

## Complete Feature Overview

### Query Types (Full CRUD)
- ✅ **SELECT** - Complex queries with subqueries, CTEs, window functions, aggregations
- ✅ **INSERT** - Single/multi-row inserts, INSERT...SELECT, bulk operations
- ✅ **UPDATE** - Conditional updates with complex WHERE clauses
- ✅ **DELETE** - Safe deletion with flexible filtering

### Advanced SQL Constructs
- ✅ **Window Functions** - ROW_NUMBER, RANK, DENSE_RANK, LAG, LEAD, SUM/AVG OVER
- ✅ **CTEs (Common Table Expressions)** - WITH and WITH RECURSIVE for hierarchical data
- ✅ **Subqueries** - Nested queries in SELECT, FROM, WHERE, HAVING, and JOIN clauses
- ✅ **All JOIN Types** - INNER, LEFT, RIGHT, FULL OUTER, CROSS JOIN
- ✅ **UNION/UNION ALL** - Combine result sets from multiple queries
- ✅ **GROUP BY & HAVING** - Aggregations with post-aggregation filtering
- ✅ **Complex WHERE** - Nested conditions with brackets, OR/AND logic, EXISTS, IN

### JSON & NoSQL Features
- ✅ **JSON Extraction** - `extract()` for nested JSON path queries
- ✅ **JSON Array Operations** - `contains()`, `length()` for array handling
- ✅ **JSON Conditions** - Compare, filter, and validate JSON data
- ✅ **Cross-Database Compatibility** - Same API works on MySQL, PostgreSQL, SQLite

### Data Integrity & Conflicts
- ✅ **MySQL/MariaDB** - ON DUPLICATE KEY UPDATE
- ✅ **PostgreSQL** - ON CONFLICT DO UPDATE/DO NOTHING
- ✅ **SQLite** - OR IGNORE, OR REPLACE, REPLACE INTO
- ✅ **Upsert Operations** - Insert-or-update patterns handled automatically

### Developer Experience
- ✅ **Fluent Interface** - Chainable methods for intuitive query building
- ✅ **Type-Safe** - Full PHP 8.2+ type hints with union types
- ✅ **IDE-Friendly** - Complete PHPDoc for autocomplete and inline documentation
- ✅ **Expression Support** - Raw SQL expressions when you need them
- ✅ **Query Inspection** - Examine generated SQL and bindings before execution

**DbQuery is the only PHP query builder that combines:**
- Enterprise-level SQL features (window functions, recursive CTEs)
- True cross-database JSON abstraction
- PHPStan Level 8 type safety
- Zero framework dependencies
- Intuitive fluent interface

---

## Real-World Enterprise Use Cases

### Multi-Tenant SaaS Applications
Deploy the same codebase across different client databases – MySQL for high-traffic clients, PostgreSQL for analytics-heavy workloads, SQLite for development/testing.

### Financial Systems
Window functions for running balances, CTEs for hierarchical account structures, and prepared statements for PCI-DSS compliance.

### E-Commerce Platforms
Complex product filtering with JSON attributes, inventory updates with conflict handling (upserts), multi-table JOINs for order processing.

### Analytics & Reporting
Window functions for ranking and percentiles, recursive CTEs for organizational hierarchies, UNION queries for cross-database reporting.

### Microservices Architecture
Different services use different databases without rewriting query logic. Easy migration between database types as services evolve.

---

## Requirements

- PHP 8.2 or higher
- PDO extension
- Docker & Docker Compose (for development)
- One of the supported databases:
  - MySQL 5.7+
  - MariaDB 10.3+
  - PostgreSQL 12+
  - SQLite 3.35+

## Installation

```bash
composer require jardiscore/dbquery
```

## Quick Start

### Basic SELECT Query

```php
use JardisCore\DbQuery\DbQuery;

$query = new DbQuery();
$query->select('id, name, email')
      ->from('users')
      ->where('age')->greater(18)
      ->and('status')->equals('active')
      ->orderBy('name', 'ASC')
      ->limit(10);

// Generate SQL for specific dialect
$prepared = $query->sql('mysql', prepared: true);

echo $prepared->sql();          // SQL with placeholders
print_r($prepared->bindings()); // Values for prepared statement
echo $prepared->type();         // Query type: 'SELECT'

// Optional: Specify database version for forward compatibility
$prepared = $query->sql('mysql', prepared: true, '8.4');
```

### INSERT Operations

```php
use JardisCore\DbQuery\DbInsert;

// Option 1: fields() + values() for multiple rows
$insert = new DbInsert();
$insert->into('users')
       ->fields('name', 'email', 'created_at')
       ->values('John Doe', 'john@example.com', '2024-01-01')
       ->values('Jane Smith', 'jane@example.com', '2024-01-02');

$sql = $insert->sql('mysql');

// Option 2: set() for single row with associative array
$insert = new DbInsert();
$insert->into('users')
       ->set([
           'name' => 'John Doe',
           'email' => 'john@example.com',
           'created_at' => '2024-01-01'
       ]);

$sql = $insert->sql('mysql');

// Option 3: INSERT ... SELECT
$select = new DbQuery();
$select->select('name, email')->from('temp_users');

$insert = new DbInsert();
$insert->into('users')
       ->fields('name', 'email')
       ->fromSelect($select);

$sql = $insert->sql('mysql');
```

### UPDATE Operations

```php
use JardisCore\DbQuery\DbUpdate;

$update = new DbUpdate();
$update->table('users')
       ->set('status', 'inactive')
       ->set('updated_at', 'NOW()')
       ->where('last_login')->lower('2023-01-01');

$sql = $update->sql('mysql');

// Set multiple columns at once
$update = new DbUpdate();
$update->table('users')
       ->setMultiple([
           'status' => 'inactive',
           'updated_at' => '2024-01-01'
       ])
       ->where('id')->equals(123);

$sql = $update->sql('mysql');
```

### DELETE Operations

```php
use JardisCore\DbQuery\DbDelete;

$delete = new DbDelete();
$delete->from('users')
       ->where('status')->equals('deleted')
       ->and('created_at')->lower('2020-01-01');

$sql = $delete->sql('mysql');
```

## Advanced Examples

### Complex WHERE Conditions with Brackets

```php
$query = new DbQuery();
$query->select('*')
      ->from('products')
      ->where('category')->equals('electronics')
      ->and('price')->between(100, 500)
      ->and('brand', '(')->equals('Sony')        // Opening bracket in $openBracket parameter
          ->or('brand')->equals('Samsung', ')'); // Closing bracket in $closeBracket parameter

// Generates: WHERE category = ? AND price BETWEEN ? AND ? AND (brand = ? OR brand = ?)
```

### JSON Operations

DbQuery provides database-agnostic JSON operations that work across MySQL, PostgreSQL, and SQLite:

```php
// Basic JSON extraction
$query = new DbQuery();
$query->select('*')
      ->from('users')
      ->whereJson('settings')->extract('$.theme')->equals('dark')
      ->andJson('metadata')->extract('$.age')->greater(25);

// JSON array operations
$query = new DbQuery();
$query->select('*')
      ->from('items')
      ->whereJson('tags')->contains('php')            // Array contains value
      ->andJson('data')->length()->greaterEquals(3);  // Array length check

// JSON with NULL checks
$query = new DbQuery();
$query->select('*')
      ->from('users')
      ->whereJson('settings')->extract('$.active')->isNotNull();

// Generates dialect-specific JSON SQL automatically
$sql = $query->sql('postgres'); // Uses -> operator
$sql = $query->sql('mysql');    // Uses JSON_EXTRACT()
```

### JOINs

```php
$query = new DbQuery();
$query->select('u.name, o.total, a.city')
      ->from('users', 'u')
      ->innerJoin('orders', 'u.id = o.user_id', 'o')
      ->leftJoin('addresses', 'u.id = a.user_id', 'a')
      ->where('o.status')->equals('completed');

// All join types supported: innerJoin, leftJoin, rightJoin, fullJoin, crossJoin
```

### Subqueries

```php
// Subquery in WHERE clause
$subquery = new DbQuery();
$subquery->select('user_id')->from('orders')->where('total')->greater(1000);

$query = new DbQuery();
$query->select('*')
      ->from('users')
      ->where('id')->in($subquery);

// Subquery in FROM clause
$query = new DbQuery();
$query->select('*')
      ->from($subquery, 'high_value_orders')
      ->where('status')->equals('active');
```

### Window Functions

```php
// ROW_NUMBER() with partitioning and ordering
$query = new DbQuery();
$query->selectWindow('ROW_NUMBER()', 'row_num')
      ->partitionBy('department')
      ->windowOrderBy('salary', 'DESC')
      ->select('name, department, salary')
      ->from('employees');

// Named window specifications
$query = new DbQuery();
$query->select('name, salary')
      ->selectWindowRef('ROW_NUMBER()', 'w', 'row_num')
      ->window('w')
        ->partitionBy('department')
        ->windowOrderBy('salary', 'DESC')
      ->from('employees');
```

### Common Table Expressions (CTEs)

```php
// Simple CTE
$cte = new DbQuery();
$cte->select('department, AVG(salary) as avg_salary')
    ->from('employees')
    ->groupBy('department');

$query = new DbQuery();
$query->with('dept_avg', $cte)
      ->select('e.name, e.salary, d.avg_salary')
      ->from('employees', 'e')
      ->innerJoin('dept_avg', 'e.department = d.department', 'd');

// Recursive CTE (e.g., for hierarchical data)
$recursiveCte = new DbQuery();
$recursiveCte->select('id, name, parent_id, 1 as level')
             ->from('categories')
             ->where('parent_id')->isNull()
             ->unionAll(/* recursive part */);

$query = new DbQuery();
$query->withRecursive('category_tree', $recursiveCte)
      ->select('*')
      ->from('category_tree');
```

### INSERT with Conflict Handling

```php
// MySQL: ON DUPLICATE KEY UPDATE
$insert = new DbInsert();
$insert->into('users')
       ->set(['id' => 1, 'name' => 'John', 'email' => 'john@example.com'])
       ->onDuplicateKeyUpdate('name', 'John Updated')
       ->onDuplicateKeyUpdate('email', 'john.updated@example.com');

$sql = $insert->sql('mysql');

// PostgreSQL: ON CONFLICT
$insert = new DbInsert();
$insert->into('users')
       ->set(['id' => 1, 'name' => 'John', 'email' => 'john@example.com'])
       ->onConflict('email')
       ->doUpdate(['name' => 'John Updated']);

$sql = $insert->sql('postgres');

// SQLite: OR IGNORE / REPLACE
$insert = new DbInsert();
$insert->into('users')
       ->set(['id' => 1, 'name' => 'John'])
       ->orIgnore();

$sql = $insert->sql('sqlite');
```

## Development

All development work is done inside Docker containers. **Never run composer or vendor/bin commands directly on the host.**

### Setup

```bash
# Start database containers (REQUIRED before any other commands)
make start

# Install dependencies
make install
```

### Running Tests

```bash
# All tests
make phpunit

# Unit tests only
make phpunit-unit

# Integration tests only
make phpunit-integration

# With coverage report
make phpunit-coverage

# Single test file
docker compose run --rm phpcli vendor/bin/phpunit --bootstrap ./tests/bootstrap.php tests/unit/DbQueryTest.php
```

### Code Quality

```bash
# Static analysis (PHPStan Level 8)
make phpstan

# Code style checks (PSR-12)
make phpcs

# Open shell in PHP container
make shell
```

### Container Management

```bash
# Stop and remove containers
make stop

# View logs
docker compose logs -f
```

## Architecture

### Builder Pattern with State Separation

```
Builder Classes → State Objects → SQL Generators → SQL Output
```

1. **Builders** (`DbQuery`, `DbInsert`, etc.): Fluent interface for users
2. **State Objects** (`QueryState`, `InsertState`, etc.): Store query configuration
3. **SQL Generators**: Database-specific classes for SQL generation
4. **Factory**: `SqlBuilderFactory` creates the appropriate generator for dialect

### Directory Structure

```
src/
├── DbQuery.php          # SELECT Query Builder
├── DbInsert.php         # INSERT Builder
├── DbUpdate.php         # UPDATE Builder
├── DbDelete.php         # DELETE Builder
├── data/                # State Objects
│   ├── QueryState.php
│   ├── InsertState.php
│   ├── UpdateState.php
│   ├── DeleteState.php
│   ├── Expression.php
│   ├── WindowFunction.php
│   └── DbPreparedQuery.php
├── query/               # SELECT SQL Generators
│   ├── SqlBuilder.php   # Base SELECT builder
│   ├── MySql.php        # MySQL-specific implementation
│   ├── PostgresSql.php  # PostgreSQL-specific implementation
│   ├── SqliteSql.php    # SQLite-specific implementation
│   ├── builder/method/  # Builder methods (Where, Join, OrderBy, etc.)
│   ├── builder/clause/  # SQL clause builders (SELECT, FROM, JOIN, etc.)
│   └── builder/condition/ # Condition operators (Equals, GreaterThan, etc.)
├── command/             # INSERT/UPDATE/DELETE Generators
│   ├── insert/          # InsertSqlBuilder + dialect implementations
│   ├── update/          # UpdateSqlBuilder + dialect implementations
│   └── delete/          # DeleteSqlBuilder + dialect implementations
└── factory/             # Factories and Registries
    ├── SqlBuilderFactory.php  # Creates dialect-specific builders
    └── BuilderRegistry.php    # Singleton registry for stateless builders
```

### Key Design Patterns

**BuilderRegistry Pattern**: A critical singleton pattern used throughout the codebase:
- Caches reusable stateless builder instances
- Accessed via `BuilderRegistry::get(ClassName::class)`
- Prevents duplicate instantiation of helper classes
- Important for testing: Call `BuilderRegistry::clear()` in setUp/tearDown

**Method Delegation Pattern**: Complex builder methods delegate to dedicated classes:
```php
// DbQuery::where() delegates to specialized Where class
BuilderRegistry::get(method\Where::class)($collector, $queryCondition, $field, $openBracket);
```

## Dialect Support

The library generates dialect-specific SQL for:

- **MySQL/MariaDB** (`mysql`, `mariadb`)
- **PostgreSQL** (`postgres`)
- **SQLite** (`sqlite`)

Key dialect differences handled:
- **JSON path syntax**: MySQL uses `JSON_EXTRACT('$.path')`, PostgreSQL uses `->` / `->>` operators
- **INSERT conflict handling**: MySQL `ON DUPLICATE KEY UPDATE`, PostgreSQL `ON CONFLICT`, SQLite `OR IGNORE`/`REPLACE`
- **Window functions**: Dialect-specific implementations and feature availability
- **LIMIT/OFFSET syntax**: Varies between databases
- **Data type handling**: Database-specific type conversions
- **Function names**: e.g., `CONCAT` vs `||` for string concatenation

When adding features, always test against all three dialects using the integration tests.

## Available Condition Operators

- `equals()`, `notEquals()`
- `greater()`, `greaterEquals()`
- `lower()`, `lowerEquals()`
- `between()`, `notBetween()`
- `in()`, `notIn()`
- `like()`, `notLike()`
- `isNull()`, `isNotNull()`
- `exists()`, `notExists()`

## Code Standards

- **PHP 8.2+** with strict types: `declare(strict_types=1)` required in all files
- **PSR-12** coding standard (enforced via PHPCS)
- **PHPStan Level 8** static analysis (strictest)
- **High test coverage** target
- All public methods require PHPDoc with `@param` and `@return` tags
- Maximum line length: 120 characters (absolute max: 150)

## Performance & Quality Metrics

### Code Quality
- **PHPStan Level 8** - Highest static analysis level (0 errors)
- **PSR-12 Compliant** - 100% coding standard adherence
- **Test Coverage** - Comprehensive unit and integration tests
- **Zero Runtime Dependencies** - Only PDO required (included in PHP)

### Database Compatibility
- **3 Database Engines** - MySQL/MariaDB, PostgreSQL, SQLite
- **6+ Major Versions** - Tested across multiple database versions
- **100+ Integration Tests** - Real database testing for all dialects

### Developer Productivity
- **Type-Safe API** - Full PHP 8.2+ type hints eliminate runtime errors
- **IDE-Friendly** - Complete autocomplete and inline documentation
- **Fluent Interface** - Average 30-50% less code than raw SQL
- **Error Prevention** - Static analysis catches bugs before deployment

---

## Enterprise Support & Roadmap

### Current Production Status
✅ **Production-Ready** - Battle-tested in demanding enterprise environments
✅ **Actively Maintained** - Regular updates and security patches
✅ **Stable API** - Semantic versioning with backward compatibility guarantee

### Upcoming Features (Roadmap)
- 🔄 **Performance Monitoring** - Query execution time tracking and logging
- 🔄 **Query Caching Layer** - Optional query result caching
- 🔄 **Migration Tools** - Schema migration helpers
- 🔄 **Extended Dialects** - Microsoft SQL Server, Oracle support

### Licensing

**Noncommercial Use**: This project is licensed under the **PolyForm Noncommercial License 1.0.0** for:
- Personal use, research, and education
- Nonprofit organizations
- Open source projects
- Academic institutions

**Commercial Use**: For commercial use in for-profit organizations, please contact us for a commercial license:
- Email: **jardiscore@headgent.dev**
- Website: https://headgent.dev

Commercial licensing includes priority support, custom features, and migration assistance.

---

## Contributing

Contributions are welcome! Please ensure:
1. All tests pass (`make phpunit`)
2. Code follows PSR-12 (`make phpcs`)
3. PHPStan Level 8 passes (`make phpstan`)
4. New features include tests for all supported dialects
5. Documentation is updated

## Support

### Community Support
- **Issues**: [GitHub Issues](https://github.com/jardiscore/DbQuery/issues)
- **Documentation**: Complete examples and API reference
- **Email**: jardiscore@headgent.dev

### Enterprise Support (Available)
- Priority bug fixes and feature requests
- Custom dialect implementations
- Migration assistance and consulting
- Direct communication channel

Contact **jardiscore@headgent.dev** for enterprise support inquiries.

---

## Acknowledgments

Built with modern PHP practices and battle-tested in production environments. DbQuery represents years of real-world enterprise development experience, distilled into a single, powerful library.

**Special thanks** to all contributors, early adopters, and users who help improve this library through feedback and contributions.
