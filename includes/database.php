<?php

    require_once(__DIR__ . '/config.php');

    function connectToDatabase() {
        $conn = new mysqli(HOST, USER, PASS, DB);
        if ($conn->connect_error) {
            echo "<p class='error'>Bad connection to database.</p>";
            exit;
        }
        return $conn;
    }

    function createAccount(string $username, string $password) {
        if (accountExists($username)) return false;

        $conn = connectToDatabase();
        
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");

        $password = hashPassword($username, $password);
        $stmt->bind_param("ss", $username, $password);
        return $stmt->execute();
    }

    function accountExists(string $username) {
        $conn = connectToDatabase();
        
        $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $res = $stmt->get_result();
        
        return $res->fetch_assoc() ? true : false;
    }

    function hashPassword(string $username, string $password): string {
        $salt1 = hash("sha512", $username);
        $salt2 = hash("sha512", $username.$username);

        return hash("sha512", $salt1.$password.$salt2);
    }

    function fetchAccount(string $username, string $password) {
        $conn = connectToDatabase();
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? and password = ?");

        $password  = hashPassword($username, $password);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            return $row;
        }

        return false;
    }

    function fetchProducts() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT * FROM products");
        $stmt->execute();

        return $stmt->get_result();
    }

    function fetchProduct(int $id) {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $res = $stmt->get_result();
        return $res->fetch_assoc() ?: false;
    }

?>