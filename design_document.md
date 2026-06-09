# Green Waste Management & Smart Collection System - Design Document

## 1. Database Schema

### Entities and Attributes:

#### 1.1. `users` Table
- `user_id` (INT, Primary Key, Auto-increment)
- `username` (VARCHAR(50), Unique, Not Null)
- `password` (VARCHAR(255), Not Null) - *Hashed password*
- `email` (VARCHAR(100), Unique, Not Null)
- `role` (ENUM('resident', 'worker', 'vendor', 'admin'), Not Null, Default 'resident')
- `created_at` (TIMESTAMP, Default CURRENT_TIMESTAMP)
- `updated_at` (TIMESTAMP, Default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

#### 1.2. `schedules` Table
- `schedule_id` (INT, Primary Key, Auto-increment)
- `zone` (VARCHAR(100), Not Null)
- `collection_date` (DATE, Not Null)
- `collection_time` (TIME, Not Null)
- `description` (VARCHAR(255))
- `created_at` (TIMESTAMP, Default CURRENT_TIMESTAMP)
- `updated_at` (TIMESTAMP, Default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

#### 1.3. `trucks` Table
- `truck_id` (INT, Primary Key, Auto-increment)
- `truck_name` (VARCHAR(100), Not Null)
- `license_plate` (VARCHAR(20), Unique, Not Null)
- `current_latitude` (DECIMAL(10, 8))
- `current_longitude` (DECIMAL(11, 8))
- `status` (ENUM('active', 'inactive', 'maintenance'), Default 'inactive')
- `last_updated` (TIMESTAMP, Default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

#### 1.4. `reports` Table
- `report_id` (INT, Primary Key, Auto-increment)
- `user_id` (INT, Foreign Key to `users.user_id`)
- `report_type` (ENUM('overflowing bin', 'illegal dumping', 'other'), Not Null)
- `description` (TEXT)
- `latitude` (DECIMAL(10, 8))
- `longitude` (DECIMAL(11, 8))
- `image_url` (VARCHAR(255)) - *Path to uploaded image*
- `status` (ENUM('pending', 'resolved', 'in progress'), Default 'pending')
- `reported_at` (TIMESTAMP, Default CURRENT_TIMESTAMP)
- `resolved_at` (TIMESTAMP)

#### 1.5. `listings` Table
- `listing_id` (INT, Primary Key, Auto-increment)
- `user_id` (INT, Foreign Key to `users.user_id`)
- `title` (VARCHAR(255), Not Null)
- `description` (TEXT)
- `category` (VARCHAR(100))
- `price` (DECIMAL(10, 2))
- `unit` (VARCHAR(50))
- `image_url` (VARCHAR(255)) - *Path to uploaded image*
- `status` (ENUM('available', 'sold', 'pending'), Default 'available')
- `posted_at` (TIMESTAMP, Default CURRENT_TIMESTAMP)
- `updated_at` (TIMESTAMP, Default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)

### Relationships:
- `users` ONE-TO-MANY `reports` (via `user_id`)
- `users` ONE-TO-MANY `listings` (via `user_id`)

## 2. Project File Structure

```
/green_waste_management
├── index.php
├── login.php
├── register.php
├── dashboard.php
├── admin/
│   ├── index.php
│   ├── manage_users.php
│   ├── manage_schedules.php
│   ├── manage_reports.php
│   ├── manage_listings.php
│   └── ...
├── user/
│   ├── index.php
│   ├── view_schedules.php
│   ├── track_trucks.php
│   ├── report_waste.php
│   ├── recycling_marketplace.php
│   └── ...
├── assets/
│   ├── css/
│   │   ├── style.css
│   │   └── bootstrap.min.css
│   ├── js/
│   │   ├── script.js
│   │   ├── jquery.min.js
│   │   └── bootstrap.bundle.min.js
│   ├── images/
│   │   ├── logo.png
│   │   └── ...
│   └── maps/
│       ├── leaflet.js
│       ├── leaflet.css
│       └── ...
├── includes/
│   ├── header.php
│   ├── footer.php
│   ├── db_config.php
│   ├── functions.php
│   └── auth.php
├── uploads/
│   ├── report_images/
│   └── listing_images/
├── .htaccess
├── README.md
└── design_document.md
```
