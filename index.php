<?php
    // Start the session
    session_start();
    if (!isset($_COOKIE['user_found'])) {
        header('Location: login.php');
        exit();
    }

    $codeLabosArray = $_SESSION['codeLabosArray'];
    $files = $_SESSION['files'];

    $medical_disciplines = array(
        27 => "Biochimie",
        28 => "Bactériologie",
        29 => "Parasitologie",
        30 => "Hématologie",
        31 => "Immunologie",
        82 => "Virologie"
    );
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="title-text">Serveur de résultats | Syslab</title>
    <link rel="stylesheet" href="./all.min.css">
    <link rel="stylesheet" href="./bootstrap.min.css">
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
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .pdf-group {
            flex: 1 0 100%;
            margin-bottom: 20px;
            margin-left: 20px;
        }

        .pdf-group-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;,
        }

        .pdf-item {
            flex: 1 0 calc(25% - 20px); /* Four items per row */
            max-width: 300px;  /* Set the maximum width */
            width: 100%;  /* Ensure the width is 100% of the container */
            margin: 0 10px 20px 10px;  /* Adjust margin for spacing */
            transition: transform 0.3s;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
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
        <h2 id="header-text">Hôpital militaire principal d'instruction de Tunis</h2>
        <i class="fas fa-sign-out-alt" onclick="logout()"></i>
    </header>

   <nav style="display: flex; align-items: center; justify-content: center; background-color: #343a40; padding: 10px; text-align: center">
        <a href="#" onclick="changeLanguage('ar')">AR</a>
        <a href="#" onclick="changeLanguage('fr')">FR</a>
        <a href="#" onclick="changeLanguage('en')">EN</a>
    </nav>

    <div class="showcase">
        <p id="showcase-text">Services des laboratoires de biologies médicales - Serveur de résultats</p>
    </div>

    <div class="filter-container">
        <label for="categoryFilter"  id="filter-text"></label>
        <select id="categoryFilter" class="category-filter" onchange="filterPDFs()">
            <option value="all"  id="filter-all-text">Tous les laboratoires</option>
            <?php
                $pdfFiles = $files;
                $uniqueCombinations = array_unique(array_map(function($item) {
                    return $item[1] . '-' . $item[2];
                }, $pdfFiles));

                foreach ($uniqueCombinations as $combination) {
                    list($code, $category) = explode('-', $combination);
                    echo '<option value="' . $code . '">' . ucfirst($category) . '</option>';
                }
            ?>
        </select>
    </div>

    <?php
        $groupedPDFs = [];

        foreach ($pdfFiles as $pdfFile) {
            list($demande, $timestamp, $codeLabo, $userID, $password, $index) = explode('-', $pdfFile[0]);

            // Extract year, month, day, hour, and minute from the timestamp string
            $year = substr($timestamp, 0, 2);
            $month = substr($timestamp, 2, 2);
            $day = substr($timestamp, 4, 2);
            $hour = substr($timestamp, 6, 2);
            $minute = substr($timestamp, 8, 2);

            $dateString = sprintf('20%s-%s-%s %s:%s:00', $year, $month, $day, $hour, $minute);
            $dateTime = new DateTime($dateString);
            $formattedDate = $dateTime->format('d/m/Y');   
    
            $groupedPDFs[$formattedDate][] = [
                'filename' => $pdfFile[0],
                'demande' => $demande,
                'index' => str_replace(".pdf", "", $index),
                'formattedDate' => $formattedDate,
                'codeLabo' => $codeLabo,
            ];
        }
    ?>

    <?php foreach ($groupedPDFs as $date => $pdfGroup): ?>
        <?php if (!empty($pdfGroup)): ?>
            <div class="pdf-group">
                <div class="pdf-group-title"><?php  echo '<b class="pdf-group-text" style="font-weight: normal"> </b>'. $date .'<br>'; ?></div>
                <div class="pdf-list">
                    <?php foreach ($pdfGroup as $pdfItem): ?>
                        <div class="pdf-item" data-category="<?php echo $pdfItem['codeLabo']; ?>">
                            <div class="pdf-icon">
                               <form action="pdf_reader.php" method="post" target="_blank">
                                <input type="hidden" name="filename" value="<?php echo $pdfItem['filename']; ?>">
                                <button type="submit" style="border: none; background: none; cursor: pointer;color: #007bff">
                                    <i class="fas fa-file-pdf"></i>
                                </button>
                            </form>
                            </div>
                            <p><?php
                                $year = substr($pdfItem['demande'], 0, 2);
                                $month = substr($pdfItem['demande'], 2, 2);
                                $day = substr($pdfItem['demande'], 4, 2);

                                // Format the values into a date string
                                $dateString = sprintf('20%s-%s-%s', $year, $month, $day);

                                // Convert the date string to a DateTime object
                                $dateTime = new DateTime($dateString);

                                // Format the DateTime object as needed
                                $formattedDateDemande = $dateTime->format('d/m/Y');

                                echo  '<b class="demande-text">Demande du: </b>'. $formattedDateDemande .'<br>';
                                echo  '<b class="codelab-text"></b>'. $medical_disciplines[$pdfItem['codeLabo']] .'<br>';
                                echo  '<b class="doc-text"> Document du: </b>'. $pdfItem['index'] .'<br>';
                            ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <script src="./jquery-3.7.1.slim.min.js"></script>
    <script src="./bootstrap.min.js"></script>
    <script src="main.js"></script>
</body>

</html>