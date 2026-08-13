<?php
/**
 * contact.php
 * Reads the ?status=success / ?status=error flag set by
 * process_reservation.php after a form submission, and turns it
 * into the banner text shown near the top of the reservation form.
 */
$statusType = '';
$statusMsg  = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success') {
        $statusType = 'success';
        $statusMsg  = 'Thanks! Your reservation request has been saved to our system. We’ll confirm availability by email within 24 hours.';
    } elseif ($_GET['status'] === 'error') {
        $statusType = 'error';
        $statusMsg  = isset($_GET['msg'])
            ? htmlspecialchars($_GET['msg'])
            : 'Something went wrong. Please check the form and try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Savanna Edge Camp — Book / Contact</title>
<meta name="description" content="Reserve your stay, ask a question, or find directions to Savanna Edge Camp.">
<link rel="stylesheet" href="style.css">
<script src="script.js" defer></script>
</head>
<body>

<header class="site-header">
  <div class="header-inner">
    <a class="brand" href="index.html" style="display:flex;align-items:center;gap:.6rem;">
      <svg width="30" height="30" viewBox="0 0 40 40" aria-hidden="true">
        <path d="M20 6c-2 6-8 8-8 8s6 2 8 8c2-6 8-8 8-8s-6-2-8-8Z" fill="#D9A544"/>
      </svg>
      <span>Savanna Edge Camp<small>On the boundary of Nairobi National Park</small></span>
    </a>
    <nav class="primary-nav" aria-label="Primary">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="experiences.html">Experiences</a></li>
        <li><a href="stay.php">Stay &amp; Rates</a></li>
        <li><a href="contact.php" aria-current="page">Book / Contact</a></li>
      </ul>
    </nav>
  </div>
</header>

<main style="padding-top:2.5rem;">

  <span class="eyebrow">Bookings, questions, directions</span>
  <h1>Book Your Stay</h1>
  <p>Fill in the form below and our team will confirm availability by email within 24 hours. For same-week bookings, calling ahead is faster.</p>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:2.5rem;">
    <section>
      <h2>Getting Here</h2>
      <address>
        Savanna Edge Camp<br>
        Off Magadi Road, Mbagathi River boundary<br>
        Nairobi National Park (South Gate side)<br>
        <a href="tel:+254700123456">+254 700 123 456</a><br>
        <a href="mailto:stay@savannaedgecamp.example">stay@savannaedgecamp.example</a>
      </address>

      <div class="horizon-rule">
        <svg width="18" height="18" viewBox="0 0 40 40" aria-hidden="true"><path d="M20 6c-2 6-8 8-8 8s6 2 8 8c2-6 8-8 8-8s-6-2-8-8Z" fill="#4C8C86"/></svg>
        Office Hours
      </div>
      <table>
        <caption>When to reach us by phone</caption>
        <thead><tr><th scope="col">Day</th><th scope="col">Hours</th></tr></thead>
        <tbody>
          <tr><td>Monday – Friday</td><td>7:00 AM – 7:00 PM</td></tr>
          <tr><td>Saturday – Sunday</td><td>6:00 AM – 8:00 PM</td></tr>
        </tbody>
      </table>
      <p><small class="fine">Check-in is on-site at any hour if your dates are confirmed — the office hours above are for booking calls.</small></p>

      <div class="horizon-rule">
        <svg width="18" height="18" viewBox="0 0 40 40" aria-hidden="true"><path d="M20 6c-2 6-8 8-8 8s6 2 8 8c2-6 8-8 8-8s-6-2-8-8Z" fill="#4C8C86"/></svg>
        Find Us
      </div>
      <svg viewBox="0 0 300 170" width="100%" role="img" aria-labelledby="mapTitle" style="border:1px solid #3C4A31;border-radius:8px;background:#26331F;">
        <title id="mapTitle">Simplified map showing Savanna Edge Camp on the Mbagathi River boundary of Nairobi National Park, off Magadi Road</title>
        <path d="M0 60 Q150 90 300 55" stroke="#4C8C86" stroke-width="5" fill="none"/>
        <line x1="230" y1="0" x2="230" y2="170" stroke="#3C4A31" stroke-width="6"/>
        <rect x="0" y="120" width="300" height="50" fill="#1F2A19"/>
        <circle cx="150" cy="80" r="7" fill="#D9A544"/>
        <text x="163" y="84" fill="#F1EAD9" font-size="10" font-family="sans-serif">Savanna Edge Camp — Magadi Rd</text>
        <text x="235" y="16" fill="#A9AF97" font-size="9" font-family="sans-serif">Park fence</text>
      </svg>
    </section>

    <section>
      <h2>Reservation Request</h2>

      <div id="form-errors" role="alert" <?php echo $statusType === 'error' ? '' : 'hidden'; ?>><?php echo $statusType === 'error' ? $statusMsg : ''; ?></div>
      <div id="form-success" role="status" <?php echo $statusType === 'success' ? '' : 'hidden'; ?>><?php echo $statusType === 'success' ? $statusMsg : ''; ?></div>

      <form action="process_reservation.php" method="post" id="reservation-form" novalidate>
        <fieldset>
          <legend>Your details</legend>

          <label for="name">Full name</label>
          <input type="text" id="name" name="name" placeholder="Amina Wanjiru" required>

          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="you@example.com" required>

          <label for="phone">Phone</label>
          <input type="tel" id="phone" name="phone" placeholder="+254 7XX XXX XXX" required>
        </fieldset>

        <fieldset>
          <legend>Stay details</legend>

          <label for="arrive">Arrival date</label>
          <input type="date" id="arrive" name="arrive" required>

          <label for="nights">Number of nights</label>
          <input type="number" id="nights" name="nights" min="1" max="14" value="2" required>

          <label for="guests">Number of guests</label>
          <input type="number" id="guests" name="guests" min="1" max="20" value="2" required>

          <label>Camping option</label>
          <div class="radio-row">
            <input type="radio" id="opt-byo" name="camp-option" value="byo-tent" checked>
            <label for="opt-byo" style="display:inline;margin:0;">Bring Your Own Tent</label>
          </div>
          <div class="radio-row">
            <input type="radio" id="opt-furnished" name="camp-option" value="furnished-tent">
            <label for="opt-furnished" style="display:inline;margin:0;">Furnished Walk-In Tent</label>
          </div>
          <div class="radio-row">
            <input type="radio" id="opt-family" name="camp-option" value="family-site">
            <label for="opt-family" style="display:inline;margin:0;">Riverside Family Site</label>
          </div>

          <label>Activities you'd like included (check any)</label>
          <div class="checkbox-row">
            <input type="checkbox" id="act-walk" name="activities" value="nature-walk">
            <label for="act-walk" style="display:inline;margin:0;">Guided nature walk</label>
          </div>
          <div class="checkbox-row">
            <input type="checkbox" id="act-fish" name="activities" value="fishing">
            <label for="act-fish" style="display:inline;margin:0;">Guided fishing session</label>
          </div>
          <div class="checkbox-row">
            <input type="checkbox" id="act-drive" name="activities" value="game-drive">
            <label for="act-drive" style="display:inline;margin:0;">Guided game drive (park fee applies)</label>
          </div>

          <label for="meals">Meal plan</label>
          <select id="meals" name="meals">
            <option value="none">No meals — self-catering</option>
            <option value="breakfast">Breakfast only</option>
            <option value="full-board" selected>Full board (breakfast &amp; dinner)</option>
          </select>

          <label for="notes">Anything else we should know?</label>
          <textarea id="notes" name="notes" placeholder="Dietary needs, fishing experience level, first-time camper, etc."></textarea>
        </fieldset>

        <button type="submit">Send reservation request</button>
      </form>
      <p><small class="fine">Submissions are saved to a MySQL database via PHP for this class project — no real bookings are made, but the data really is stored.</small></p>
    </section>
  </div>

</main>

<footer class="site-footer">
  <div class="footer-inner">
    <div>
      <strong style="color:var(--cream);">Savanna Edge Camp</strong><br>
      Mbagathi River boundary, Nairobi National Park.
    </div>
    <nav aria-label="Footer">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="experiences.html">Experiences</a></li>
        <li><a href="stay.php">Stay &amp; Rates</a></li>
        <li><a href="contact.php">Book / Contact</a></li>
      </ul>
    </nav>
    <small class="fine">&copy; 2026 Savanna Edge Camp. A fictional campsite made for a class project.</small>
  </div>
</footer>

</body>
</html>
