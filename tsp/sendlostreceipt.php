<!-- Styles for the form (Tailwind CSS and custom styles) -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* Ensure Inter font is applied if not already */
    body {
        font-family: 'Inter', sans-serif;
    }
    .form-container {
        background-color: #ffffff;
        padding: 2.5rem; /* 40px */
        border-radius: 1rem; /* 16px */
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        max-width: 600px;
        width: 100%;
        margin: 0 auto; /* Center the form if it's in a wider container */
    }
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #374151; /* Darker gray for labels */
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem; /* 12px */
        border: 1px solid #d1d5db; /* Light gray border */
        border-radius: 0.5rem; /* 8px */
        font-size: 1rem;
        color: #1f2937; /* Dark text */
        background-color: #f9fafb; /* Slightly off-white input background */
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #6366f1; /* Indigo focus border */
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25); /* Indigo focus shadow */
    }
    .form-group input::placeholder {
        color: #9ca3af; /* Placeholder text color */
    }
    .submit-button {
        width: 100%;
        padding: 0.875rem 1.5rem; /* 14px 24px */
        background-color: #6366f1; /* Indigo button */
        color: #ffffff;
        font-weight: 600;
        border-radius: 0.75rem; /* 12px */
        border: none;
        cursor: pointer;
        font-size: 1.125rem; /* 18px */
        transition: background-color 0.2s ease-in-out, transform 0.1s ease-in-out;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .submit-button:hover {
        background-color: #4f46e5; /* Darker indigo on hover */
        transform: translateY(-1px);
    }
    .submit-button:active {
        transform: translateY(0);
    }
    .message-box {
        margin-top: 1.5rem;
        padding: 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        text-align: center;
        display: none; /* Hidden by default */
    }
    .message-box.success {
        background-color: #d1fae5; /* Green light */
        color: #065f46; /* Green dark */
        border: 1px solid #34d399;
    }
    .message-box.error {
        background-color: #fee2e2; /* Red light */
        color: #991b1b; /* Red dark */
        border: 1px solid #ef4444;
    }
</style>

<!-- The form content -->
<div class="form-container">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Lost Receipt Request</h2>

    <form id="emailForm" action="/tsp/send_email.php" method="POST">
        <!-- Email Information -->
        <div class="mb-6">
              <div class="form-group mb-4">
                <label for="recipient_email">Recipient Email(s) (comma-separated):</label>
                <input type="email" id="recipient_email" name="recipient_email" placeholder="e.g., recipient@example.com" required multiple>
            </div>
            <div class="form-group mb-4">
                <label for="cc_emails">CC Email(s) (comma-separated, optional):</label>
                <input type="email" id="cc_emails" name="cc_emails" placeholder="e.g., cc1@example.com, cc2@example.com" multiple>
            </div>
            <div class="form-group mb-4">
                <label for="sender_email">Your Email:</label>
                <input type="email" id="sender_email" name="sender_email" placeholder="e.g., your_email@example.com" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" placeholder="Lost Receipt" required>
            </div>
        </div>

        <!-- Expense Information -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Expense Details</h3>
            <div class="form-group mb-4">
                <label for="expense_date">Date of Expense:</label>
                <input type="text" id="expense_date" name="expense_date" placeholder="Select date" required>
            </div>
            <div class="form-group mb-4">
                <label for="expense_type">Expense Type:</label>
                <select id="expense_type" name="expense_type" required>
                    <option value="">-- Select Expense Type --</option>
                    <option value="Travel">Travel</option>
                    <option value="Meals">Meals</option>
                    <option value="Accommodation">Hotel</option>
                    <option value="Supplies">Supplies</option>
                    <option value="Software">Fuel</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="amount">Amount ($):</label>
                <input type="number" id="amount" name="amount" step="0.01" min="0" placeholder="e.g., 123.45" required>
            </div>
            <div class="form-group mb-4">
                <label for="business_name">Business Name:</label>
                <input type="text" id="business_name" name="business_name" placeholder="e.g., Acme Corp" required>
            </div>
            <div class="form-group mb-4">
                <label for="business_location">Business Location:</label>
                <input type="text" id="business_location" name="business_location" placeholder="e.g., New York, NY" required>
            </div>
            <div class="form-group mb-4">
                <label for="contract_number">Contract # (optional):</label>
                <input type="text" id="contract_number" name="contract_number" placeholder="e.g., C-12345">
            </div>
            <div class="form-group">
                <label for="ticket_number">Ticket # (optional):</label>
                <input type="text" id="ticket_number" name="ticket_number" placeholder="e.g., T-67890">
            </div>
        </div>

        <button type="submit" class="submit-button">Submit Lost Receipt</button>
    </form>

    <!-- Message Box for feedback -->
    <div id="messageBox" class="message-box"></div>
</div>

<!-- JavaScript for Flatpickr and form submission -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Initialize Flatpickr for the date input
    flatpickr("#expense_date", {
        dateFormat: "Y-m-d", // YYYY-MM-DD format
        altInput: true,
        altFormat: "F j, Y", // e.g., "November 4, 2023"
        maxDate: "today" // Prevent selecting future dates
    });

    // Handle form submission with AJAX for user feedback
    document.getElementById('emailForm').addEventListener('submit', async function(event) {
        event.preventDefault(); // Prevent default form submission

        const form = event.target;
        const formData = new FormData(form);
        const messageBox = document.getElementById('messageBox');

        // Clear previous messages
        messageBox.style.display = 'none';
        messageBox.className = 'message-box';
        messageBox.textContent = '';

        try {
            const response = await fetch(form.action, {
                method: form.method,
                body: formData
            });

            const result = await response.text(); // Get response as text

            if (response.ok) {
                messageBox.classList.add('success');
                messageBox.textContent = result; // Display success message from PHP
            } else {
                messageBox.classList.add('error');
                messageBox.textContent = result || 'An unknown error occurred.'; // Display error message from PHP
            }
        } catch (error) {
            console.error('Error:', error);
            messageBox.classList.add('error');
            messageBox.textContent = 'Failed to send email. Please check your network connection.';
        } finally {
            messageBox.style.display = 'block'; // Show the message box
        }
    });
</script>
