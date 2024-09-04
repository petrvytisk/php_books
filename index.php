<?php
require_once('Books.php');
include('DbConnect.php');

$conn = new DbConnect();
$dbConnection = $conn->connect();
$instanceBooks = new Books($dbConnection);
$books = $instanceBooks->getBooks();

if (isset($_GET['isbn']) || isset($_GET['name']) || isset($_GET['surename']) || isset($_GET['title'])) {
    $selIsbn = $_GET['isbn'];
    $selName = $_GET['name'];
    $selSurename = $_GET['surename'];
    $selTitle = $_GET['title'];
    $selBooks = $instanceBooks->filterBooks($selIsbn, $selName, $selSurename, $selTitle);
} else {
    $selBooks = $books;
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
            <a class="navbar-brand" href="listBooks.php">Knihy</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Vyhledávání knih</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listBooks.php">Seznam knih</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add.php">Vkládání knih</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2 class="h2">Vyhledávání knih</h2>
        <form action="index.php" method="get">
            <input class="form-control my-2" name="isbn" type="text" placeholder="Zadejte ISBN" />
            <input class="form-control my-2" name="name" type="text" placeholder="Zadejte jméno" />
            <input class="form-control my-2" name="surename" type="text" placeholder="Zadejte příjmení" />
            <input class="form-control my-2" name="title" type="text" placeholder="Zadejte název knihy" />
            <input class="btn btn-primary my-2" type="submit" placeholder="Odešli" />
        </form>
        <?php
        if (sizeof($selBooks) > 0) {

        ?>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>ISBN</th>
                    <th>Jméno</th>
                    <th>Příjmení</th>
                    <th>Název knihy</th>
                    <th>Popis</th>
                </tr>
                <?php foreach ($selBooks as $book): ?>
                    <tr>
                        <td><?php echo $book['id']; ?></td>
                        <td><?php echo $book['isbn']; ?></td>
                        <td><?php echo $book['name']; ?></td>
                        <td><?php echo $book['surename']; ?></td>
                        <td><?php echo $book['title']; ?></td>
                        <td><?php echo $book['description']; ?></td>
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