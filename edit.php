<?php
require_once('Cars.php');
include('DbConnect.php');

$conn = new DbConnect();
$dbConnection = $conn->connect();
$instanceCars = new Cars($dbConnection);
$carToEdit = [];

if (isset($_GET['id'])) {
    $carId = $_GET['id'];
    $carToEdit = $instanceCars->getCar($carId); // Načtení dat auta k editaci
}

// Zpracování aktualizace auta po odeslání formuláře
if (isset($_POST['update'])) {
    $carId = $_POST['id'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $reg = $_POST['reg'];
    $km = $_POST['km'];
    $year = $_POST['year'];
    $instanceCars->updateCar($carId, $brand, $model, $reg, $km, $year);
    header("Location: index.php"); // Po úspěšné aktualizaci přesměrování zpět na seznam aut
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Editace Auta</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Auta</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Seznam aut</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="edit.php">Uprav auto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add.php">Přidej auto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2 class="h2">Editace auta</h2>
        <?php if ($carToEdit): ?>
            <form action="edit.php" method="post">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($carToEdit['id']); ?>">
                <input class="form-control my-2" name="brand" type="text" value="<?php echo htmlspecialchars($carToEdit['brand']); ?>" placeholder="Zadejte značku" />
                <input class="form-control my-2" name="model" type="text" value="<?php echo htmlspecialchars($carToEdit['model']); ?>" placeholder="Zadejte model" />
                <input class="form-control my-2" name="reg" type="text" value="<?php echo htmlspecialchars($carToEdit['reg']); ?>" placeholder="Zadejte registraci" />
                <input class="form-control my-2" name="km" type="number" value="<?php echo htmlspecialchars($carToEdit['km']); ?>" placeholder="Zadejte kilometry" />
                <input class="form-control my-2" name="year" type="number" value="<?php echo htmlspecialchars($carToEdit['year']); ?>" placeholder="Zadejte rok" />
                <input class="btn btn-primary my-2" type="submit" name="update" value="Aktualizovat" />
            </form>
        <?php else: ?>
            <p>Žádné nebo neexistující auto k editaci.</p>
        <?php endif; ?>

