# Institutional Portal for Air Traffic Control Unit

![Air Traffic Control Portal](./public/assets/images/atc.png)

## Introduction

This project is an institutional portal developed for an air traffic control unit, including a control tower and a radar approach control module. The portal simulates real-time information and statistics about air traffic, flight status, radar data, and more. It is built using Laravel/PHP for the backend, MySQL for the database, and Vue.js for the frontend.

## History

This project was based on my experience working as an Air Traffic Controller from 1994 to 2013. During this period, in addition to my normal responsibilities, I worked on IT projects such as website building, process automation, and data analysis. This project is the outcome of my experience in air traffic control, as well as my interest in information technology and processes.

## Features

In the original project, the following features were implemented:

-   **Landing Page:** Display key statistics and information about the ACT facility.
-   **User Authentication and Authorization:** Secure login system with role-based access control.
-   **Reporting:** Generate reports on air traffic patterns, incidents, and operational statistics.

In this versions, I decided to add the following:

-   **Control Tower Module:** View and update flight information for arrivals and departures.
-   **Radar Approach Control Module:** Track aircraft movement in the airspace and provide alerts for potential conflicts.
-   **Data Mocking:** Mock flight data for demonstration purposes.

## Technologies Used

Originally, the project was **developed in 2003** using PHP, MySQL, and JavaScript. However, I have decided to update the project to use the following technologies:

-   **Backend:** Laravel/PHP, MySQL
-   **Frontend:** Vue.js, Pina
-   **Authentication:** Laravel Passport
-   **Data Mocking:** Faker PHP library
-   **Charts and Graphs:** Chart.js
-   **UI Framework:** Tailwind CSS

## Installation and Setup

1. Clone the repository: `git clone https://github.com/gezielcarvalho/air-space-control-website.git`
2. Install dependencies
    - composer install
3. Set configurations
    - cp .env.example .env
4. Create a database and update .env file
5. Generate encryption key
    - php artisan key:generate
6. Create database structure
    - **php artisan migrate:fresh --seed**
7. Install passport
    - **php artisan passport:install --force**
8. Regenerate swagger documentation
    - **php artisan l5-swagger:generate**
9. Refresh cache and routes
    - **php artisan optimize**
10. Set up the frontend:
    - Install dependencies: `npm install`
    - Run the development server: `npm run dev`
11. Access the application at `http://localhost` or the appropriate URL in your web browser.

## Usage

-   Access the dashboard to view real-time statistics and graphs.
-   Use the control tower module to manage flight information.
-   Navigate to the radar approach control module to track aircraft movements.
-   Generate reports for analysis and archival purposes.

## Documentation

Detailed documentation on setting up and running the project, API endpoints, authentication mechanisms, and more can be found in the [Wiki Pages](https://github.com/gezielcarvalho/air-space-control-website/wiki) of this repository.

## References

1. [Laravel Documentation](https://laravel.com/docs)
2. [Vue.js Documentation](https://vuejs.org/v2/guide/)
3. [Vue 3 in Laravel 10 with Vite](https://medium.com/@DevMahmoudAdel/how-to-install-vue-3-in-laravel-10-with-vite-5c7749afd29c)
4. [Tailwind Vite and Laravel](https://chipperci.com/news/vite-tailwind-laravel)
5. [Passport API Authentication](https://laravel.com/docs/10.x/passport)
6. [Time Zones](https://en.wikipedia.org/wiki/List_of_time_zone_abbreviations)

## Contributing

Contributions are welcome! Please fork the repository and create a pull request with your changes.

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).
