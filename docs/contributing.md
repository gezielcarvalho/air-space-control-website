# Contributing to Air Space Control Website

Thank you for considering contributing to the Air Space Control Website! This document provides guidelines and instructions for contributing to the project.

## Table of Contents

-   [Code of Conduct](#code-of-conduct)
-   [Getting Started](#getting-started)
-   [Development Workflow](#development-workflow)
-   [Coding Standards](#coding-standards)
-   [Commit Message Guidelines](#commit-message-guidelines)
-   [Pull Request Process](#pull-request-process)
-   [Testing](#testing)
-   [Documentation](#documentation)

## Code of Conduct

### Our Pledge

We pledge to make participation in our project a harassment-free experience for everyone, regardless of age, body size, disability, ethnicity, gender identity and expression, level of experience, nationality, personal appearance, race, religion, or sexual identity and orientation.

### Our Standards

-   Use welcoming and inclusive language
-   Be respectful of differing viewpoints and experiences
-   Gracefully accept constructive criticism
-   Focus on what is best for the community
-   Show empathy towards other community members

## Getting Started

### Prerequisites

Before contributing, ensure you have:

1. **Forked the repository** on GitHub
2. **Cloned your fork** locally
3. **Set up the development environment** following the [Installation Guide](installation.md)
4. **Created a feature branch** for your changes

### Fork and Clone

```bash
# Fork the repository on GitHub, then:
git clone https://github.com/YOUR_USERNAME/air-space-control-website.git
cd air-space-control-website

# Add upstream remote
git remote add upstream https://github.com/gezielcarvalho/air-space-control-website.git

# Verify remotes
git remote -v
```

### Create a Feature Branch

```bash
# Update your local main branch
git checkout main
git pull upstream main

# Create a new feature branch
git checkout -b feature/your-feature-name
```

## Development Workflow

### 1. Make Your Changes

-   Write clean, readable code
-   Follow the project's coding standards
-   Add comments where necessary
-   Update documentation as needed

### 2. Test Your Changes

```bash
# Run PHP tests
./vendor/bin/phpunit

# Run specific test file
./vendor/bin/phpunit tests/Feature/YourTest.php

# Check code style
./vendor/bin/phpcs
```

### 3. Commit Your Changes

```bash
# Stage your changes
git add .

# Commit with a descriptive message
git commit -m "feat: add new flight tracking feature"
```

### 4. Push to Your Fork

```bash
git push origin feature/your-feature-name
```

### 5. Create a Pull Request

-   Go to GitHub and create a pull request from your fork
-   Fill out the pull request template
-   Link any related issues
-   Wait for review and address feedback

## Coding Standards

### PHP/Laravel Standards

#### PSR-12 Coding Style

Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding style standard.

**Key Points:**

-   Use 4 spaces for indentation
-   Opening braces on the same line for methods and classes
-   Use type hints and return types
-   Document all public methods

**Example:**

```php
<?php

namespace App\Services;

use App\Models\Flight;

class FlightService
{
    /**
     * Get all active flights.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveFlights(): Collection
    {
        return Flight::where('status', 'active')
            ->orderBy('scheduled_departure')
            ->get();
    }
}
```

#### Laravel Best Practices

-   Use Eloquent ORM for database queries
-   Follow RESTful API conventions
-   Use service classes for business logic
-   Implement form request validation
-   Use resource classes for API responses

### JavaScript/Vue.js Standards

#### Code Style

-   Use ES6+ syntax
-   2 spaces for indentation
-   Use `const` and `let`, avoid `var`
-   Use arrow functions where appropriate

**Example:**

```javascript
// Good
const fetchFlights = async () => {
    try {
        const response = await api.get("/flights");
        return response.data;
    } catch (error) {
        console.error("Error fetching flights:", error);
        throw error;
    }
};

// Avoid
var fetchFlights = function () {
    // ...
};
```

#### Vue.js Best Practices

-   Use Composition API for new components
-   Keep components small and focused
-   Use props for parent-to-child communication
-   Use events for child-to-parent communication
-   Use Pinia stores for shared state

**Example:**

```vue
<script setup>
import { ref, onMounted } from "vue";
import { useFlightStore } from "@/stores/flight";

const flightStore = useFlightStore();
const flights = ref([]);

onMounted(async () => {
    flights.value = await flightStore.fetchFlights();
});
</script>

<template>
    <div class="flights-list">
        <div v-for="flight in flights" :key="flight.id">
            {{ flight.flight_number }}
        </div>
    </div>
</template>
```

### Database Conventions

-   Use snake_case for table and column names
-   Use plural names for table names (e.g., `flights`, `users`)
-   Always add indexes for foreign keys
-   Use migrations for all schema changes

## Commit Message Guidelines

We follow the [Conventional Commits](https://www.conventionalcommits.org/) specification.

### Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

-   **feat:** A new feature
-   **fix:** A bug fix
-   **docs:** Documentation only changes
-   **style:** Code style changes (formatting, missing semi-colons, etc.)
-   **refactor:** Code changes that neither fix a bug nor add a feature
-   **perf:** Performance improvements
-   **test:** Adding or updating tests
-   **chore:** Changes to build process or auxiliary tools

### Examples

```bash
feat(api): add flight search endpoint

Implement search functionality for flights with filters
for date, status, and flight number.

Closes #123
```

```bash
fix(auth): resolve token expiration issue

Users were being logged out prematurely due to incorrect
token expiration calculation.

Fixes #456
```

```bash
docs(readme): update installation instructions

Add missing steps for passport installation and
clarify database setup process.
```

## Pull Request Process

### Before Submitting

-   [ ] Code follows project coding standards
-   [ ] All tests pass
-   [ ] New tests added for new features
-   [ ] Documentation updated
-   [ ] Commit messages follow guidelines
-   [ ] No merge conflicts with main branch

### Pull Request Template

When creating a pull request, include:

1. **Description:** Clear description of changes
2. **Type of Change:** Bug fix, feature, documentation, etc.
3. **Related Issues:** Link to related issues
4. **Testing:** How the changes were tested
5. **Screenshots:** If applicable
6. **Breaking Changes:** List any breaking changes

### Review Process

1. **Automated Checks:** CI/CD pipeline runs tests
2. **Code Review:** Maintainers review your code
3. **Feedback:** Address any requested changes
4. **Approval:** Once approved, your PR will be merged

## Testing

### Backend Testing

#### Unit Tests

Test individual classes and methods:

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\FlightService;

class FlightServiceTest extends TestCase
{
    public function test_can_get_active_flights()
    {
        $service = new FlightService();
        $flights = $service->getActiveFlights();

        $this->assertNotEmpty($flights);
    }
}
```

#### Feature Tests

Test API endpoints:

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class FlightApiTest extends TestCase
{
    public function test_can_list_flights()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')
            ->getJson('/api/flights');

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }
}
```

### Frontend Testing

#### Component Tests

```javascript
import { mount } from "@vue/test-utils";
import FlightList from "@/components/FlightList.vue";

describe("FlightList.vue", () => {
    it("renders flight list", () => {
        const wrapper = mount(FlightList, {
            props: {
                flights: [{ id: 1, flight_number: "AA123" }],
            },
        });

        expect(wrapper.text()).toContain("AA123");
    });
});
```

## Documentation

### Code Documentation

-   Document all public methods and classes
-   Use PHPDoc for PHP code
-   Use JSDoc for JavaScript code
-   Include usage examples where helpful

### User Documentation

When adding new features, update:

-   README.md (if applicable)
-   API documentation (docs/api.md)
-   Installation guide (docs/installation.md)
-   Architecture documentation (docs/architecture.md)

## Getting Help

-   **Questions:** Open a [GitHub Discussion](https://github.com/gezielcarvalho/air-space-control-website/discussions)
-   **Bugs:** Open a [GitHub Issue](https://github.com/gezielcarvalho/air-space-control-website/issues)
-   **Security Issues:** Email the maintainers privately

## Recognition

Contributors will be recognized in:

-   GitHub Contributors page
-   Project documentation
-   Release notes

Thank you for contributing! 🎉
