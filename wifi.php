<?php
session_start();

// Initialize variables
$message = '';
$messageType = '';
$showPopup = false;

// Show popup only once per session (comment this block out if you want it every visit)
if (!isset($_SESSION['popup_shown'])) {
    $showPopup = true;
    $_SESSION['popup_shown'] = true;
} else {
    $showPopup = true; // Set to false if you want once-per-session
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $showPopup = true; // Keep popup open after submit
    $phone  = trim($_POST['phone'] ?? '');
    $bundle = trim($_POST['bundle'] ?? '');

    // Basic validation
    if (empty($phone) || empty($bundle)) {
        $message = "⚠️ Please fill in all fields.";
        $messageType = "error";
    } elseif (!preg_match('/^(?:\+?254|0)[17]\d{8}$/', $phone)) {
        $message = "⚠️ Please enter a valid Kenyan phone number (e.g. 0712345678).";
        $messageType = "error";
    } else {
        // ✅ Here you would normally:
        // - Save to database
        // - Call an API (e.g. M-Pesa Daraja STK Push)
        // - Send an SMS confirmation
        $message = "✅ Success! You have subscribed to <strong>" . htmlspecialchars($bundle) . "</strong> on <strong>" . htmlspecialchars($phone) . "</strong>. You will receive a confirmation SMS shortly.";
        $messageType = "success";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Subscription</title>
<style>
    * { box-sizing: border-box; }
    body {
        margin: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    /* Popup overlay */
    .popup-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.65);
        backdrop-filter: blur(4px);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }
    .popup-overlay.active { display: flex; }

    /* Popup box */
    .popup-box {
        background: #ffffff;
        padding: 30px 28px;
        border-radius: 16px;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
        position: relative;
        animation: popIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    @keyframes popIn {
        from { transform: scale(0.7) translateY(20px); opacity: 0; }
        to   { transform: scale(1) translateY(0);       opacity: 1; }
    }

    .popup-box h2 {
        margin: 0 0 4px;
        text-align: center;
        color: #1a1a2e;
        font-size: 24px;
    }
    .popup-box .subtitle {
        text-align: center;
        color: #777;
        font-size: 13px;
        margin-bottom: 22px;
    }

    .close-btn {
        position: absolute;
        top: 14px;
        right: 18px;
        font-size: 26px;
        color: #aaa;
        cursor: pointer;
        line-height: 1;
        transition: color 0.2s;
    }
    .close-btn:hover { color: #333; }

    label {
        display: block;
        margin: 14px 0 6px;
        font-weight: 600;
        color: #444;
        font-size: 14px;
    }
    input, select {
        width: 100%;
        padding: 12px 14px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 15px;
        background: #f9fafb;
        transition: border-color 0.2s, background 0.2s;
        outline: none;
    }
    input:focus, select:focus {
        border-color: #667eea;
        background: #fff;
    }

    .subscribe-btn {
        margin-top: 22px;
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.15s, box-shadow 0.2s;
    }
    .subscribe-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.45);
    }
    .subscribe-btn:active { transform: translateY(0); }

    .message {
        margin-top: 16px;
        padding: 12px 14px;
        border-radius: 10px;
        font-size: 14px;
        text-align: center;
        line-height: 1.5;
    }
    .message.success {
        background: #e6ffed;
        color: #1a7f37;
        border: 1px solid #b7ebc6;
    }
    .message.error {
        background: #ffeef0;
        color: #b62324;
        border: 1px solid #ffc9cd;
    }
</style>
</head>
<body>

    <h1 style="color:#fff; text-align:center; font-weight:300;">
        Welcome 👋
    </h1>

    <!-- Popup -->
    <div class="popup-overlay <?= $showPopup ? 'active' : '' ?>" id="popup">
        <div class="popup-box">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <h2>📶 Data Subscription</h2>
            <p class="subtitle">Buy affordable data bundles instantly</p>

            <form method="POST" action="">
                <label for="phone">Phone Number</label>
                <input type="tel" name="phone" id="phone"
                       placeholder="e.g. 0712345678"
                       value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                       required>

                <label for="bundle">Choose Bundle</label>
                <select name="bundle" id="bundle" required>
                    <option value="">-- Select a bundle --</option>
                    <option value="1GB - KES 100"  <?= (($_POST['bundle'] ?? '') === '1GB - KES 100')  ? 'selected' : '' ?>>1GB - KES 100</option>
                    <option value="2GB - KES 200"  <?= (($_POST['bundle'] ?? '') === '2GB - KES 200')  ? 'selected' : '' ?>>2GB - KES 200</option>
                    <option value="5GB - KES 450"  <?= (($_POST['bundle'] ?? '') === '5GB - KES 450')  ? 'selected' : '' ?>>5GB - KES 450</option>
                    <option value="10GB - KES 800" <?= (($_POST['bundle'] ?? '') === '10GB - KES 800') ? 'selected' : '' ?>>10GB - KES 800</option>
                </select>

                <button type="submit" class="subscribe-btn">Subscribe Now</button>
            </form>

            <?php if (!empty($message)): ?>
                <div class="message <?= $messageType ?>"><?= $message ?></div>
            <?php endif; ?>
        </div>
    </div>

<script>
    function closePopup() {
        document.getElementById('popup').classList.remove('active');
    }

    // Close when clicking outside the box
    document.getElementById('popup').addEventListener('click', function(e) {
        if (e.target === this) closePopup();
    });

    // Close with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePopup();
    });
</script>

</body>
</html>