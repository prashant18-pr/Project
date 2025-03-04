<?php
// login.php

// Database connection parameters
$host = 'localhost'; // Change to your database host
$db = 'hackers_haven'; // Fixed the syntax error
$user = 'root'; // Change to your database user
$pass = ''; // Change to your database password

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Basic validation
    if (empty($email) || empty($password)) {
        $message = 'Please fill in all fields!';
    } else {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verify password (assuming you have hashed passwords in the database)
            if (password_verify($password, $user['password'])) {
                $message = 'Login successful!';
            } else {
                $message = 'Invalid password';
            }
        } else {
            $message = 'User not found';
        }

        // Close statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hacker's Haven - Your Ultimate Cybersecurity Bookstore</title>
    
    <!-- Import Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: "#1a1a1a", /* Dark background color */
              secondary: "#2563eb", /* Blue accent color */
            },
            borderRadius: {
              none: "0px",
              sm: "4px",
              DEFAULT: "8px",
              md: "12px",
              lg: "16px",
              xl: "20px",
              "2xl": "24px",
              "3xl": "32px",
              full: "9999px",
              button: "8px", /* Custom button border radius */
            },
          },
        },
      };
    </script>
    
    <!-- Google Fonts Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    
    <!-- Import Pacifico Font -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet" />
    
    <!-- Import Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    
    <style>
      /* Ensures icon font loads correctly */
      :where([class^="ri-"])::before { content: "\f3c2"; }
      
      /* Hover effect for book cards */
      .book-card:hover { transform: translateY(-4px); }
      
      /* Background styling for newsletter section */
      .newsletter-bg {
          background: linear-gradient(45deg, rgba(26,26,26,0.9), rgba(37,99,235,0.9));
      }

      /* Login Form Styles */
      body {
          background: linear-gradient(120deg, #6a11cb, #2575fc);
          height: 100vh;
          display: flex;
          justify-content: center;
          align-items: center;
      }
      .card {
          opacity: 0;
          transform: translateY(-20px);
          animation: fadeIn 1s ease-in-out forwards;
          background: rgba(255, 255, 255, 0.2);
          backdrop-filter: blur(10px);
          border-radius: 15px;
          padding: 20px;
          color: white;
      }
      @keyframes fadeIn {
          from {
              opacity: 0;
              transform: translateY(-20px);
          }
          to {
              opacity: 1;
              transform: translateY(0);
          }
      }
      .btn {
          transition: transform 0.2s;
      }
      .btn:hover {
          transform: scale(1.05);
      }
      input {
          background: rgba(255, 255, 255, 0.3);
          border: none;
          color: white;
      }
      input::placeholder {
          color: rgba(255, 255, 255, 0.7);
      }
      .btn-primary {
          background: #ff4b2b;
          border: none;
      }
      .btn-primary:hover {
          background: #ff416c;
      }
    </style>
</head>
<body class="bg-white min-h-screen">
    <!-- Header Section -->
    <header class="fixed top-0 w-full bg-gradient-to-r from-purple-600 via-blue-500 to-green-500 shadow-lg z-50 transition duration-500">
        <div class="max-w-7xl mx-auto px-4">
          <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
              <a href="#" class="text-3xl font-['Pacifico'] text-white drop-shadow-lg animate-pulse">Hacker's Haven</a>
            </div>
            <!-- Navigation Menu -->
            <nav class="hidden md:flex space-x-8 text-lg">
              <a href="index.html" class="text-white hover:text-yellow-300 transition duration-300 transform hover:scale-110">Home</a>
              <a href="#" class="text-white hover:text-yellow-300 transition duration-300 transform hover:scale-110">Books</a>
              <a href="contact.php" class="text-white hover:text-yellow-300 transition duration-300 transform hover:scale-110">Contact</a>
              <a href="about.html" class="text-white hover:text-yellow-300 transition duration-300 transform hover:scale-110">About</a>
            </nav>
            <!-- Search and Cart Section -->
            <div class="flex items-center space-x-6">
              <!-- Search Bar -->
              <div class="relative group">
                <input type="text" placeholder="Search books..." class="w-64 pl-10 pr-4 py-2 rounded-button border border-gray-200 focus:outline-none focus:border-yellow-300 transition duration-300">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 flex items-center justify-center">
                  <i class="ri-search-line text-gray-400 group-hover:text-yellow-300 transition duration-300"></i>
                </div>
              </div>
              <!-- Dropdown with Login & Register -->
              <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-r from-pink-500 to-red-500 text-white shadow-lg hover:scale-110 transition duration-300 ease-in-out">
                  <i class="ri-user-line text-xl"></i>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95 translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave="opacity-0 scale-95 translate-y-2" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl overflow-hidden">
                  <a href="login.php" class="block px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 transition duration-300">Login</a>
                  <a href="sign up.php" class="block px-4 py-2 text-white bg-green-500 hover:bg-green-600 transition duration-300">Register</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>
       <!-- Alpine.js -->
       <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

       

      <!-- Login Section -->
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
          <script src="https://cdn.tailwindcss.com"></script>
          <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
          <style>
            /* Hover effect for navigation links */
            .nav-link {
              position: relative;
            }
            .nav-link::after {
              content: "";
              position: absolute;
              width: 100%;
              height: 3px;
              background: linear-gradient(90deg, #ff7eb3, #ff758c);
              bottom: -5px;
              left: 0;
              transform: scaleX(0);
              transition: transform 0.3s ease-in-out;
            }
            .nav-link:hover::after {
              transform: scaleX(1);
            }
            /* Animated login form */
            .card {
              padding: 2rem;
              background: linear-gradient(135deg, #6a11cb, #2575fc);
              color: white;
              border-radius: 15px;
              box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
              transform: scale(0.95);
              transition: transform 0.3s ease-in-out;
            }
            .card:hover {
              transform: scale(1);
            }
            .form-control {
              transition: all 0.3s;
            }
            .form-control:focus {
              box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
            }
            .btn-primary {
              background: linear-gradient(90deg, #ff758c, #ff7eb3);
              border: none;
              transition: all 0.3s;
            }
            .btn-primary:hover {
              transform: scale(1.05);
              box-shadow: 0 5px 15px rgba(255, 117, 140, 0.5);
            }
          </style>
        </head>
        <body class="bg-gray-100 min-h-screen flex items-center justify-center">
          <div class="container mt-20">
            <div class="row justify-content-center">
              <div class="col-md-4">
                <div class="card text-center">
                  <h2 class="mb-4">Login</h2>
                  <form id="loginForm">
                    <div class="mb-3">
                      <input type="email" class="form-control" id="email" placeholder="Email address" required>
                    </div>
                    <div class="mb-3">
                      <input type="password" class="form-control" id="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                  </form>
                  <p class="mt-3">Don't have an account? <a href="sign up.php" class="text-white">Sign Up</a></p>
                </div>
              </div>
            </div>
          </div>
          <script>
            document.getElementById('loginForm').addEventListener('submit', function(event) {
              event.preventDefault();
              let email = document.getElementById('email').value;
              let password = document.getElementById('password').value;
              if (email === "" || password === "") {
                alert('Please fill in all fields!');
                return;
              }
              alert('Login successful!');
            });
          </script>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
      </html>
      
    
      <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            let errorMsg = document.getElementById('error-msg');
    
            // Regular expression for basic email validation
            let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            
            if (!emailPattern.test(email)) {
                errorMsg.innerText = "Invalid email";
                errorMsg.style.display = "block";
                return;
            }
            
            // Dummy password validation (Replace with backend authentication)
            if (password !== "password123") {
                errorMsg.innerText = "Invalid password";
                errorMsg.style.display = "block";
                return;
            }
    
            alert('Login successful!');
            errorMsg.style.display = "none"; // Hide error if login is successful
        });
    </script>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


