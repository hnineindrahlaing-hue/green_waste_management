# Green Waste Management & Smart Collection System

A comprehensive web-based platform for managing waste collection, tracking garbage trucks, reporting waste issues, and promoting recycling through an online marketplace.

## Features

### 1. User Authentication System
- User registration with role-based access (Resident, Worker, Vendor, Admin)
- Secure login with password hashing
- Session management
- Profile management

### 2. Waste Collection Schedule
- View monthly collection calendars
- Zone-based schedule management
- Real-time schedule updates
- Admin can create and manage schedules

### 3. Real-Time Truck Tracking
- Live map-based truck tracking using Leaflet.js and OpenStreetMap
- View active garbage truck locations
- Track truck status (Active, Inactive, Maintenance)
- Admin can manage truck information

### 4. Crowdsourced Waste Reporting
- Submit waste complaints with images
- GPS location capture
- Report types: Overflowing Bin, Illegal Dumping, Other
- Track report status (Pending, In Progress, Resolved)
- Admin dashboard for report management

### 5. Recycling Marketplace
- Buy and sell recyclable materials online
- Create listings with images and pricing
- Browse available listings
- Manage personal listings
- Category-based organization

### 6. Admin Dashboard
- Comprehensive system statistics
- User management
- Schedule management
- Truck management
- Report management
- Listing moderation

### 7. Responsive Design
- Mobile-friendly interface
- Bootstrap 5 framework
- Optimized for all devices

## Technical Stack

| Component | Technology |
|-----------|-----------|
| Frontend | HTML5, CSS3, JavaScript |
| Backend | PHP 7.4+ |
| Database | MySQL 8.0+ |
| UI Framework | Bootstrap 5 |
| Maps | Leaflet.js with OpenStreetMap |
| Server | Apache/Nginx with PHP-FPM |

## Installation & Setup

### Prerequisites
- PHP 7.4 or higher
- MySQL 8.0 or higher
- Apache or Nginx web server
- Composer (optional, for dependency management)

### Step 1: Clone or Download the Project
```bash
cd /path/to/webroot
# Copy all project files to your web directory
```

### Step 2: Create Database
```bash
# Using MySQL command line
mysql -u root -p < create_db.sql

# Or manually:
# 1. Open MySQL client
# 2. Run the SQL commands from create_db.sql
```

### Step 3: Configure Database Connection
Edit `includes/db_config.php` and update the following:
```php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'your_password');
define('DB_NAME', 'green_waste_db');
```

### Step 4: Set File Permissions
```bash
chmod 755 uploads/
chmod 755 uploads/report_images/
chmod 755 uploads/listing_images/
```

### Step 5: Start the Web Server
```bash
# Using PHP built-in server (for development)
php -S localhost:8000

# Or configure Apache/Nginx to serve the project
```

### Step 6: Access the Application
Open your browser and navigate to:
```
http://localhost:8000
```

## File Structure

```
green_waste_management/
├── index.php                          # Homepage
├── login.php                          # User login page
├── register.php                       # User registration page
├── logout.php                         # User logout
├── create_db.sql                      # Database schema
├── includes/
│   ├── db_config.php                  # Database configuration
│   ├── auth.php                       # Authentication functions
│   ├── functions.php                  # Utility functions
│   ├── header.php                     # Page header template
│   └── footer.php                     # Page footer template
├── user/
│   ├── index.php                      # User dashboard
│   ├── view_schedules.php             # View collection schedules
│   ├── track_trucks.php               # Real-time truck tracking
│   ├── report_waste.php               # Report waste issues
│   ├── recycling_marketplace.php      # Browse marketplace
│   ├── create_listing.php             # Create new listing
│   ├── view_reports.php               # View user's reports
│   └── view_listings.php              # View user's listings
├── admin/
│   ├── index.php                      # Admin dashboard
│   ├── manage_users.php               # User management
│   ├── manage_schedules.php           # Schedule management
│   ├── manage_trucks.php              # Truck management
│   ├── manage_reports.php             # Report management
│   └── manage_listings.php            # Listing moderation
├── assets/
│   ├── css/
│   │   ├── bootstrap.min.css          # Bootstrap framework
│   │   └── style.css                  # Custom styles
│   ├── js/
│   │   ├── jquery.min.js              # jQuery library
│   │   ├── bootstrap.bundle.min.js    # Bootstrap JavaScript
│   │   └── script.js                  # Custom JavaScript
│   ├── images/                        # Image assets
│   └── maps/
│       ├── leaflet.js                 # Leaflet map library
│       └── leaflet.css                # Leaflet styles
├── uploads/
│   ├── report_images/                 # Uploaded report images
│   └── listing_images/                # Uploaded listing images
└── README.md                          # This file
```

## Database Schema

