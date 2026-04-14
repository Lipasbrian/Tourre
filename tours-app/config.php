<?php
// config.php - Database configuration and tour data

// Use SQLite for simplicity
define('DB_FILE', __DIR__ . '/tours.db');

// Initialize database
function initDatabase() {
    if (!file_exists(DB_FILE)) {
        $db = new PDO('sqlite:' . DB_FILE);
        
        // Create tours table
        $db->exec("
            CREATE TABLE tours (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                description TEXT NOT NULL,
                price REAL NOT NULL,
                total_slots INTEGER NOT NULL,
                available_slots INTEGER NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        // Create bookings table
        $db->exec("
            CREATE TABLE bookings (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                tour_id INTEGER NOT NULL,
                user_name TEXT NOT NULL,
                user_email TEXT NOT NULL,
                number_of_people INTEGER NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY(tour_id) REFERENCES tours(id)
            )
        ");
        
        // Seed tours
        $tours = [
            ['Paris City Tour', 'Explore the beautiful city of Paris with visits to Eiffel Tower, Louvre, and Notre-Dame.', 150, 50],
            ['Italian Adventure', 'Experience Italy - Vatican City, Rome, Florence, and Venice in one amazing tour.', 250, 40],
            ['London Historical Tour', 'Discover London\'s rich history with tours of Big Ben, Tower of London, and Buckingham Palace.', 120, 60],
            ['Alps Mountain Trek', 'Hiking adventure in the Swiss Alps with breathtaking mountain views.', 200, 25],
            ['Spanish Fiesta Experience', 'Experience authentic Spanish culture, flamenco, and delicious cuisine in Barcelona and Madrid.', 180, 35],
        ];
        
        $stmt = $db->prepare("INSERT INTO tours (name, description, price, total_slots, available_slots) VALUES (?, ?, ?, ?, ?)");
        foreach ($tours as $tour) {
            $stmt->execute(array_merge($tour, [$tour[3]]));
        }
        
        return $db;
    }
    return new PDO('sqlite:' . DB_FILE);
}

function getDB() {
    return new PDO('sqlite:' . DB_FILE);
}
