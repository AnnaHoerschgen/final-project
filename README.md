# Event Planner – Final Project

## Description
A small PHP application that allows the public to view and register for events, and allows an admin to manage events and view registrations. This project demonstrates PHP fundamentals including MVC structure, PDO, sessions, prepared statements, form handling, and basic security practices.

## Project Structure
```pgsql
Main Folder/
│
├── assets/
│   ├── stylesheets/
│   │   └── styles.css
│   └── data/
│       ├── database.sql
│       ├── functions.php
│       └── db.php
│
├── controllers/
│   ├── admin.php
│   └── client.php
│
├── models/
│   ├── AdminModel.php
│   ├── EventModel.php
│   └── RegistrationModel.php
│
├── view-stuffs/
│   ├── partials/
│   │   ├── header.php
│   │   └── footer.php
│   └── views/
│       ├── admin_dashboard.php
│       ├── admin_event_form.php
│       ├── admin_login.php
│       ├── admin_registrations.php
│       ├── public_confirm.php
│       ├── public_event.php
│       └── public_events.php
│
└── index.php
```

## How the Application Works
### MVC Architecture
The application follows a simple MVC (Model–View–Controller) structure:
-	**Models**: Contain all database logic using prepared PDO statements.
-	**Controllers**: Receive user actions, call models, and load appropriate views.
-	**Views**: Display HTML output. All dynamic output is escaped with ```htmlspecialchars()```.
-	**Database**: The database is created using *database.sql* in */assets/data/*.

### Includes:
-	**admins** – stores 1 admin with a password hash
-	**events** – event records
-	**registrations** – records of users registering for events

### Admin password is:
-	**username:** *admin*
-	**password:** *finalproject*

**Password hash is provided in SQL.**

### Public Features:
#### Upcoming Events Page (```public_event.php```)
-	Lists only events where the date is today or later.
-	Shows event title, date, and location.
-	Clicking an event goes to the detail page.

#### Event Details + Registration (```public_events.php```):

Contains:
-	Full event details
-	Registration form that collects:
-	Name
-	Email
-	The event ID (hidden field tied to database)

#### Registration Processing:
When a user submits the form:
-	Server-side validation checks required fields and email format.
-	Controller calls RegistrationModel to insert a row using prepared statements.

#### Confirmation page (```public_confirm.php```) displays:
-	Username
-	Event title they registered for

##### Admin Features:
-	Admin Login (admin_login.php)
-	Uses AdminModel to verify credentials.
-	Password is checked with ``` password_verify()```.
-	A session is created upon successful login.

#### Session Protection:
Every admin page checks:
```php
if (!isset($_SESSION['admin_logged_in'])) { redirect to login }
```
*This ensures all admin functionality requires authentication.*

#### Admin Dashboard (```admin_dashboard.php```):
##### Shows links to:
-	Add Event
-	Manage Existing Events
-	View Registrations

##### Event Management:
-	Add Event: Admin can add a new event using admin_event_form.php.
-	Edit Event: Admin chooses an event, form loads existing data, and updates the record via prepared statement.
-	Delete Event: Admin can delete an event permanently.
-	*All modifications use the EventModel.*

#### Registrations by Event (```admin_registrations.php```):
-	Lists all events.
-	Each event displays the names + emails of people who registered.
-	Uses a grouped query in RegistrationModel.

#### Security & Best Practices Used:
-	PDO prepared statements for all SQL with variables.
-	Password hashing + ```password_verify()```.
-	Session-based login protection for admin pages.
-	HTML escaping ```htmlspecialchars()``` to prevent XSS.
-	Server-side form validation on all inputs.

### Styling:
The site uses a simple stylesheet located at: ```/assets/stylesheets/styles.css```

**It ensures:**
-	Clean layout
-	Basic spacing
-	Readable font sizes
-	Clear form formatting
-	It is NOT meant to be fancy - just neat and professional.

## How to Run:
    1.	Import database.sql into a MySQL server - perform through phpMyAdmin.
    2.	Adjust database credentials in assets/data/db.php.
    3.	Place project in a PHP-enabled environment (XAMPP, WAMP, MAMP, or live server). Highly reccommend XAMPP - that's what I used.

### Visit:
-   Public site: ```/index.php```
-   Admin login: ```/index.php?page=admin&action=login```

## Expected Functionality Checklist:
-	MVC structure
-	PDO + prepared statements
-	Admin login with hash + password_verify
-	Session protection
-	Public event list (future events only)
-	Event detail + registration
-	Registration saved to DB
-	Admin CRUD for events
-	Admin view registrations grouped by event
-	Clean UI with basic CSS
-	No extra features added