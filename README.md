
# To-Do List App

The "To-Do List" app is a simple task management system. It allows users to add, edit, view, and delete tasks, as well as manage priorities, deadlines, and task statuses. Additionally, the app sends email notifications for tasks with approaching due dates.

## Technologies

- PHP 8.2
- Laravel 11.31
- MySQL 9.1.0
- Node.js, npm, Vite, Tailwind CSS

### Optional Requirements:

- Docker
- Supervisord

## Installation

### 1. Clone the Repository

Clone the repository to your local environment:

```bash
git clone https://github.com/spinomik/Simple_toDoList.git
cd Simple_toDoList
```

### 2. Configure .env

Copy the `.env.example` file and create the `.env` file:

```bash
cp .env.example .env
```

Configure the database credentials, application settings, mailer settings, Docker settings, database settings, and admin credentials.

### Running the App

```bash
docker-compose build
docker-compose up -d
```

Docker will automatically install all the necessary dependencies and execute migrations and seeding if required. If you want to run the app locally without Docker:

```bash
npm install
composer install
php artisan migrate
php artisan db:seed
php artisan serve
```

You can now open the app in your browser at: [http://localhost:8080]\*.
\*Port and domain may differ depending on your settings.

## Features

### 1. Task CRUD

Users can create, edit, delete, and view tasks with the following attributes:

- **Assigned person** (editable only by an administrator)
- **Task name** (max. 255 characters)
- **Description** (optional)
- **Priority** (`low`, `medium`, `high`)
- **Status** (`to-do`, `in progress`, `done`)
- **Due date** (required)

### 2. Task Filtering

Users can filter tasks based on:

- **Assigned user** (only visible to administrators, users can see only their tasks)
- **Task name** (partial search)
- **Priority** (low/medium/high)
- **Status** (to-do/in-progress/done)
- **Due date** (e.g., tasks approaching the due date)

### 3. Task Sorting

Users can sort the task list based on:

- **Assigned user** (only visible to administrators, users can see only their tasks)
- **Task name** (partial search)
- **Priority** (low/medium/high)
- **Status** (to-do/in-progress/done)
- **Due date** (e.g., tasks approaching the due date)

### 4. Email Notifications

The application sends email notifications to users **1 day before the task due date**. Notifications are managed via queues and a scheduler in Laravel. Additionally, notifications are only sent to users with tasks that have a status of **in progress** or **to-do**. The scheduler checks the task list every **5 minutes**, adding tasks to the queue. After the notification is sent, the **notification_sent** flag is set on the task in the "tasks" table to avoid sending multiple emails. When editing a task, this flag is removed, and a new notification is sent.

### 5. Validation

Forms are validated at all stages (frontend + backend) to ensure that the data is correct. The following are required:

- **Task name** (max. 255 characters, required)
- **Description** (if provided, max. 1000 characters)
- **Priority** and **Status** must have valid values
- **Due date** (date, required)
- **Assigned person** (administrator can create tasks for others)

### 6. Multi-user Support

The app allows users to create accounts, log in, and manage their tasks (default users only have access to task management: read/edit/delete/create). The application uses Laravel's built-in authentication system. Additionally, middleware for managing permissions is added. Users with the **ADMIN** role have full access, including managing users (edit permissions, delete accounts, or block users). Blocked users cannot log in and will be notified of their account suspension. Users can change their passwords, edit their profile, or delete their account.

## Additional Features (optional)

### 7. Task Edit History

The app logs every change made to tasks, enabling users to view previous versions of tasks (names, descriptions, priorities, statuses, dates, assigned users, and the person who edited the task).

### 8. Share Tasks

Users can generate **public links** to tasks that are available for a specific time. The links contain an access token, which expires after a set time. The token can also be deactivated earlier within a task or profile settings. Generating tokens is only available for administrators or users with the **PUBLIC_TOKEN_GENERATE** permission. The default expiration time is 60 minutes, and this value can be set in the ENV file **PUBLIC_TOKEN_EXPIRY**. Tokens can also be viewed in the profile settings, and users with **PUBLIC_TOKEN_DELETE** or **ADMIN** permissions can delete tokens.

<!-- ### 9. Google Calendar Integration

The app allows you to attach important tasks to **Google Calendar**. Users can sync tasks with Google Calendar using the **Spatie Laravel Google Calendar** library. -->

### Features

    - Google/Apple ID login
    - Google Calendar/Apple Calendar integration
    - Dark mode
    - Language switch
    - Optimization (component-based views)
    - Rework user roles (spatie/laravel-permission)
    - Fix flowbite import
    - Fix password reset
    - Standardize and unify notifications
    - Add a management tab for public tokens for administrators
    - Allow status changes without task edits
    - Home page (add task overview)
    - Add an archive for completed tasks
    - Improve filter window in tasks
    - Add tests

## Project Structure

- **app/** - Application Logic
  - **Models/** - Eloquent Models
  - **Http/** - Controllers and APIs
  - **Enums/** - Enums for permissions, statuses, and priorities
  - **Notifications/** - Notifications
- **config/** - Configuration
- **database/** - Migrations and seeders
- **docker/** - Docker-related files
- **resources/** - Frontend
  - **images/** - Images
  - **views/** - Blade Views
- **routes/** - Routing definitions for the app
- **storage/**
  - **logs/** - Logs

## Technical Requirements

- Laravel 11
- REST API and Eloquent ORM
- MySQL as the database
- Frontend using Blade
- Docker app configuration

## Authors

Project created by Mikołaj Majewski.

## License

This project is licensed under the MIT License.
