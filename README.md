# Laravel ATS (Applicant Tracking System)

A modern Applicant Tracking System built with Laravel 12 and Filament 3, inspired by Workable.

## Features

- **Job Management**
  - Create and manage job postings
  - Track job status (open, closed, draft)
  - Set application deadlines
  - Define job requirements and benefits
  - Support for different job types (full-time, part-time, contract)

- **Candidate Management**
  - Track candidate applications
  - Manage candidate status through the hiring pipeline
  - Store candidate information and documents
  - Track candidate sources
  - Manage interviews and feedback

- **Dashboard**
  - Overview of key recruitment metrics
  - Track active jobs and applications
  - Monitor hiring pipeline status

## Requirements

- PHP 8.2+
- Laravel 12
- MySQL 8.0+
- Composer
- Node.js & NPM

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd laravel-ats
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install NPM dependencies:
```bash
npm install
```

4. Copy the environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_ats
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run migrations:
```bash
php artisan migrate
```

8. Create a storage link for file uploads:
```bash
php artisan storage:link
```

9. Start the development server:
```bash
php artisan serve
```

10. Build assets:
```bash
npm run dev
```

## Usage

1. Access the admin panel at `/admin`
2. Create your first job posting
3. Start managing candidates and applications

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the MIT License.