### Users Table
- `user_id` (INT, Primary Key)
- `username` (VARCHAR, Unique)
- `password` (VARCHAR, Hashed)
- `email` (VARCHAR, Unique)
- `role` (ENUM: resident, worker, vendor, admin)
- `created_at`, `updated_at` (TIMESTAMP)

### Schedules Table
- `schedule_id` (INT, Primary Key)
- `zone` (VARCHAR)
- `collection_date` (DATE)
- `collection_time` (TIME)
- `description` (VARCHAR)
- `created_at`, `updated_at` (TIMESTAMP)

### Trucks Table
- `truck_id` (INT, Primary Key)
- `truck_name` (VARCHAR)
- `license_plate` (VARCHAR, Unique)
- `current_latitude` (DECIMAL)
- `current_longitude` (DECIMAL)
- `status` (ENUM: active, inactive, maintenance)
- `last_updated` (TIMESTAMP)

### Reports Table
- `report_id` (INT, Primary Key)
- `user_id` (INT, Foreign Key)
- `report_type` (ENUM: overflowing bin, illegal dumping, other)
- `description` (TEXT)
- `latitude` (DECIMAL)
- `longitude` (DECIMAL)
- `image_url` (VARCHAR)
- `status` (ENUM: pending, resolved, in progress)
- `reported_at`, `resolved_at` (TIMESTAMP)

### Listings Table
- `listing_id` (INT, Primary Key)
- `user_id` (INT, Foreign Key)
- `title` (VARCHAR)
- `description` (TEXT)
- `category` (VARCHAR)
- `price` (DECIMAL)
- `unit` (VARCHAR)
- `image_url` (VARCHAR)
- `status` (ENUM: available, sold, pending)
- `posted_at`, `updated_at` (TIMESTAMP)

## User Roles & Permissions

| Role | Permissions |
|------|-------------|
| **Resident** | View schedules, Track trucks, Report waste, Browse marketplace, Create listings |
| **Worker** | View schedules, Track trucks, View reports |
| **Vendor** | Browse marketplace, Create listings, Manage listings |
| **Admin** | All permissions + User management, Schedule management, Truck management, Report management, Listing moderation |

## Security Features

- **Password Hashing**: Using PHP's `password_hash()` function
- **SQL Injection Prevention**: Using prepared statements
- **XSS Prevention**: Using `htmlspecialchars()` and `strip_tags()`
- **Session Management**: Secure session handling
- **Role-Based Access Control**: Enforced access restrictions

## API Endpoints (Future Enhancement)

The system can be extended with RESTful API endpoints for mobile applications:
- `GET /api/schedules` - Get all schedules
- `GET /api/trucks` - Get active trucks
- `POST /api/reports` - Create a report
- `GET /api/listings` - Get marketplace listings
- `POST /api/listings` - Create a listing

## Testing

### Test Accounts

**Admin Account:**
- Username: admin
- Password: admin123

**Resident Account:**
- Username: resident1
- Password: resident123

**Vendor Account:**
- Username: vendor1
- Password: vendor123

## Troubleshooting

### Database Connection Error
- Check MySQL is running
- Verify database credentials in `includes/db_config.php`
- Ensure database `green_waste_db` exists

### File Upload Issues
- Check write permissions on `uploads/` directory
- Verify file size limits in PHP configuration
- Check MIME type restrictions

### Map Not Loading
- Ensure Leaflet.js library is loaded
- Check internet connection for OpenStreetMap tiles
- Verify browser console for JavaScript errors

## Future Enhancements

1. **Mobile Application**: React Native or Flutter app
2. **Real-Time Notifications**: Push notifications for updates
3. **Payment Integration**: Stripe or PayPal for marketplace transactions
4. **Advanced Analytics**: Dashboard with charts and statistics
5. **SMS Notifications**: Twilio integration for SMS alerts
6. **Machine Learning**: Predictive waste collection optimization
7. **API Integration**: Third-party integrations for weather, traffic
8. **Multi-Language Support**: Internationalization (i18n)

## Performance Optimization

- Implement caching (Redis/Memcached)
- Database query optimization with indexes
- Lazy loading for images
- Minification of CSS and JavaScript
- CDN for static assets
- Gzip compression

## Deployment

### Production Deployment Checklist
- [ ] Update database credentials
- [ ] Set secure file permissions
- [ ] Enable HTTPS/SSL
- [ ] Configure firewall rules
- [ ] Set up automated backups
- [ ] Monitor error logs
- [ ] Implement rate limiting
- [ ] Set up CDN for static assets

## Support & Contribution

For issues, feature requests, or contributions, please contact the development team.

## License

This project is created for educational purposes as part of an internship program.

## Author

**Ma Hnin Eaindra Hlaing** (5CS-39)

## Acknowledgments

- Bootstrap Framework
- Leaflet.js for mapping
- OpenStreetMap for map tiles
- PHP and MySQL communities

---

**Version**: 1.0.0  
**Last Updated**: 2026  
**Status**: Production Ready
