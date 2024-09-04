<?php

class Books
{
    private $dbConn;

    // konstruktor, vytvoří spojení s Db
    public function __construct($dbConn)
    {
        $this->dbConn = $dbConn;
    }

    // getter pole všech aut
    public function getBooks()
    {
        $stmt = $this->dbConn->prepare("SELECT * FROM books");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filterBooks($isbn, $name, $surename, $title)
    {
        // Základní SQL dotaz
        $sql = "SELECT * FROM books WHERE 1=1";
        $params = [];

        // Přidání podmínek pro filtraci podle parametrů
        if (!empty($isbn)) {
            $sql .= " AND isbn LIKE :isbn";
            $params[':isbn'] = '%' . $isbn . '%';
        }

        if (!empty($name)) {
            $sql .= " AND name LIKE :name";
            $params[':name'] = '%' . $name . '%';
        }

        if (!empty($surename)) {
            $sql .= " AND surename LIKE :surename";
            $params[':surename'] = '%' . $surename . '%';
        }

        if (!empty($title)) {
            $sql .= " AND title LIKE :title";
            $params[':title'] = '%' . $title . '%';
        }

        // Příprava SQL dotazu
        $stmt = $this->dbConn->prepare($sql);

        // Bindování parametrů (pouze pokud byly parametry přidány)
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value, PDO::PARAM_STR);
        }

        // Vykonání SQL dotazu
        $stmt->execute();

        // Návrat výsledků jako pole asociativních polí
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteBook($id)
    {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getBook($id)
    {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateBook($id, $brand, $model, $reg, $km, $year)
    {
        $sql = "UPDATE books SET brand = :brand, model = :model, reg = :reg, km = :km, year = :year WHERE id = :id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
        $stmt->bindParam(':model', $model, PDO::PARAM_STR);
        $stmt->bindParam(':reg', $reg, PDO::PARAM_STR);
        $stmt->bindParam(':km', $km, PDO::PARAM_INT);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Metoda pro přidání nového auta
    public function addBook($isbn, $name, $surename, $title, $description)
    {
        $sql = "INSERT INTO books (isbn, name, surename, title, description) VALUES (:isbn, :name, :surename, :title, :description)";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':isbn', $isbn, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':surename', $surename, PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
