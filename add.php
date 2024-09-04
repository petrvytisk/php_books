<?php
require_once('Books.php');
include('DbConnect.php');

$conn = new DbConnect();
$dbConnection = $conn->connect();
$instanceBooks = new Books($dbConnection);

if (isset($_POST['add'])) {
    $isbn = $_POST['isbn'];
    $name = $_POST['name'];
    $surename = $_POST['surename'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $instanceBooks->addBook($isbn, $name, $surename, $title, $description);
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Vložení knihy</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="listBooks.php">Knihy</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Vyhledávání knih</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listBooks.php">Seznam knih</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="add.php">Vkládání knih</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
    <h2 class="h2">Přidání nové knihy</h2>
    <form action="add.php" method="post">
                <input type="hidden" name="id" value="">
                <input class="form-control my-2" name="isbn" type="text" value="" placeholder="Zadejte ISBN" required/>
                <input class="form-control my-2" name="name" type="text" value="" placeholder="Zadejte jméno autora" required/>
                <input class="form-control my-2" name="surename" type="text" value="" placeholder="Zadejte příjmení autora" required/>
                <input class="form-control my-2" name="title" type="text" value="" placeholder="Zadejte název knihy" required/>
                <input class="form-control my-2" name="description" type="text" value="" placeholder="Zadejte popisek" required/>
                <input class="btn btn-primary my-2" type="submit" name="add" value="Vlož knihu" />
            </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>