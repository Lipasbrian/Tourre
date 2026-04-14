<?php session_start(); ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tours Booking Platform</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        header {
            background-color: rgba(255, 255, 255, 0.95);
            color: #333;
            padding: 30px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        header p {
            color: #666;
            font-size: 16px;
        }
        
        .alert {
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            display: none;
            animation: slideDown 0.3s ease-out;
        }
        
        .alert.show {
            display: block;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 5px solid #dc3545;
        }
        
        .tours-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 25px;
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        .tour-card {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .tour-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }
        
        .tour-card h2 {
            color: #333;
            margin-bottom: 12px;
            font-size: 22px;
        }
        
        .tour-card p {
            color: #666;
            margin-bottom: 20px;
            flex-grow: 1;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .tour-card .price {
            font-size: 26px;
            color: #667eea;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        .tour-card .slots-info {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .slots-info .slots-available {
            color: #667eea;
            font-weight: bold;
        }
        
        .slots-info.no-slots {
            background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
        }
        
        .slots-info.no-slots .slots-available {
            color: #d63031;
        }
        
        .booking-form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        label {
            font-weight: 600;
            margin-bottom: 6px;
            font-size: 13px;
            color: #333;
        }
        
        input {
            padding: 10px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        button:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        button:active {
            transform: scale(0.98);
        }
        
        button:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .no-tours {
            text-align: center;
            padding: 60px 40px;
            background: white;
            border-radius: 12px;
            color: #666;
        }
        
        .no-tours h2 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .loading {
            text-align: center;
            padding: 40px;
            color: white;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>🌍 Tours Booking Platform</h1>
            <p>Discover and book amazing tours from around the world</p>
        </header>
        
        <?php 
        if (isset($_SESSION['success'])): 
        ?>
        <div class="alert alert-success show">
            ✅ <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
        <?php endif; ?>
        
        <?php 
        if (isset($_SESSION['error'])): 
        ?>
        <div class="alert alert-error show">
            ❌ <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
        <?php endif; ?>
        
        <div id="tours-container" class="loading">
            Loading tours...
        </div>
    </div>
    
    <script>
        // Load tours from API
        fetch('api.php?action=list')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.tours.length > 0) {
                    const container = document.getElementById('tours-container');
                    container.className = 'tours-grid';
                    container.innerHTML = '';
                    
                    data.tours.forEach(tour => {
                        const hasSlots = tour.available_slots > 0;
                        const card = document.createElement('div');
                        card.className = 'tour-card';
                        card.innerHTML = `
                            <h2>${escapeHtml(tour.name)}</h2>
                            <p>${escapeHtml(tour.description)}</p>
                            <div class="price">$${parseFloat(tour.price).toFixed(2)} per person</div>
                            <div class="slots-info ${!hasSlots ? 'no-slots' : ''}">
                                <strong>Available Slots:</strong>
                                <span class="slots-available">${tour.available_slots} / ${tour.total_slots}</span>
                            </div>
                            ${hasSlots ? `
                                <form action="api.php?action=book" method="POST" class="booking-form">
                                    <div class="form-group">
                                        <label for="name_${tour.id}">Your Name</label>
                                        <input type="text" id="name_${tour.id}" name="user_name" required 
                                               placeholder="John Doe" value="${escapeHtml(sessionStorage.getItem('last_name') || '')}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email_${tour.id}">Email</label>
                                        <input type="email" id="email_${tour.id}" name="user_email" required 
                                               placeholder="john@example.com" value="${escapeHtml(sessionStorage.getItem('last_email') || '')}">
                                    </div>
                                    <div class="form-group">
                                        <label for="people_${tour.id}">Number of People</label>
                                        <input type="number" id="people_${tour.id}" name="number_of_people" 
                                               value="1" min="1" max="${tour.available_slots}" required>
                                    </div>
                                    <input type="hidden" name="tour_id" value="${tour.id}">
                                    <button type="submit">Book Now</button>
                                </form>
                            ` : `
                                <button disabled style="background: #ccc; cursor: not-allowed;">
                                    FULLY BOOKED
                                </button>
                            `}
                        `;
                        container.appendChild(card);
                        
                        // Save form data to sessionStorage
                        const form = card.querySelector('form');
                        if (form) {
                            form.addEventListener('submit', function(e) {
                                const nameInput = form.querySelector('input[name="user_name"]');
                                const emailInput = form.querySelector('input[name="user_email"]');
                                if (nameInput) sessionStorage.setItem('last_name', nameInput.value);
                                if (emailInput) sessionStorage.setItem('last_email', emailInput.value);
                            });
                        }
                    });
                } else {
                    document.getElementById('tours-container').innerHTML = `
                        <div class="no-tours">
                            <h2>No tours available</h2>
                            <p>Check back later for new tours!</p>
                        </div>
                    `;
                    document.getElementById('tours-container').className = 'no-tours';
                }
            })
            .catch(error => {
                console.error('Error loading tours:', error);
                document.getElementById('tours-container').innerHTML = `
                    <div class="no-tours">
                        <h2>Error loading tours</h2>
                        <p>Please refresh the page.</p>
                    </div>
                `;
                document.getElementById('tours-container').className = 'no-tours';
            });
        
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</body>
</html>
