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

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("ss", $username, $hash);
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

    function fetchAccount(string $username, string $password) {
        $conn = connectToDatabase();

        // Look up by username only; the hash is checked in PHP with password_verify().
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();
        if (!$row || !password_verify($password, $row['password'])) {
            return false;
        }

        unset($row['password']);
        return $row;
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