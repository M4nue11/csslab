# Savanna Edge Camp — running this with XAMPP

This site now has two parts:
- **Static pages** — `index.html`, `experiences.html` (no PHP needed)
- **Database-driven pages** — `stay.php`, `contact.php`, `process_reservation.php`, `admin.php` (need PHP + MySQL, i.e. XAMPP)

## 1. Install / open XAMPP
Download from https://www.apachefriends.org if you don't have it, then open the **XAMPP Control Panel** and click **Start** next to both:
- **Apache**
- **MySQL**

Both rows should turn green.

## 2. Copy the site into htdocs
Copy this whole folder (keep the name, or rename it — just remember what you used) into XAMPP's `htdocs` directory:

- Windows: `C:\xampp\htdocs\savanna-edge-camp\`
- macOS: `/Applications/XAMPP/htdocs/savanna-edge-camp/`
- Linux: `/opt/lampp/htdocs/savanna-edge-camp/`

So `htdocs\savanna-edge-camp\index.html`, `...\stay.php`, `...\db\schema.sql`, etc.

## 3. Create the database
1. Open **http://localhost/phpmyadmin** in your browser.
2. Click **SQL** in the top tab bar.
3. Open `db/schema.sql` from this folder in a text editor, copy all of it, paste it into the SQL box in phpMyAdmin, and click **Go**.

This creates the `savanna_edge_camp` database with three tables (`reservations`, `packages`, `availability`) and a few starter rows for `packages` and `availability`.

If your MySQL root user has a password (most default XAMPP installs don't), open `includes/db.php` and set `$DB_PASS` to match.

## 4. Visit the site
With Apache and MySQL both running, open:

```
http://localhost/savanna-edge-camp/index.html
```

Browse from there using the site's own navigation — `index.html` and `experiences.html` are plain HTML, `stay.php` and `contact.php` are PHP.

## 5. Try it end-to-end
1. Go to **Stay & Rates** — the three package cards and the availability percentage are being read live from MySQL.
2. Go to **Book / Contact**, fill in the form, and submit.
   - Leave a required field blank first to see the JavaScript validation catch it.
   - Then fill everything in — the form posts to `process_reservation.php`, which re-validates on the server, saves the row to the `reservations` table, and redirects back with a green confirmation banner.
3. Open **http://localhost/savanna-edge-camp/admin.php** to see every reservation that's been saved, straight from the database. (This page has no login — it's for verifying your setup, not for a real deployment.)

## Troubleshooting
- **"Database connection failed"** — Apache is running but MySQL isn't, or you haven't imported `db/schema.sql` yet, or the DB name/user/password in `includes/db.php` doesn't match your setup.
- **Page shows raw PHP code instead of running it** — you opened the file directly (`file:///...`) instead of through `http://localhost/...`. PHP only runs when served by Apache.
- **Port 80 already in use** — another program (like Skype or IIS) is using port 80; change Apache's port in the XAMPP config, or stop the other program.
