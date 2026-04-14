<!DOCTYPE html>
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
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        header {
            background-color: #333;
            color: white;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        
        h1 {
            font-size: 30px;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            display: none;
        }
        
        .alert.show {
            display: block;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .tours-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }
        
        .tour-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }
        
        .tour-card h2 {
            color: #333;
            margin-bottom: 10px;
            font-size: 22px;
        }
        
        .tour-card p {
            color: #666;
            margin-bottom: 15px;
            flex-grow: 1;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .tour-card .price {
            font-size: 24px;
            color: #27ae60;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .tour-card .slots-info {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        
        .slots-info .slots-available {
            color: #27ae60;
            font-weight: bold;
        }
        
        .slots-info.no-slots {
            background-color: #f8d7da;
        }
        
        .slots-info.no-slots .slots-available {
            color: #721c24;
        }
        
        .booking-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        label {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        input:focus {
            outline: none;
            border-color: #27ae60;
            box-shadow: 0 0 5px rgba(39, 174, 96, 0.3);
        }
        
        button {
            background-color: #27ae60;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #229954;
        }
        
        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        
        .no-tours {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>🌍 Tours Booking Platform</h1>
            <p>Discover and book amazing tours from around the world</p>
        </header>
        
        @if($message = session('success'))
        <div class="alert alert-success show">
            ✅ {{ $message }}
        </div>
        @endif
        
        @if($message = session('error'))
        <div class="alert alert-error show">
            ❌ {{ $message }}
        </div>
        @endif
        
        @if($tours->count() > 0)
        <div class="tours-grid">
            @foreach($tours as $tour)
            <div class="tour-card">
                <h2>{{ $tour->name }}</h2>
                <p>{{ $tour->description }}</p>
                <div class="price">${{ number_format($tour->price, 2) }} per person</div>
                
                <div class="slots-info {{ $tour->available_slots == 0 ? 'no-slots' : '' }}">
                    <strong>Available Slots:</strong> 
                    <span class="slots-available">{{ $tour->available_slots }} / {{ $tour->total_slots }}</span>
                </div>
                
                @if($tour->available_slots > 0)
                <form action="{{ route('bookings.store') }}" method="POST" class="booking-form">
                    @csrf
                    <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                    
                    <div class="form-group">
                        <label for="name_{{ $tour->id }}">Your Name</label>
                        <input type="text" id="name_{{ $tour->id }}" name="user_name" required 
                               placeholder="John Doe" value="{{ old('user_name') }}">
                        @error('user_name')<small style="color: red;">{{ $message }}</small>@enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email_{{ $tour->id }}">Email</label>
                        <input type="email" id="email_{{ $tour->id }}" name="user_email" required 
                               placeholder="john@example.com" value="{{ old('user_email') }}">
                        @error('user_email')<small style="color: red;">{{ $message }}</small>@enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="people_{{ $tour->id }}">Number of People</label>
                        <input type="number" id="people_{{ $tour->id }}" name="number_of_people" 
                               value="1" min="1" max="{{ $tour->available_slots }}" required>
                        @error('number_of_people')<small style="color: red;">{{ $message }}</small>@enderror
                    </div>
                    
                    <button type="submit">Book Now</button>
                </form>
                @else
                <button disabled style="background-color: #ccc; cursor: not-allowed;">
                    FULLY BOOKED
                </button>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="no-tours">
            <h2>No tours available at the moment</h2>
            <p>Check back later for new tours!</p>
        </div>
        @endif
    </div>
</body>
</html>
