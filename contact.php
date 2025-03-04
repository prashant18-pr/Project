<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email and message from the POST request
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $message = trim($_POST['message']);
    
    // Prepare response array
    $response = [];

    // Validate email
    if ($email === false) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid email!';
    } elseif (empty($message)) {
        $response['status'] = 'error';
        $response['message'] = 'Message cannot be empty!';
    } else {
        // Here, you can add code to process the valid email and message (e.g., save to database or send an email)

        // For demonstration purposes, we'll just return a success message
        $response['status'] = 'success';
        $response['message'] = 'Thank you for your message!';
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
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
              <a href="contact.html" class="text-white hover:text-yellow-300 transition duration-300 transform hover:scale-110">Contact</a>
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


    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ff9a9e, #fad0c4, #fbc2eb, #a6c1ee);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 600px;
            padding: 20px;
            background: linear-gradient(135deg, #ffecd2, #fcb69f);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-in;
            text-align: center;
        }

        h1 {
            color: #ff6f61;
            margin-bottom: 20px;
            font-size: 28px;
            background: linear-gradient(45deg, #ff758c, #ff7eb3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #444;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            background: linear-gradient(135deg, #a1c4fd, #c2e9fb);
            font-size: 16px;
            transition: 0.3s;
            outline: none;
        }

        input:focus, textarea:focus {
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            box-shadow: 0 0 8px rgba(33, 150, 243, 0.5);
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(45deg, #ff6b6b, #ff8e53, #ffcd73);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: linear-gradient(45deg, #ff4757, #ff6b6b, #ffb199);
        }

        .response-message {
            margin-top: 20px;
            text-align: center;
            color: #28a745;
            font-size: 16px;
            display: none;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Contact Us</h1>
        <form id="contact-form">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit">Send Message</button>
        </form>
        <div id="response-message" class="response-message"></div>
    </div>
    <script>
      document.getElementById('contact-form').addEventListener('submit', function(event) {
          event.preventDefault(); // Prevent default form submission
          
          let email = document.getElementById('email').value;
          let message = document.getElementById('message').value;
          let responseMessage = document.getElementById('response-message');
  
          // Regular expression for basic email validation
          let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  
          if (!emailPattern.test(email)) {
              responseMessage.textContent = 'Invalid email!';
              responseMessage.style.color = 'red';
              responseMessage.style.display = 'block';
              return; // Stop form submission if email is invalid
          }
  
          if (message.trim() === "") {
              responseMessage.textContent = 'Message cannot be empty!';
              responseMessage.style.color = 'red';
              responseMessage.style.display = 'block';
              return;
          }
  
          // Simulate a successful form submission
          responseMessage.textContent = 'Thank you for your message!';
          responseMessage.style.color = 'green';
          responseMessage.style.display = 'block';
  
          // Clear form fields
          this.reset();
  
          // Hide response message after 3 seconds
          setTimeout(() => {
              responseMessage.style.display = 'none';
          }, 3000);
      });
  </script>
  
</body>
</html>

