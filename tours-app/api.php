<?php
// tours.php - Tours listing and booking API

session_start();
require_once 'config.php';

$db = initDatabase();

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

if ($action === 'list') {
    // Get all tours
    $stmt = $db->query("SELECT * FROM tours ORDER BY id");
    $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'tours' => $tours]);
    exit;
}

elseif ($action === 'book' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Book a tour
    $tour_id = isset($_POST['tour_id']) ? (int)$_POST['tour_id'] : null;
    $user_name = isset($_POST['user_name']) ? trim($_POST['user_name']) : '';
    $user_email = isset($_POST['user_email']) ? trim($_POST['user_email']) : '';
    $number_of_people = isset($_POST['number_of_people']) ? (int)$_POST['number_of_people'] : 0;
    
    // Validation
    if (!$tour_id || !$user_name || !$user_email || $number_of_people <= 0) {
        $_SESSION['error'] = 'All fields are required.';
        header('Location: index.php');
        exit;
    }
    
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email address.';
        header('Location: index.php');
        exit;
    }
    
    if ($number_of_people > 20) {
        $_SESSION['error'] = 'Maximum 20 people per booking.';
        header('Location: index.php');
        exit;
    }
    
    // Get the tour and check availability
    $stmt = $db->prepare("SELECT * FROM tours WHERE id = ?");
    $stmt->execute([$tour_id]);
    $tour = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$tour) {
        $_SESSION['error'] = 'Tour not found.';
        header('Location: index.php');
        exit;
    }
    
    // Core Logic: Check if slots are available
    if ($tour['available_slots'] < $number_of_people) {
        $_SESSION['error'] = 'Sorry! Only ' . $tour['available_slots'] . ' slots available for "' . $tour['name'] . '".';
        header('Location: index.php');
        exit;
    }
    
    // Begin transaction for atomicity
    $db->beginTransaction();
    
    try {
        // Create booking
        $stmt = $db->prepare("INSERT INTO bookings (tour_id, user_name, user_email, number_of_people) VALUES (?, ?, ?, ?)");
        $stmt->execute([$tour_id, $user_name, $user_email, $number_of_people]);
        $booking_id = $db->lastInsertId();
        
        // Reduce available slots
        $stmt = $db->prepare("UPDATE tours SET available_slots = available_slots - ? WHERE id = ?");
        $stmt->execute([$number_of_people, $tour_id]);
        
        $db->commit();
        
        $_SESSION['success'] = 'Booking successful! ' . $number_of_people . ' slot(s) booked for "' . $tour['name'] . '".';
        header('Location: index.php');
        exit;
        
    } catch (Exception $e) {
        $db->rollBack();
        $_SESSION['error'] = 'Booking failed. Please try again.';
        header('Location: index.php');
        exit;
    }
}
