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

    public function filterBooks($brand, $model, $reg)
    {
        // Základní SQL dotaz
        $sql = "SELECT * FROM books WHERE 1=1";
        $params = [];

        // Přidání podmínek pro filtraci podle parametrů
        if (!empty($brand)) {
            $sql .= " AND brand LIKE :brand";
            $params[':brand'] = '%' . $brand . '%';
        }

        if (!empty($model)) {
            $sql .= " AND model LIKE :model";
            $params[':model'] = '%' . $model . '%';
        }

        if (!empty($reg)) {
            $sql .= " AND reg LIKE :reg";
            $params[':reg'] = '%' . $reg . '%';
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

    public function deleteCar($id)
    {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getCar($id)
    {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateCar($id, $brand, $model, $reg, $km, $year)
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
    public function addBook($brand, $model, $reg, $km, $year)
    {
        $sql = "INSERT INTO cars (brand, model, reg, km, year) VALUES (:brand, :model, :reg, :km, :year)";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
        $stmt->bindParam(':model', $model, PDO::PARAM_STR);
        $stmt->bindParam(':reg', $reg, PDO::PARAM_STR);
        $stmt->bindParam(':km', $km, PDO::PARAM_INT);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
