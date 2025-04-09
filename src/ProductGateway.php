<?php

class ProductGateway 
{
    private PDO $conn;
    public  function __construct(private Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public  function getAll(): array
    {
        $sql = "SELECT * FROM product";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public  function getProduct(string $id): array
    {
        $sql = "SELECT * FROM product WHERE id = :id";
        $stmt =  $this ->conn ->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product ?: [];
    }

    public  function Delete(string $id): int
    {
        $sql = "DELETE FROM product WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public  function update(string $id, array $data): array
    {
        $sql = "UPDATE product SET name = :name, price = :price WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':price', $data['price'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $this ->getProduct($id);

    }

    public  function create(array $data): string
    {
        $sql = "INSERT INTO product (name, price) VALUES (:name, :price)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':price', $data['price'], PDO::PARAM_STR);
        $stmt->execute();
        return $this->conn->lastInsertId();

    }

    public function partiallyUpdate(string $id, array $data): array
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, ['name', 'price'])) {
                http_response_code(400);
                echo json_encode(['message' => 'Invalid field']);
                return [];
            }
            $sql = "UPDATE product SET $key = :$key WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":$key", $value, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        return $this ->getProduct($id);

    }
}
?>