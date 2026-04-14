<?php
// test_booking.php - Test the booking functionality

require_once 'config.php';

// Initialize database if needed
$db = initDatabase();

// Test 1: Check if tours were seeded
echo "=== TEST 1: Check Seeded Tours ===\n";
$stmt = $db->query("SELECT * FROM tours");
$tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Total tours: " . count($tours) . "\n";
foreach ($tours as $tour) {
    echo "- {$tour['name']}: {$tour['available_slots']}/{$tour['total_slots']} slots\n";
}

// Test 2: Simulate a booking
echo "\n=== TEST 2: Simulate Booking ===\n";

$tour_id = 1;
$user_name = "John Doe";
$user_email = "john@example.com";
$number_of_people = 3;

// Get tour
$stmt = $db->prepare("SELECT * FROM tours WHERE id = ?");
$stmt->execute([$tour_id]);
$tour = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Tour: {$tour['name']}\n";
echo "Slots before booking: {$tour['available_slots']}\n";

if ($tour['available_slots'] >= $number_of_people) {
    $db->beginTransaction();
    try {
        // Insert booking
        $stmt = $db->prepare("INSERT INTO bookings (tour_id, user_name, user_email, number_of_people) VALUES (?, ?, ?, ?)");
        $stmt->execute([$tour_id, $user_name, $user_email, $number_of_people]);
        
        // Update slots
        $stmt = $db->prepare("UPDATE tours SET available_slots = available_slots - ? WHERE id = ?");
        $stmt->execute([$number_of_people, $tour_id]);
        
        $db->commit();
        echo "✓ Booking successful!\n";
    } catch (Exception $e) {
        $db->rollBack();
        echo "✗ Booking failed: " . $e->getMessage() . "\n";
    }
}

// Check updated slots
$stmt = $db->prepare("SELECT * FROM tours WHERE id = ?");
$stmt->execute([$tour_id]);
$tour_updated = $stmt->fetch(PDO::FETCH_ASSOC);
echo "Slots after booking: {$tour_updated['available_slots']}\n";

// Test 3: Check all bookings
echo "\n=== TEST 3: All Bookings ===\n";
$stmt = $db->query("SELECT b.*, t.name as tour_name FROM bookings b JOIN tours t ON b.tour_id = t.id");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Total bookings: " . count($bookings) . "\n";
foreach ($bookings as $booking) {
    echo "- {$booking['user_name']} ({$booking['user_email']}): {$booking['number_of_people']} people for {$booking['tour_name']}\n";
}

echo "\n=== ALL TESTS COMPLETED ===\n\n";
