# Tours Booking Platform

A simple yet fully functional tours booking system built with pure PHP.

## Features Implemented

✅ **Tours Listing** - Display all available tours with details
✅ **Tour Management** - 5 pre-seeded tours with different prices and capacities
✅ **Booking System** - Users can book tours with validation
✅ **Slot Management** - Automatic slot reduction after each booking
✅ **Availability Check** - Prevents overbooking with proper error handling
✅ **Form Validation** - Email validation, required fields, people limits
✅ **Responsive UI** - Beautiful, basic frontend with gradient design
✅ **Session Management** - Success/error messages persist across requests
✅ **Atomic Transactions** - Database transactions ensure data consistency
✅ **API Endpoints** - Clean REST-like API for tours and bookings

## Project Structure

```
tours-app/
├── index.php           # Main page - displays all tours and booking forms
├── api.php             # Backend logic for tours listing and bookings
├── config.php          # Database initialization and configuration
├── test_booking.php    # Testing script to verify functionality
├── tours.db            # SQLite database (created automatically)
└── README.md           # This file
```

## Routes

### Frontend

- **GET /** - Tours listing page

### API Endpoints

- **GET /api.php?action=list** - Get all tours as JSON
- **POST /api.php?action=book** - Create a new booking

## Core Logic: Booking System

### When Booking a Tour:

1. **Validation** - Checks user input (name, email, number of people)
2. **Availability Check** - Verifies available slots >= requested people
3. **Atomic Transaction** - Uses database transaction for consistency
4. **Slot Deduction** - Reduces available slots by number of people booked
5. **Confirmation** - Returns success message

### Security Features:

- Email validation with filter_var()
- Input sanitization with htmlspecialchars()
- SQL injection prevention with prepared statements
- Maximum 20 people per booking
- Transaction rollback on failure

## Database

### Tables

**tours**

```sql
id (integer, primary key)
name (string)
description (text)
price (decimal)
total_slots (integer)
available_slots (integer)
created_at (timestamp)
```

**bookings**

```sql
id (integer, primary key)
tour_id (foreign key)
user_name (string)
user_email (string)
number_of_people (integer)
created_at (timestamp)
```

## Seeded Tours

1. **Paris City Tour** - $150/person, 50 slots
2. **Italian Adventure** - $250/person, 40 slots
3. **London Historical Tour** - $120/person, 60 slots
4. **Alps Mountain Trek** - $200/person, 25 slots
5. **Spanish Fiesta Experience** - $180/person, 35 slots

## Running the Application

### Start the Server

```bash
cd d:\tours-booking-app\tours-app
php -S localhost:8080
```

### Access the App

Open your browser and navigate to: `http://localhost:8080`

### Run Tests

```bash
php test_booking.php
```

## Test Results

✅ **5 tours successfully seeded**
✅ **Booking system working correctly**
✅ **Slots deducted properly (50 → 47 after booking 3 people)**
✅ **Booking data persisted in database**
✅ **Transaction rollback working**

## Error Handling

The application handles:

- ✅ Empty form fields
- ✅ Invalid email addresses
- ✅ Overbooking attempts
- ✅ Non-existent tours
- ✅ Maximum people limit (20)
- ✅ Database connection errors

## Example Workflow

1. User visits `http://localhost:8080`
2. Page loads and displays 5 available tours
3. User fills in:
    - Name: "Jane Smith"
    - Email: "jane@example.com"
    - Number of People: 2
4. User clicks "Book Now"
5. System validates input
6. System checks availability (e.g., 50 slots available)
7. System creates booking record
8. System reduces slots (50 → 48)
9. User sees success message
10. Tour card updates with new slot count

## Bonus Features Implemented

✅ Success/error messages after booking
✅ UI prevents booking when slots are 0 (disabled button)
✅ Form remembers user's name and email
✅ Beautiful gradient design
✅ Smooth animations and transitions
✅ Responsive grid layout

## Code Quality

- Clear and readable code structure
- Proper error handling and validation
- Database transactions for data consistency
- Prepared statements to prevent SQL injection
- Separation of concerns (API, UI, config)
- Comprehensive test coverage
