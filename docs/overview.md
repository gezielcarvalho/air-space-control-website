# Air Space Control Website - Project Overview

## Introduction

The **Institutional Portal for Air Traffic Control Unit** is a comprehensive web application designed to simulate and manage air traffic control operations. This portal provides real-time information and statistics about air traffic, flight status, radar data, and operational metrics for control tower and radar approach control modules.

## Project Background

This project was conceived based on real-world experience in air traffic control operations spanning from 1994 to 2013. During this period, the developer worked as an Air Traffic Controller and contributed to various IT initiatives including:

-   Website development
-   Process automation
-   Data analysis and reporting

### Original Implementation (2000)

The original version of this application was developed in **2000 using PHPNuke**, a popular content management system of that era. It was created as a part-time project for the air traffic control organization where the developer worked, serving as an institutional portal to:

-   Display operational statistics and flight information
-   Provide public access to facility information
-   Streamline internal communication and reporting

### Current Rewrite (2025)

This **Laravel-based rewrite** serves multiple purposes:

1. **Technical Showcase:** Demonstrate modern PHP development skills and best practices using Laravel framework
2. **Portfolio Reference:** Highlight professional experience with PHP, spanning from the early 2000s to current enterprise-level frameworks
3. **Technology Modernization:** Replace legacy PHPNuke architecture with contemporary technologies including Laravel, Vue.js, and modern development patterns
4. **Professional Development:** Apply current industry standards for web application development, API design, and security practices

The rewrite maintains the spirit of the original project while leveraging 25 years of web development evolution, showcasing the progression from basic CMS-based applications to sophisticated, API-driven architectures.

## Key Features

### Current Implementation

1. **Landing Page**

    - Display key statistics and facility information
    - Real-time operational metrics
    - Dashboard with visual data representation

2. **User Authentication and Authorization**

    - Secure login system
    - Role-based access control (RBAC)
    - Laravel Passport integration for API authentication

3. **Reporting System**
    - Air traffic pattern analysis
    - Incident reporting
    - Operational statistics generation

### Planned Features

1. **Control Tower Module**

    - Flight information management for arrivals
    - Departure tracking and updates
    - Real-time status monitoring

2. **Radar Approach Control Module**

    - Aircraft movement tracking in controlled airspace
    - Conflict detection and alerting
    - Visual representation of air traffic

3. **Data Mocking**
    - Realistic flight data generation for demonstration
    - Test scenarios and simulation capabilities

## Technology Stack

### Backend

-   **Framework:** Laravel (PHP)
-   **Database:** MySQL
-   **Authentication:** Laravel Passport (OAuth2)
-   **Documentation:** Swagger/OpenAPI (L5-Swagger)

### Frontend

-   **Framework:** Vue.js 3
-   **State Management:** Pinia
-   **Build Tool:** Vite
-   **UI Framework:** Tailwind CSS
-   **Charts:** Chart.js

### Development Tools

-   **Data Generation:** Faker PHP library
-   **Containerization:** Docker & Docker Compose
-   **Testing:** PHPUnit

## Project Evolution

| Aspect            | Original (2000)   | Current Version (2025) |
| ----------------- | ----------------- | ---------------------- |
| Platform          | PHPNuke CMS       | Laravel Framework      |
| Backend           | PHP 4             | PHP 8.1+ / Laravel     |
| Frontend          | HTML/JavaScript   | Vue.js 3               |
| State Management  | Server-side only  | Pinia                  |
| Build Tools       | None              | Vite                   |
| Styling           | CSS Tables/Frames | Tailwind CSS           |
| Authentication    | PHPNuke built-in  | Laravel Passport       |
| API               | None              | RESTful API            |
| API Documentation | N/A               | Swagger/OpenAPI        |
| Database          | MySQL             | MySQL 8.0+             |
| Architecture      | Monolithic CMS    | MVC/API-driven         |

## Use Cases

1. **Air Traffic Control Training**

    - Simulate realistic ATC scenarios
    - Practice coordination procedures
    - Learn traffic pattern management

2. **Institutional Portal**

    - Public-facing information display
    - Statistics and metrics visualization
    - Operational transparency

3. **Demonstration Platform**
    - Showcase ATC operations
    - Educational purposes
    - Technology demonstration

## Project Goals

-   **Showcase Technical Expertise:** Demonstrate proficiency in modern PHP development using Laravel and contemporary web technologies
-   **Portfolio Development:** Create a reference project highlighting professional growth from PHPNuke (2000) to modern Laravel applications (2025)
-   **Modernize Legacy Systems:** Transform a 25-year-old PHPNuke application into a cutting-edge, API-driven architecture
-   **Apply Best Practices:** Implement industry-standard patterns including MVC architecture, RESTful APIs, OAuth2 authentication, and comprehensive testing
-   **Demonstrate Domain Knowledge:** Combine real air traffic control experience with technical implementation
-   **Educational Purpose:** Serve as a learning platform for developers interested in both ATC systems and modern web development evolution

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).
