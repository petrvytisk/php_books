<?php
require_once('Books.php');
include('DbConnect.php');

$conn = new DbConnect();
$dbConnection = $conn->connect();
$instanceBooks = new Books($dbConnection);
$books = $instanceBooks->getBooks();
// $selCars = $cars;

if (isset($_GET['brand']) || isset($_GET['model']) || isset($_GET['reg'])) {
    $selBrand = $_GET['brand'];
    $selModel = $_GET['model'];
    $selReg = $_GET['reg'];
    $selBooks = $instanceBooks->filterBooks($selBrand, $selModel, $selReg);
} else {
    $selBooks = $books;
}

// Zpracování mazání auta
if (isset($_GET['delete'])) {
    $bookId = $_GET['delete'];
    $instanceBooks->deleteCar($bookId);
    header("Location: index.php");
    exit();
}

?>


<!-- HTML -->

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Knihy</title>
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
                        <a class="nav-link" href="edit.php">Uprav knihu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add.php">Přidej knihu</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2 class="h2">Vyhledávání</h2>
        <form action="index.php" method="get">
            <input class="form-control my-2" name="brand" type="text" placeholder="Zadejte značku" />
            <input class="form-control my-2" name="model" type="text" placeholder="Zadejte model" />
            <input class="form-control my-2" name="reg" type="text" placeholder="Zadejte registraci" />
            <input class="btn btn-primary my-2" type="submit" placeholder="Odešli" />
        </form>
        <?php
        if (sizeof($selBooks) > 0) {

        ?>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Značka</th>
                    <th>Model</th>
                    <th>Registrace</th>
                    <th>Kilometry</th>
                    <th>Rok</th>
                    <th>Akce</th>
                </tr>
                <?php foreach ($selBooks as $book): ?>
                    <tr>
                        <td><?php echo $book['id']; ?></td>
                        <td><?php echo $book['brand']; ?></td>
                        <td><?php echo $book['model']; ?></td>
                        <td><?php echo $book['reg']; ?></td>
                        <td><?php echo $book['km']; ?></td>
                        <td><?php echo $book['year']; ?></td>
                        <td>
                            <a class="btn btn-warning" href="edit.php?id=<?php echo $book['id']; ?>">Editovat</a>
                            <a class="btn btn-warning" href="index.php?delete=<?php echo $book['id']; ?>" onclick="return confirm('Opravdu chcete smazat toto auto?');">Smazat</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

        <?php
        } else { ?>
            <p>Žádné knihy k zobrazení</p>
        <?php
        }
        ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>