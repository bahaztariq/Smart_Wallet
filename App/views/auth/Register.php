<?php
session_start();
require __DIR__ . '/../../../vendor/autoload.php';

use App\Core\CSRF;
use App\Repositories\UserRepository;
use App\Services\UserService;

$message = "";
$messageType = "";

if (isset($_SESSION['user_id'])) {
    header("Location: /dashboard");
    exit;
}

if (isset($_POST['submit'])) {
    $fullname = $_POST['Fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userRepository = new UserRepository();
    $userService = new UserService($userRepository);

    $result = $userService->register($fullname, $username, $email, $password);

    if ($result) {
        $message = "Registration successful! Redirecting...";
        $messageType = "success";

        $user = $userRepository->findByEmail($email);
        if ($user) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['user_name'] = $user->getName();
        }
    } else {
        $message = "Registration failed. Email or Username might already exist.";
        $messageType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartWallet - Sign Up</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@flaticon/flaticon-uicons@3.3.1/css/all/all.min.css">
    <link rel="icon" href="imgs/icon.png">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom radio button styling */
        .role-radio:checked+div {
            border-color: #059669;
            /* emerald-600 */
            background-color: #ecfdf5;
            /* emerald-50 */
            color: #059669;
        }

        .role-radio:checked+div i {
            color: #059669;
        }
    </style>
</head>

<body class="bg-gray-50 h-screen overflow-hidden">
    <div class="flex h-full w-full">
        <!-- Left Side - Form -->
        <div class="w-full lg:w-1/2 h-full flex flex-col p-8  lg:p-6 lg:pb-0  overflow-y-auto">
            <div class="mb-4">
                <a href="index.php" class="inline-flex items-center gap-2 text-gray-500 hover:text-emerald-600 transition-colors">
                    <i class="fi fi-rr-arrow-small-left text-xl pt-1"></i>
                    <span class="font-medium">Back to Home</span>
                </a>
            </div>

            <div class=" flex flex-col justify-center max-w-lg mx-auto w-full">
                <div class="mb-4">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Create SmartWallet Account</h1>
                    <p class="text-gray-500">Join SmartWallet today and take control of your financial future.</p>
                </div>

                <?php if (!empty($message)): ?>
                    <script>
                        Toastify({
                            text: "<?php echo htmlspecialchars($message); ?>",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                            style: {
                                background: "<?php echo $messageType === 'success' ? '#22c55e' : '#ff2335ff'; ?>",
                            },
                            callback: function() {
                                <?php if ($messageType === 'success'): ?>
                                    window.location.href = "/dashboard";
                                <?php endif; ?>
                            }
                        }).showToast();

                        // Fallback redirect for success if Toast callback fails or user block scripts (rare)
                        <?php if ($messageType === 'success'): ?>
                            setTimeout(() => {
                                window.location.href = "/dashboard";
                            }, 2000);
                        <?php endif; ?>
                    </script>
                <?php endif; ?>

                <form action="/register" method="POST" class="space-y-2">
                    <?php echo CSRF::field(); ?>


                    <!-- Names -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label for="Fullname" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fi fi-rr-user"></i>
                                </div>
                                <input type="text" name="Fullname" id="Fullname" placeholder="John Doe" required
                                    class="pl-10 w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fi fi-rr-at"></i>
                                </div>
                                <input type="text" name="username" id="username" placeholder="johndoe123" required
                                    class="pl-10 w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fi fi-rr-envelope"></i>
                            </div>
                            <input type="email" name="email" id="email" placeholder="john@example.com" required
                                class="pl-10 w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="space-y-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fi fi-rr-lock"></i>
                            </div>
                            <input type="password" name="password" id="password" placeholder="Min. 8 characters" required
                                class="pl-10 w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit" name="submit" class="mt-2 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 duration-200">
                        Create Account
                    </button>

                    <p class="text-center text-gray-600 mt-2">
                        Already have an account?
                        <a href="/login" class="text-emerald-600 font-semibold hover:text-emerald-700 hover:underline">Sign in</a>
                    </p>
                </form>
            </div>

            <div class="mt-2 text-center text-xs text-gray-400">
                &copy; <?php echo date('Y'); ?> SmartWallet. All rights reserved.
            </div>
        </div>

        <!-- Right Side - Image -->
        <div class="hidden lg:block w-1/2 h-full relative">
            <div class="absolute inset-0 bg-black/10 z-10"></div>
            <img src="/images/smartwallet_bg.png" alt="SmartWallet Finance" class="w-full h-full object-cover">
            <div class="absolute bottom-10 left-10 z-20 text-white max-w-lg">
                <h2 class="text-4xl font-bold mb-4 drop-shadow-md">Smart Insights, Better Decisions.</h2>
                <p class="text-lg drop-shadow-md text-gray-100">Track your tailored financial analytics and achieve your savings goals effortlessly with SmartWallet.</p>
            </div>
        </div>
    </div>
</body>

</html>