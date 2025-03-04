
<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hackers_haven";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate fields
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo json_encode(["status" => "error", "message" => "Please fill in all fields!"]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Invalid email format!"]);
        exit;
    }

    if ($password !== $confirmPassword) {
        echo json_encode(["status" => "error", "message" => "Passwords do not match!"]);
        exit;
    }

    if (strlen($password) < 8) {
        echo json_encode(["status" => "error", "message" => "Password must be at least 8 characters!"]);
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email already registered!"]);
        exit;
    }
    $stmt->close();

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Registration successful!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error registering user!"]);
    }

    $stmt->close();
    $conn->close();
}
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
      
                <div x-show="open" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95 translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-2" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl overflow-hidden">
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    
    <style>
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
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card text-center">
                    <h2 class="mb-4">Sign Up</h2>
                    <form id="signupForm">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="username" placeholder="Username" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="email" placeholder="Email address" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="password" placeholder="Password" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                    </form>
                    <p class="mt-3">Already have an account? <a href="login.php" class="text-white">Login</a></p>
                </div>
            </div>
        </div>
    </div>
    <script>
      document.getElementById('signupForm').addEventListener('submit', function(event) {
          event.preventDefault();
          
          let username = document.getElementById('username').value;
          let email = document.getElementById('email').value;
          let password = document.getElementById('password').value;
          let confirmPassword = document.getElementById('confirmPassword').value;
          let errorMsg = document.getElementById('error-msg');
  
          // Regular expression for basic email validation
          let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
          
          if (username === "" || email === "" || password === "" || confirmPassword === "") {
              errorMsg.innerText = "Please fill in all fields!";
              errorMsg.style.display = "block";
              return;
          }
  
          if (!emailPattern.test(email)) {
              errorMsg.innerText = "Invalid email";
              errorMsg.style.display = "block";
              return;
          }
  
          if (password.length < 8) {
              errorMsg.innerText = "Weak password (must be at least 8 characters)";
              errorMsg.style.display = "block";
              return;
          }
  
          if (password !== confirmPassword) {
              errorMsg.innerText = "Passwords do not match!";
              errorMsg.style.display = "block";
              return;
          }
  
          alert('Signup successful!');
          errorMsg.style.display = "none"; // Hide error if signup is successful
      });
  </script>
  
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

