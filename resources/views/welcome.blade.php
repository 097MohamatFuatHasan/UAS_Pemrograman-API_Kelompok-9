<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Hotel Booking System</h1>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Login</h3>
                    </div>
                    <div class="card-body">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="loginEmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="loginPassword" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Register</h3>
                    </div>
                    <div class="card-body">
                        <form id="registerForm">
                            <div class="mb-3">
                                <label for="registerName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="registerName" required>
                            </div>
                            <div class="mb-3">
                                <label for="registerEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="registerEmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="registerPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="registerPassword" required>
                            </div>
                            <button type="submit" class="btn btn-success">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="hotelList" class="mt-4"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const apiBaseUrl = '/api';
        let authToken = localStorage.getItem('authToken');
        
        // Set Axios defaults
        if (authToken) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${authToken}`;
            loadHotels();
        }
        
        // Login
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            
            axios.post(`${apiBaseUrl}/login`, { email, password })
                .then(response => {
                    localStorage.setItem('authToken', response.data.access_token);
                    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.access_token}`;
                    alert('Login successful');
                    loadHotels();
                })
                .catch(error => {
                    console.error(error);
                    alert('Login failed');
                });
        });
        
        // Register
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('registerName').value;
            const email = document.getElementById('registerEmail').value;
            const password = document.getElementById('registerPassword').value;
            
            axios.post(`${apiBaseUrl}/register`, { name, email, password })
                .then(response => {
                    alert('Registration successful. Please login.');
                })
                .catch(error => {
                    console.error(error);
                    alert('Registration failed');
                });
        });
        
        // Load hotels
        function loadHotels() {
            axios.get(`${apiBaseUrl}/hotels`)
                .then(response => {
                    const hotelList = document.getElementById('hotelList');
                    hotelList.innerHTML = '<h2 class="my-3">Available Hotels</h2>';
                    
                    response.data.forEach(hotel => {
                        const hotelCard = document.createElement('div');
                        hotelCard.className = 'card mb-3';
                        hotelCard.innerHTML = `
                            <div class="card-body">
                                <h5 class="card-title">${hotel.name}</h5>
                                <p class="card-text">${hotel.address}</p>
                                <a href="/hotel/${hotel.id}" class="btn btn-primary">View Rooms</a>
                            </div>
                        `;
                        hotelList.appendChild(hotelCard);
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
</body>
</html>