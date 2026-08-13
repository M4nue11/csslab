<?php
/**
 * process_reservation.php
 * Receives the POST from contact.php, validates it server-side
 * (never trust client-side JS alone), saves it to MySQL, then
 * redirects back to contact.php with a status flag. This
 * redirect-after-POST pattern stops the browser from resubmitting
 * the form if the visitor refreshes the confirmation page.
 */

require_once __DIR__ . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}

// ---- Collect & trim input ----
$name       = trim($_POST['name'] ?? '');
$email      = trim($_POST['email'] ?? '');
$phone      = trim($_POST['phone'] ?? '');
$arrive     = trim($_POST['arrive'] ?? '');
$nights     = trim($_POST['nights'] ?? '');
$guests     = trim($_POST['guests'] ?? '');
$campOption = trim($_POST['camp-option'] ?? '');
$activities = $_POST['activities'] ?? [];   // array, from the checkboxes
$meals      = trim($_POST['meals'] ?? '');
$notes      = trim($_POST['notes'] ?? '');

// ---- Server-side validation ----
// (Mirrors the client-side checks in script.js, but this is the copy
// that actually matters — JS can be disabled or bypassed.)
$errors = [];

if ($name === '') {
    $errors[] = 'Full name is required.';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'A valid email address is required.';
}
if ($phone === '') {
    $errors[] = 'Phone number is required.';
}
if ($arrive === '' || !DateTime::createFromFormat('Y-m-d', $arrive)) {
    $errors[] = 'A valid arrival date is required.';
}
if ($nights === '' || !ctype_digit($nights) || (int) $nights < 1 || (int) $nights > 14) {
    $errors[] = 'Nights must be a number between 1 and 14.';
}
if ($guests === '' || !ctype_digit($guests) || (int) $guests < 1 || (int) $guests > 20) {
    $errors[] = 'Guests must be a number between 1 and 20.';
}
if ($campOption === '') {
    $errors[] = 'Please choose a camping option.';
}
if ($meals === '') {
    $errors[] = 'Please choose a meal plan.';
}

if (!empty($errors)) {
    header('Location: contact.php?status=error&msg=' . urlencode(implode(' ', $errors)));
    exit;
}

// ---- Save to the database ----
$activitiesStr = implode(', ', array_map('trim', $activities));

try {
    $stmt = $pdo->prepare(
        'INSERT INTO reservations
            (full_name, email, phone, arrival_date, nights, guests, camp_option, activities, meal_plan, notes)
         VALUES
            (:full_name, :email, :phone, :arrival_date, :nights, :guests, :camp_option, :activities, :meal_plan, :notes)'
    );

    $stmt->execute([
        ':full_name'    => $name,
        ':email'        => $email,
        ':phone'        => $phone,
        ':arrival_date' => $arrive,
        ':nights'       => (int) $nights,
        ':guests'       => (int) $guests,
        ':camp_option'  => $campOption,
        ':activities'   => $activitiesStr,
        ':meal_plan'    => $meals,
        ':notes'        => $notes,
    ]);
} catch (PDOException $e) {
    header('Location: contact.php?status=error&msg=' . urlencode('Something went wrong saving your request. Please try again.'));
    exit;
}

header('Location: contact.php?status=success');
exit;
