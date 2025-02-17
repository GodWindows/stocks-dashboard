<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Page de connexion</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    .bg-green-dark {
      background-color: #064e3b;
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

  <main class="container mx-auto px-4 py-6 flex-grow">
    <div class="bg-white shadow-md rounded-lg p-6 max-w-sm mx-auto">
      <h1 class="text-3xl font-bold mb-6 text-center" style="color: #064e3b;">Connexion</h1>   <!-- Connection in french -->
      <form action="dashboard-stocks.php" method="POST">
      <input name="submitted" value="submitted" class="w-full p-2 border rounded-lg" hidden required>
        <?php
        if (isset($_SESSION['error']) && $_SESSION['error']!="") {
            echo "<script> toastr.error('{$_SESSION['error']}') </script>" ;
            $_SESSION['error']=="";
        }
        ?>
        <div class="mb-4">
          <label for="email" class="block font-semibold">Nom</label>    <!-- Name in french -->
          <input type="text" id="email" name="name" class="w-full p-2 border rounded-lg" required>
        </div>
        <div class="mb-6">
          <label for="password" class="block font-semibold">Mot de Passe</label>   <!-- Password in french -->
          <input type="password" id="password" name="password" class="w-full p-2 border rounded-lg" required>
        </div>
        <div class="flex justify-end">
          <button type="submit" class="bg-green-dark text-white px-6 py-3 rounded-lg focus:outline-none shadow-md hover:bg-blue-600">Se connecter</button>  <!-- Login in french -->
        </div>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-green-dark text-white py-4 mt-auto">
    <div class="container mx-auto text-center">
      <p>&copy; Tous droits réservés.</p>   <!-- All rights reserved in french -->
    </div>
  </footer>

</body>
</html>