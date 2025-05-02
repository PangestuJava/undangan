# Wedding Invitation Platform

Welcome to the **Wedding Invitation Platform**, a modern and scalable web application designed to create, manage, and share digital invitations for weddings and special events. Built with Laravel and utilizing multi-tenant architecture, this platform allows users to create personalized invitations with ease while administrators manage multiple tenants seamlessly.

## Table of Contents

-   [Features](#features)
-   [Tech Stack](#tech-stack)
-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Usage](#usage)
-   [Contributing](#contributing)
-   [License](#license)
-   [Contact](#contact)

## Features

-   **Multi-Tenant Support**: Each user (tenant) gets their own isolated database for managing invitations, powered by [Tenancy for Laravel](https://tenancyforlaravel.com/).
-   **Customizable Invitations**: Create beautiful, responsive digital invitations with customizable templates.
-   **Guest Management**: Track RSVPs, guest details, and attendance status.
-   **Centralized Admin Dashboard**: Admins can view and manage all tenant databases from a central interface.
-   **Secure Authentication**: User authentication with role-based access control.
-   **Mobile-Friendly**: Fully responsive design for seamless access on any device.
-   **Email Notifications**: Automated email invitations and RSVP confirmations.

## Tech Stack

-   **Backend**: Laravel 11.x
-   **Frontend**: Blade templates with Tailwind CSS
-   **Database**: MySQL (central and tenant databases)
-   **Tenancy**: [Tenancy for Laravel](https://tenancyforlaravel.com/) for multi-tenant architecture
-   **Others**: PHP 8.2+, Composer, Node.js (for frontend assets)

## Installation

### Prerequisites

-   PHP >= 8.2
-   Composer
-   Node.js & npm
-   MySQL
-   Web server (e.g., Nginx or Apache)

### Steps

1. **Clone the Repository**

    ```bash
    git clone https://github.com/yourusername/wedding-invitation-platform.git
    cd wedding-invitation-platform
    ```

2. **Install Dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Set Up Environment**

    - Copy the `.env.example` file to `.env`:
        ```bash
        cp .env.example .env
        ```
    - Update the `.env` file with your database credentials and other settings:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=central_db
        DB_USERNAME=your_username
        DB_PASSWORD=your_password
        ```

4. **Generate Application Key**

    ```bash
    php artisan key:generate
    ```

5. **Run Migrations**

    - Run migrations for the central database:
        ```bash
        php artisan migrate
        ```
    - Set up tenancy migrations (for tenant databases):
        ```bash
        php artisan tenancy:migrate
        ```

6. **Compile Frontend Assets**

    ```bash
    npm run dev
    ```

7. **Start the Server**
    ```bash
    php artisan serve
    ```
    The application will be available at `http://localhost:8000`.

## Configuration

-   **Tenancy Setup**: Configure the `config/tenancy.php` file to customize tenant database naming, storage, and other settings. Refer to the [Tenancy for Laravel documentation](https://tenancyforlaravel.com/docs/v3/) for details.
-   **Mail Configuration**: Set up your mail driver in `.env` for sending email invitations (e.g., SMTP, Mailgun).
-   **Storage**: Configure file storage for invitation assets (e.g., images) in `config/filesystems.php`.

## Usage

1. **Create a Tenant**:

    - Register a new tenant via the admin dashboard or CLI:
        ```bash
        php artisan tenancy:create tenant_name
        ```
    - This creates a new tenant with an isolated database.

2. **Design Invitations**:

    - Log in as a tenant user and use the invitation builder to create and customize your invitation.

3. **Invite Guests**:

    - Add guests and send invitations via email or shareable links.

4. **Track RSVPs**:

    - Monitor guest responses and attendance status in real-time.

5. **Admin Access**:

    - Use the central dashboard to view all tenant databases and manage tenants:

        ```php
        use App\Models\Tenant;

        $tenants = Tenant::all();
        foreach ($tenants as $tenant) {
            echo "Tenant: {$tenant->id}, Database: {$tenant->getDatabaseName()}\n";
        }
        ```

## Contributing

We welcome contributions! To contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature`).
3. Make your changes and commit (`git commit -m "Add your feature"`).
4. Push to the branch (`git push origin feature/your-feature`).
5. Open a Pull Request.

Please ensure your code follows the PSR-12 coding standard and includes tests.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Contact

For questions or support, please contact:

-   **Email**: your.email@example.com
-   **GitHub**: [yourusername](https://github.com/yourusername)

Thank you for using the Wedding Invitation Platform! 🎉
