<?php
    // Start the session
    session_start();
    if (!isset($_COOKIE['user_found'])) {
        header('Location: login.php');
        exit();
    }

    $codeLabosArray = $_SESSION['codeLabosArray'];
    $files = $_SESSION['files'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Serveur de résultats | Syslab</title>
    <!-- Link to Font Awesome CSS (make sure you have an internet connection) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        background-color: #f8f9fa;
        color: #343a40;
    }

    header {
        background-color: #007bff;
        padding: 20px;
        text-align: center;
        color: white;
        position: relative;
    }

    header i {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 1.5em;
        color: white;
        cursor: pointer;
    }

    nav {
        background-color: #343a40;
        padding: 10px;
        text-align: center;
    }

    nav a {
        color: white;
        text-decoration: none;
        margin: 0 10px;
        font-size: 18px;
        transition: color 0.3s;
    }

    nav a:hover {
        color: #007bff;
    }

    .showcase {
        background-color: #ffffff;
        padding: 20px;
        text-align: center;
    }

    .filter-container {
        margin: 20px 0;
        text-align: center;
    }

    .category-filter {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        background-color: #f8f9fa;
        outline: none;
        transition: border-color 0.3s;
    }

    .pdf-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        justify-content: center;
    }

    .pdf-item {
        text-align: center;
        transition: transform 0.3s;
    }

    .pdf-item:hover {
        transform: scale(1.05);
    }

    .pdf-icon {
        font-size: 3em;
        color: #007bff;
    }
    </style>
</head>

<body>

    <header>
        <h1>PDF Ajout titre ici</h1>
        <i class="fas fa-sign-out-alt" onclick="logout()"></i>
    </header>

    <nav>
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
    </nav>

    <div class="showcase">
        <h2>Ajout titre ici</h2>
        <p>This is a placeholder text for the showcase section. Add your content here.</p>
    </div>

    <div class="filter-container">
        <label for="categoryFilter">Filtrer par laboratoire:</label>
        <select id="categoryFilter" class="category-filter" onchange="filterPDFs()">
            <option value="all">Tous les laboratoires</option>
            <?php
        $pdfFiles = $files;

        $categories = array_unique(array_column($pdfFiles, 1));
        foreach ($categories as $category) {
            echo '<option value="' . $category . '">' . ucfirst($category) . '</option>';
        }
        ?>
        </select>
    </div>

    <div class="pdf-list" id="pdfList">
        <?php
    usort($pdfFiles, function($a, $b) {
        return $a[1] <=> $b[1] ?: strcasecmp($a[0], $b[0]);
    });

    foreach ($pdfFiles as $pdfFile) {
        echo '<div class="pdf-item" data-category="' . $pdfFile[1] . '">';
        echo '<div class="pdf-icon"><a href="'.$pdfFile[0].'" target="_blank"><i class="fas fa-file-pdf"></i></a></div>';
        echo '<p>' . $pdfFile[0] . '</p>';
        echo '</div>';
    }
    ?>
    </div>

    <script>
    function filterPDFs() {
        var categoryFilter = document.getElementById('categoryFilter');
        var selectedCategory = categoryFilter.value;

        var pdfItems = document.getElementsByClassName('pdf-item');
        for (var i = 0; i < pdfItems.length; i++) {
            var pdfItem = pdfItems[i];
            var itemCategory = pdfItem.getAttribute('data-category');

            if (selectedCategory === 'all' || selectedCategory === itemCategory) {
                pdfItem.style.display = 'block';
            } else {
                pdfItem.style.display = 'none';
            }
        }
    }

    function logout() {
        // Add logout functionality here
        document.cookie = 'user_found=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        window.location.href = 'login.php?logout=true';
    }
    </script>

</body>

</html>