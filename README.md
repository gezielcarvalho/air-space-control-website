# Institutional Portal for Air Traffic Control Unit

![Air Traffic Control](https://example.com/air-traffic-control-image.jpg)

## Introduction

This project is an institutional portal developed for an air traffic control unit, including a control tower and a radar approach control module. The portal provides real-time information and statistics about air traffic, flight status, radar data, and more. It is built using Laravel/PHP for the backend, SQLite for the database, and Vue.js for the frontend.

## Features

-   **Dashboard:** Display key statistics and information about air traffic.
-   **Control Tower Module:** View and update flight information for arrivals and departures.
-   **Radar Approach Control Module:** Track aircraft movement in the airspace and provide alerts for potential conflicts.
-   **User Authentication and Authorization:** Secure login system with role-based access control.
-   **Data Mocking:** Mock flight data for demonstration purposes.
-   **Reporting:** Generate reports on air traffic patterns, incidents, and operational statistics.

## Technologies Used

-   **Backend:** Laravel/PHP, SQLite
-   **Frontend:** Vue.js, Vuex
-   **Authentication:** Laravel Passport
-   **Data Mocking:** Faker PHP library
-   **Charts and Graphs:** Chart.js
-   **UI Framework:** Bootstrap or Tailwind CSS

## Project Structure

-   **`/backend`:** Laravel backend project.
-   **`/frontend`:** Vue.js frontend project.
-   **`/docs`:** Documentation folder.
-   **`/mock_data`:** Mock data generation scripts.

## Installation and Setup

1. Clone the repository: `git clone https://github.com/your-username/air-traffic-control-portal.git`
2. Set up the backend:
    - Navigate to the `/backend` directory.
    - Install dependencies: `composer install`
    - Set up the `.env` file with database credentials.
    - Run migrations: `php artisan migrate`
    - Start the backend server: `php artisan serve`
3. Set up the frontend:
    - Navigate to the `/frontend` directory.
    - Install dependencies: `npm install`
    - Start the development server: `npm run serve`
4. Access the application at `http://localhost:8080` in your web browser.

## Usage

-   Access the dashboard to view real-time statistics and graphs.
-   Use the control tower module to manage flight information.
-   Navigate to the radar approach control module to track aircraft movements.
-   Generate reports for analysis and archival purposes.

## Documentation

Detailed documentation on setting up and running the project, API endpoints, authentication mechanisms, and more can be found in the `/docs` folder.

## Contributing

Contributions are welcome! Please fork the repository and create a pull request with your changes.

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).
