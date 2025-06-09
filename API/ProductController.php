<?php



class ProductController {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getProducts() {
        $products = [];
        $sql = "SELECT * FROM home_page_products";
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            return $this->formatResponse(500, [
                "error" => "Internal Server Error",
                "message" => "There was an issue with the database query. Please try again later."
            ]);
        }

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $products[] = [
                    "id" => (int) $row["id"],
                    "image" => $row["image_url"],
                    "name" => $row["name"],
                    "description" => $row["description"],
                    "price" => (float) $row["price"]
                ];
            }
            return $this->formatResponse(200, $products);
        } else {
            return $this->formatResponse(404, [
                "error" => "Not Found",
                "message" => "No products found."
            ]);
        }
    }

    private function formatResponse($statusCode, $data) {
        return [
            'statusCode' => $statusCode,
            'data' => $data
        ];
    }
}
?>