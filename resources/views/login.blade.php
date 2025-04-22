<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Audit Mutu Internal</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-400 to-purple-500 relative">
  <!-- Background semi-transparent card -->
  <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('your-background-image.jpg'); z-index: 0;"></div>

  <!-- Login Card -->
  <div class="relative z-10 bg-white/90 rounded-lg border-2 border-purple-500 p-8 w-full max-w-md shadow-lg text-center">
    <!-- Logo -->
    <div class="flex justify-center mb-4">
      <img src="your-logo.png" alt="Logo" class="h-14">
    </div>
    
    <!-- Title -->
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Audit Mutu Internal</h2>

    <!-- Form -->
    <form class="mb-4">
      <div class="mb-4 text-left">
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your email" />
      </div>
      <div class="mb-6 text-left">
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your password" />
      </div>
      <button type="submit" class="w-full bg-blue-800 text-white py-2 rounded hover:bg-blue-900 transition">Masuk</button>
    </form>
    <p>Belum punya akun? <a href="register" style="color: blue">Daftar sekarang</a></p>
  </div>
</body>
</html>