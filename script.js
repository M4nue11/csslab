/* ============================================================
   SAVANNA EDGE CAMP — site interactivity (script.js)
   One external file, linked from every page. Each feature looks
   for its own elements first and quietly does nothing if they
   aren't on the current page — so this file can be safely linked
   everywhere without throwing errors.
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {
  initWelcomeMessage();   // Home page
  initInfoToggle();       // Home page
  initActivitySpotlight();// Experiences page
  initPackageSelector();  // Stay & Rates page
  initContactForm();      // Book / Contact page
});

/* ------------------------------------------------------------
   1. WELCOME MESSAGE (Home page)
   Prompts the visitor for their name once, remembers it for
   next time using localStorage, and displays a personalised
   greeting in the #welcome-message element.
   ------------------------------------------------------------ */
function initWelcomeMessage() {
  var welcomeEl = document.getElementById('welcome-message');
  if (!welcomeEl) return; // element only exists on index.html

  var storedName = localStorage.getItem('savannaGuestName');

  if (!storedName) {
    var input = window.prompt("Welcome to Savanna Edge Camp! What's your name?");
    if (input && input.trim() !== '') {
      storedName = input.trim();
      localStorage.setItem('savannaGuestName', storedName);
    }
  }

  welcomeEl.textContent = storedName
    ? 'Welcome back to camp, ' + storedName + ' — glad you\u2019re here.'
    : 'Welcome to Savanna Edge Camp — glad you\u2019re here.';
  welcomeEl.hidden = false;
}

/* ------------------------------------------------------------
   2. SHOW / HIDE EXTRA INFO (Home page)
   Dynamic content feature: reveals a hidden paragraph of extra
   detail about the boundary fence when the button is clicked,
   and toggles the button label to match.
   ------------------------------------------------------------ */
function initInfoToggle() {
  var toggleBtn = document.getElementById('fence-info-toggle');
  var extraInfo = document.getElementById('fence-info-extra');
  if (!toggleBtn || !extraInfo) return;

  toggleBtn.addEventListener('click', function () {
    var isHidden = extraInfo.hasAttribute('hidden');
    if (isHidden) {
      extraInfo.removeAttribute('hidden');
      toggleBtn.textContent = 'Show less';
    } else {
      extraInfo.setAttribute('hidden', '');
      toggleBtn.textContent = 'Show more about the fence line';
    }
  });
}

/* ------------------------------------------------------------
   3. ACTIVITY SPOTLIGHT SWITCHER (Experiences page)
   Dynamic content feature: clicking an activity button swaps the
   heading, text, and accent colour of the spotlight panel, and
   highlights whichever button is currently active.
   ------------------------------------------------------------ */
function initActivitySpotlight() {
  var buttons = document.querySelectorAll('.spotlight-btn');
  var panel = document.getElementById('spotlight-panel');
  if (buttons.length === 0 || !panel) return;

  var content = {
    camping: {
      title: 'Camping',
      text: 'Three ways to sleep here: bring your own tent, a furnished walk-in tent, or the Riverside Family Site — all inside the electric perimeter fence along the river.',
      color: '#D9A544'
    },
    wildlife: {
      title: 'Wildlife Viewing',
      text: 'Watch zebra, giraffe and warthog from the raised deck at no extra cost, or book a half-day guided game drive into the park itself.',
      color: '#4C8C86'
    },
    walks: {
      title: 'Guided Nature Walks',
      text: 'Two armed rangers lead every walk along the buffer land — sunrise bird walks, track-and-sign walks, and a sundowner walk that ends looking at the skyline.',
      color: '#E7C36B'
    },
    fishing: {
      title: 'Guided Fishing',
      text: 'Catch-and-release fishing for tilapia and barbel on the Mbagathi River and the camp dam. Rods, bait and a guide are included.',
      color: '#6FB3AC'
    }
  };

  buttons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var key = btn.getAttribute('data-activity');
      var data = content[key];
      if (!data) return;

      panel.querySelector('h3').textContent = data.title;
      panel.querySelector('p').textContent = data.text;
      panel.style.borderColor = data.color;

      buttons.forEach(function (b) { b.classList.remove('is-active'); });
      btn.classList.add('is-active');
    });
  });
}

/* ------------------------------------------------------------
   4. PACKAGE SELECTOR (Stay & Rates page)
   Dynamic content feature: clicking a package card highlights it
   (colour change) and writes a confirmation-style summary of the
   choice into the page.
   ------------------------------------------------------------ */
function initPackageSelector() {
  var cards = document.querySelectorAll('.package-card');
  var summary = document.getElementById('package-summary');
  if (cards.length === 0 || !summary) return;

  cards.forEach(function (card) {
    card.addEventListener('click', function () {
      cards.forEach(function (c) { c.classList.remove('is-selected'); });
      card.classList.add('is-selected');

      var name = card.getAttribute('data-name');
      var price = card.getAttribute('data-price');
      summary.textContent = 'You selected the ' + name + ' package (' + price + ' per person). Mention this on the booking form and we\u2019ll apply it.';
      summary.hidden = false;
    });
  });
}

/* ------------------------------------------------------------
   5. FORM VALIDATION + CONFIRMATION (Book / Contact page)
   Checks every required field on submit. If any are blank, the
   submission is stopped and an error message is shown, with the
   first empty field focused and outlined. If everything is
   filled in, a confirmation message is displayed and the form
   resets — no real backend, this is a class project.
   ------------------------------------------------------------ */
function initContactForm() {
  var form = document.getElementById('reservation-form');
  if (!form) return;

  var errorBox = document.getElementById('form-errors');
  var successBox = document.getElementById('form-success');

  form.addEventListener('submit', function (event) {
    event.preventDefault();

    var errors = [];
    var requiredFields = form.querySelectorAll('[required]');

    requiredFields.forEach(function (field) {
      field.classList.remove('field-error');
      if (!field.value || field.value.trim() === '') {
        errors.push(field);
        field.classList.add('field-error');
      }
    });

    if (errors.length > 0) {
      successBox.hidden = true;
      errorBox.hidden = false;
      errorBox.textContent = 'Please fill in all required fields (' + errors.length + ' left blank) before sending your request.';
      errors[0].focus();
      return;
    }

    errorBox.hidden = true;
    successBox.hidden = false;
    successBox.textContent = 'Thanks! Your reservation request has been noted. We\u2019ll confirm availability by email within 24 hours.';
    form.reset();
  });
}
