# Architecture Documentation

## System Architecture

The Air Space Control Website follows a modern, layered architecture pattern combining Laravel's MVC framework with Vue.js for the frontend, creating a separation between server-side and client-side concerns.

## Architecture Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                          Client Layer                            │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │                    Vue.js 3 SPA                           │   │
│  │  ┌────────────┐  ┌────────────┐  ┌─────────────────┐    │   │
│  │  │ Components │  │   Pinia    │  │   Vue Router    │    │   │
│  │  │   (Views)  │  │  (State)   │  │  (Navigation)   │    │   │
│  │  └────────────┘  └────────────┘  └─────────────────┘    │   │
│  └──────────────────────────────────────────────────────────┘   │
│                              │                                   │
│                         HTTP/AJAX                                │
│                              │                                   │
└──────────────────────────────┼───────────────────────────────────┘
                               │
┌──────────────────────────────┼───────────────────────────────────┐
│                         API Layer                                │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │              Laravel API Routes (routes/api.php)         │   │
│  │  ┌────────────────┐  ┌─────────────────────────────┐    │   │
│  │  │ Authentication │  │    Resource Controllers      │    │   │
│  │  │   Middleware   │  │  (Flights, Users, Stats)     │    │   │
│  │  └────────────────┘  └─────────────────────────────┘    │   │
│  └──────────────────────────────────────────────────────────┘   │
└──────────────────────────────┼───────────────────────────────────┘
                               │
┌──────────────────────────────┼───────────────────────────────────┐
│                      Application Layer                           │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │                   Business Logic                          │   │
│  │  ┌─────────────┐  ┌─────────────┐  ┌──────────────┐     │   │
│  │  │  Services   │  │   Helpers   │  │  Validators  │     │   │
│  │  └─────────────┘  └─────────────┘  └──────────────┘     │   │
│  └──────────────────────────────────────────────────────────┘   │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │                Eloquent ORM Models                        │   │
│  │           (User, Flight, Report, etc.)                    │   │
│  └──────────────────────────────────────────────────────────┘   │
└──────────────────────────────┼───────────────────────────────────┘
                               │
┌──────────────────────────────┼───────────────────────────────────┐
│                       Data Layer                                 │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │                    MySQL Database                         │   │
│  │  ┌──────┐  ┌──────┐  ┌─────────┐  ┌────────────────┐    │   │
│  │  │Users │  │Flights│ │ Reports │  │ OAuth Tokens   │    │   │
│  │  └──────┘  └──────┘  └─────────┘  └────────────────┘    │   │
│  └──────────────────────────────────────────────────────────┘   │
└──────────────────────────────────────────────────────────────────┘
```

## Technology Stack

### Backend Technologies

| Component         | Technology       | Purpose                   |
| ----------------- | ---------------- | ------------------------- |
| Framework         | Laravel 10.x     | Web application framework |
| Language          | PHP 8.1+         | Server-side programming   |
| Database          | MySQL 8.0+       | Data persistence          |
| Authentication    | Laravel Passport | OAuth2 API authentication |
| ORM               | Eloquent         | Database abstraction      |
| API Documentation | L5-Swagger       | OpenAPI/Swagger docs      |
| Testing           | PHPUnit          | Unit and feature testing  |
| Data Generation   | Faker            | Mock data generation      |

### Frontend Technologies

| Component        | Technology   | Purpose                          |
| ---------------- | ------------ | -------------------------------- |
| Framework        | Vue.js 3     | Progressive JavaScript framework |
| State Management | Pinia        | Centralized state management     |
| Build Tool       | Vite         | Fast build tool and dev server   |
| UI Framework     | Tailwind CSS | Utility-first CSS framework      |
| Charts           | Chart.js     | Data visualization               |
| HTTP Client      | Axios        | API communication                |

### DevOps & Tools

| Component             | Technology     | Purpose                       |
| --------------------- | -------------- | ----------------------------- |
| Containerization      | Docker         | Application containerization  |
| Orchestration         | Docker Compose | Multi-container orchestration |
| Web Server            | Nginx          | HTTP server (in Docker)       |
| Package Manager (PHP) | Composer       | Dependency management         |
| Package Manager (JS)  | npm            | Frontend dependencies         |

## Directory Structure

### Backend Structure

```
app/
├── Console/              # Artisan commands
├── Exceptions/           # Exception handlers
├── Http/
│   ├── Controllers/      # Request handlers
│   │   ├── Api/         # API controllers
│   │   └── Web/         # Web controllers
│   ├── Middleware/       # Request filters
│   └── Requests/         # Form request validation
├── Models/               # Eloquent models
├── Providers/            # Service providers
└── Services/             # Business logic services

config/                   # Configuration files
├── app.php              # Application config
├── database.php         # Database config
├── passport.php         # Passport config
└── l5-swagger.php       # API docs config

database/
├── factories/           # Model factories
├── migrations/          # Database migrations
└── seeders/             # Database seeders

routes/
├── api.php              # API routes
├── web.php              # Web routes
├── channels.php         # Broadcast channels
└── console.php          # Console commands
```

### Frontend Structure

```
resources/
├── js/
│   ├── components/      # Vue components
│   ├── views/           # Page components
│   ├── stores/          # Pinia stores
│   ├── router/          # Vue Router config
│   ├── services/        # API services
│   └── app.js           # Main entry point
├── css/
│   └── app.css          # Tailwind imports
└── views/
    └── app.blade.php    # Main layout

