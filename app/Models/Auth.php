<?php

class Auth {
    private $db;

    public function __construct(PDO $db) {
        session_start();
        $this->db = $db;
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] === 'Inactive') {
                return ['error' => "Your account status is inactive. Contact Admin to reactivate your account."];
            }

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role_id'] = $user['role_id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['contact_number'] = $user['contact_number'];
            $_SESSION['gender'] = $user['gender'];
            $_SESSION['age'] = $user['age'];


            return ['success' => true];
        }

        return ['error' => "Email or password does not match."];
    }
}