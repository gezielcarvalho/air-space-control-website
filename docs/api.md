# API Documentation

## Overview

The Air Space Control Website provides a RESTful API for managing air traffic control operations, flight data, and user authentication. The API follows REST principles and uses JSON for request and response payloads.

## Base URL

```
Local Development: http://localhost:8000/api
Production: https://your-domain.com/api
```

## Authentication

The API uses **Laravel Passport** for OAuth2 authentication.

### Authentication Flow

1. **Register/Login** to obtain an access token
2. Include the token in subsequent requests via the `Authorization` header

### Authorization Header

```http
Authorization: Bearer {access_token}
```

### Obtaining an Access Token

**Endpoint:** `POST /api/login`

**Request:**

```json
{
    "email": "user@example.com",
    "password": "password"
}
```

**Response:**

```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
    "token_type": "Bearer",
    "expires_in": 31536000
}
```

## API Endpoints

### Authentication Endpoints

#### Register User

```http
POST /api/register
```

**Request Body:**

```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "securepassword",
    "password_confirmation": "securepassword"
}
```

**Response:** `201 Created`

```json
{
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "created_at": "2025-11-21T10:00:00.000000Z",
        "updated_at": "2025-11-21T10:00:00.000000Z"
    },
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
    "token_type": "Bearer"
}
```

#### Login

```http
POST /api/login
```

**Request Body:**

```json
{
    "email": "john@example.com",
    "password": "securepassword"
}
```

**Response:** `200 OK`

```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
    "token_type": "Bearer",
    "expires_in": 31536000
}
```

#### Logout

```http
POST /api/logout
```

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`

```json
{
    "message": "Successfully logged out"
}
```

#### Get Authenticated User

```http
GET /api/user
```

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`

```json
{
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "email_verified_at": null,
    "created_at": "2025-11-21T10:00:00.000000Z",
    "updated_at": "2025-11-21T10:00:00.000000Z"
}
```

### Flight Management Endpoints

#### List All Flights

```http
GET /api/flights
```

**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**

-   `status` - Filter by flight status (scheduled, departed, arrived, cancelled)
-   `date` - Filter by date (YYYY-MM-DD)
-   `limit` - Number of results per page (default: 15)

**Response:** `200 OK`

```json
{
    "data": [
        {
            "id": 1,
            "flight_number": "AA123",
            "aircraft_type": "B737",
            "origin": "JFK",
            "destination": "LAX",
            "scheduled_departure": "2025-11-21T14:00:00Z",
            "scheduled_arrival": "2025-11-21T17:30:00Z",
            "status": "scheduled",
            "created_at": "2025-11-21T10:00:00.000000Z",
            "updated_at": "2025-11-21T10:00:00.000000Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "per_page": 15,
        "total": 100
    }
}
```

#### Get Single Flight

```http
GET /api/flights/{id}
```

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`

```json
{
    "id": 1,
    "flight_number": "AA123",
    "aircraft_type": "B737",
    "origin": "JFK",
    "destination": "LAX",
    "scheduled_departure": "2025-11-21T14:00:00Z",
    "scheduled_arrival": "2025-11-21T17:30:00Z",
    "actual_departure": null,
    "actual_arrival": null,
    "status": "scheduled",
    "gate": "A12",
    "altitude": null,
    "speed": null,
    "created_at": "2025-11-21T10:00:00.000000Z",
    "updated_at": "2025-11-21T10:00:00.000000Z"
}
```

#### Create Flight

```http
POST /api/flights
```

**Headers:** `Authorization: Bearer {token}`

**Request Body:**

```json
{
    "flight_number": "AA123",
    "aircraft_type": "B737",
    "origin": "JFK",
    "destination": "LAX",
    "scheduled_departure": "2025-11-21T14:00:00Z",
    "scheduled_arrival": "2025-11-21T17:30:00Z",
    "gate": "A12"
}
```

**Response:** `201 Created`

#### Update Flight

```http
PUT /api/flights/{id}
```

**Headers:** `Authorization: Bearer {token}`

**Request Body:**

```json
{
    "status": "departed",
    "actual_departure": "2025-11-21T14:05:00Z",
    "altitude": 35000,
    "speed": 450
}
```

**Response:** `200 OK`

#### Delete Flight

```http
DELETE /api/flights/{id}
```

**Headers:** `Authorization: Bearer {token}`

**Response:** `204 No Content`

### Statistics Endpoints

#### Dashboard Statistics

```http
GET /api/statistics/dashboard
```

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`

```json
{
    "total_flights": 150,
    "active_flights": 25,
    "arrivals_today": 75,
    "departures_today": 70,
    "delayed_flights": 5,
    "cancelled_flights": 2,
    "average_delay": "15 minutes"
}
```

#### Traffic Patterns

```http
GET /api/statistics/traffic-patterns
```

**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**

-   `start_date` - Start date for analysis (YYYY-MM-DD)
-   `end_date` - End date for analysis (YYYY-MM-DD)

**Response:** `200 OK`

```json
{
    "hourly_traffic": [
        { "hour": "00:00", "arrivals": 5, "departures": 3 },
        { "hour": "01:00", "arrivals": 2, "departures": 4 }
    ],
    "busiest_hour": "14:00",
    "total_operations": 250
}
```

## Error Responses

### Standard Error Format

```json
{
    "message": "Error message description",
    "errors": {
        "field_name": ["Validation error message"]
    }
}
```

### HTTP Status Codes

-   `200 OK` - Request successful
-   `201 Created` - Resource created successfully
-   `204 No Content` - Request successful, no content to return
-   `400 Bad Request` - Invalid request format
-   `401 Unauthorized` - Authentication required or failed
-   `403 Forbidden` - Insufficient permissions
-   `404 Not Found` - Resource not found
-   `422 Unprocessable Entity` - Validation errors
-   `500 Internal Server Error` - Server error

## Rate Limiting

API requests are rate-limited to prevent abuse:

-   **Authenticated requests:** 60 requests per minute
-   **Unauthenticated requests:** 30 requests per minute

Rate limit headers are included in responses:

```http
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
X-RateLimit-Reset: 1637510400
```

## Interactive API Documentation

For interactive API documentation with the ability to test endpoints, visit:

```
http://localhost:8000/api/documentation
```

This Swagger UI interface is generated using L5-Swagger and provides:

-   Complete API endpoint listing
-   Request/response examples
-   Interactive testing capability
-   Authentication flow testing

## Pagination

List endpoints support pagination with the following parameters:

-   `page` - Page number (default: 1)
-   `limit` - Items per page (default: 15, max: 100)

Pagination metadata is included in the response:

```json
{
  "data": [...],
  "meta": {
    "current_page": 1,
    "per_page": 15,
    "total": 100,
    "last_page": 7
  },
  "links": {
    "first": "http://localhost:8000/api/flights?page=1",
    "last": "http://localhost:8000/api/flights?page=7",
    "prev": null,
    "next": "http://localhost:8000/api/flights?page=2"
  }
}
```

## Versioning

Currently, the API is in version 1. Future versions will be accessed via:

```
/api/v2/endpoint
```

## CORS

Cross-Origin Resource Sharing (CORS) is configured to allow requests from authorized domains. Configuration can be found in `config/cors.php`.