public/
├── index.php            # Entry point
└── assets/              # Compiled assets
```

## Design Patterns

### Backend Patterns

#### 1. **MVC (Model-View-Controller)**

-   **Models:** Eloquent ORM models represent database entities
-   **Views:** Blade templates (minimal, as Vue handles most UI)
-   **Controllers:** Handle HTTP requests and coordinate business logic

#### 2. **Repository Pattern** (Optional)

-   Abstracts data access logic
-   Makes switching data sources easier
-   Improves testability

#### 3. **Service Layer Pattern**

-   Encapsulates business logic
-   Keeps controllers thin
-   Promotes code reusability

#### 4. **Dependency Injection**

-   Laravel's service container manages dependencies
-   Promotes loose coupling
-   Facilitates testing with mocks

### Frontend Patterns

#### 1. **Component-Based Architecture**

-   Reusable Vue components
-   Single File Components (.vue)
-   Props and events for communication

#### 2. **State Management (Pinia)**

-   Centralized application state
-   Predictable state mutations
-   DevTools integration

#### 3. **Service Layer**

-   API service modules
-   Axios interceptors for auth tokens
-   Centralized error handling

## Data Flow

### Typical Request Flow

1. **User Interaction** → Vue component triggers action
2. **Action Dispatch** → Pinia store action called
3. **API Request** → Axios makes HTTP request to Laravel API
4. **Middleware** → Laravel processes authentication/authorization
5. **Controller** → Receives request, calls service layer
6. **Service Layer** → Implements business logic
7. **Model/Database** → Data retrieved or modified via Eloquent
8. **Response** → JSON response sent back to frontend
9. **State Update** → Pinia store updates application state
10. **UI Update** → Vue reactively updates the DOM

## Authentication Flow

```
┌──────────┐
│  Client  │
└────┬─────┘
     │ 1. POST /api/login {email, password}
     ▼
┌──────────────┐
│   Laravel    │
│ Auth Service │
└────┬─────────┘
     │ 2. Validate credentials
     ▼
┌──────────────┐
│   Passport   │
│ OAuth Server │
└────┬─────────┘
     │ 3. Generate access token
     ▼
┌──────────────┐
│   Response   │
│ {token, ...} │
└────┬─────────┘
     │ 4. Store token in client
     ▼
┌──────────────┐
│    Client    │
│  Subsequent  │
│   Requests   │
└────┬─────────┘
     │ 5. Authorization: Bearer {token}
     ▼
┌──────────────┐
│   Laravel    │
│  Middleware  │
└──────────────┘
```

## Database Schema

### Key Tables

#### users

-   `id` (Primary Key)
-   `name`
-   `email` (Unique)
-   `password`
-   `email_verified_at`
-   `created_at`, `updated_at`

#### oauth_access_tokens

-   `id`
-   `user_id` (Foreign Key → users.id)
-   `client_id`
-   `name`
-   `scopes`
-   `revoked`
-   `created_at`, `updated_at`, `expires_at`

#### flights (Example - structure may vary)

-   `id` (Primary Key)
-   `flight_number`
-   `aircraft_type`
-   `origin`
-   `destination`
-   `scheduled_departure`
-   `scheduled_arrival`
-   `actual_departure`
-   `actual_arrival`
-   `status`
-   `created_at`, `updated_at`

## Security Considerations

### Backend Security

1. **CSRF Protection:** Enabled for web routes
2. **SQL Injection:** Prevented via Eloquent ORM
3. **XSS Protection:** Output escaping in Blade templates
4. **Password Hashing:** bcrypt hashing algorithm
5. **API Authentication:** OAuth2 via Laravel Passport
6. **Rate Limiting:** Throttling middleware on API routes
7. **CORS Configuration:** Controlled cross-origin requests

### Frontend Security

1. **Token Storage:** Secure storage of access tokens
2. **HTTPS Only:** Production should use SSL/TLS
3. **Input Validation:** Client-side validation before API calls
4. **Sanitization:** Output sanitization in Vue templates

## Performance Optimization

### Backend Optimization

-   **Query Optimization:** Eager loading to prevent N+1 queries
-   **Caching:** Redis/Memcached for frequently accessed data
-   **Database Indexing:** Proper indexes on frequently queried columns
-   **Queue Jobs:** Asynchronous processing for time-consuming tasks

### Frontend Optimization

-   **Code Splitting:** Lazy loading of Vue components
-   **Asset Optimization:** Vite builds optimized bundles
-   **Image Optimization:** Compressed and appropriately sized images
-   **CDN Usage:** Static assets served via CDN in production

## Scalability

### Horizontal Scaling

-   **Load Balancing:** Multiple application servers behind load balancer
-   **Database Replication:** Read replicas for query distribution
-   **Session Management:** Database or Redis-based sessions

### Vertical Scaling

-   **Server Resources:** Increase CPU, RAM as needed
-   **Database Optimization:** Query optimization, proper indexing
-   **Caching Layer:** Reduce database load

## Testing Strategy

### Backend Testing

-   **Unit Tests:** Test individual classes and methods
-   **Feature Tests:** Test complete features and API endpoints
-   **Browser Tests:** Laravel Dusk for E2E testing

### Frontend Testing

-   **Unit Tests:** Test individual Vue components
-   **Integration Tests:** Test component interactions
-   **E2E Tests:** Test complete user workflows

## Development Workflow

1. **Local Development:** Use Vite dev server for hot module replacement
2. **Version Control:** Git for source control
3. **Code Review:** Pull requests before merging
4. **Continuous Integration:** Automated testing on commits
5. **Deployment:** Automated deployment pipeline

## API Versioning Strategy

-   Current: No explicit versioning (implicit v1)
-   Future: URL-based versioning (`/api/v2/...`)
-   Backward compatibility maintained for at least one major version
