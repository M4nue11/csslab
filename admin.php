<?php
/**
 * admin.php
 * Lists every row in the reservations table, newest first. This
 * has no login — it's here purely so you (or your instructor) can
 * confirm that contact.php is actually writing to MySQL. Do not
 * use this pattern (an unprotected admin page) on a real, public
 * website.
 */
require_once __DIR__ . '/includes/db.php';

$reservations = $pdo
    ->query('SELECT * FROM reservations ORDER BY submitted_at DESC')
    ->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Savanna Edge Camp — Reservations (Admin)</title>
<meta name="robots" content="noindex, nofollow">
<link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
  <div class="header-inner">
    <a class="brand" href="index.html" style="display:flex;align-items:center;gap:.6rem;">
      <svg width="30" height="30" viewBox="0 0 40 40" aria-hidden="true">
        <path d="M20 6c-2 6-8 8-8 8s6 2 8 8c2-6 8-8 8-8s-6-2-8-8Z" fill="#D9A544"/>
      </svg>
      <span>Savanna Edge Camp<small>Admin — reservation requests</small></span>
    </a>
    <nav class="primary-nav" aria-label="Primary">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="stay.php">Stay &amp; Rates</a></li>
        <li><a href="contact.php">Book / Contact</a></li>
      </ul>
    </nav>
  </div>
</header>

<main style="padding-top:2.5rem;">

  <span class="eyebrow">Staff view — not linked from the public site</span>
  <h1>Reservation Requests</h1>
  <p><small class="fine">This page has no login and is here only to prove that submissions from the Book / Contact form are being saved to the <code>savanna_edge_camp</code> MySQL database. In a real deployment this page would sit behind authentication.</small></p>

  <table>
    <caption><?php echo count($reservations); ?> reservation request(s) on file</caption>
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Contact</th>
        <th scope="col">Arrival</th>
        <th scope="col">Nights</th>
        <th scope="col">Guests</th>
        <th scope="col">Option</th>
        <th scope="col">Activities</th>
        <th scope="col">Meals</th>
        <th scope="col">Notes</th>
        <th scope="col">Submitted</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($reservations)): ?>
        <tr><td colspan="10">No reservations yet — submit the form on the Book / Contact page to see one appear here.</td></tr>
      <?php else: ?>
        <?php foreach ($reservations as $r): ?>
        <tr>
          <td><?php echo htmlspecialchars($r['full_name']); ?></td>
          <td><?php echo htmlspecialchars($r['email']); ?><br><?php echo htmlspecialchars($r['phone']); ?></td>
          <td><?php echo htmlspecialchars($r['arrival_date']); ?></td>
          <td><?php echo (int) $r['nights']; ?></td>
          <td><?php echo (int) $r['guests']; ?></td>
          <td><?php echo htmlspecialchars($r['camp_option']); ?></td>
          <td><?php echo htmlspecialchars($r['activities'] ?: '—'); ?></td>
          <td><?php echo htmlspecialchars($r['meal_plan']); ?></td>
          <td><?php echo htmlspecialchars($r['notes'] ?: '—'); ?></td>
          <td><?php echo htmlspecialchars($r['submitted_at']); ?></td>
        </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>

</main>

<footer class="site-footer">
  <div class="footer-inner">
    <div>
      <strong style="color:var(--cream);">Savanna Edge Camp</strong><br>
      Admin view — reservations table.
    </div>
    <small class="fine">&copy; 2026 Savanna Edge Camp. A fictional campsite made for a class project.</small>
  </div>
</footer>

</body>
</html>
