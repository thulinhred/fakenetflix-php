<?php
    class Account {
        private $conn;
        private $errArr = array();

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function register($fn, $ln, $un, $em, $em2, $pw, $pw2) {
            $this->validateFirstName($fn);
            $this->validateLastName($ln);
            $this->validateUsername($un);
            $this->validateEmail($em, $em2);
            $this->validatePassword($pw, $pw2);

            if(empty($this->errArr)) {
                return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
            }
            return false;
        }

        public function login($un, $pw) {
            $pw = hash("sha512", $pw);

            $query = $this->conn->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");

            $query->bindValue(":un", $un);
            $query->bindValue(":pw", $pw);

            $query->execute();

            if($query->rowCount() == 1) {
                return true;
            }

            array_push($this->errArr, Constants::$loginFailed);
            return false;
        }

        private function insertUserDetails($fn, $ln, $un, $em, $pw) {
            $pw = hash("sha512", $pw);

            $query = $this->conn->prepare("INSERT INTO users (firstName, lastName, username, email, password) VALUES (:fn, :ln, :un, :em, :pw) ");

            $query->bindValue(":fn", $fn);
            $query->bindValue(":ln", $ln);
            $query->bindValue(":un", $un);
            $query->bindValue(":em", $em);
            $query->bindValue(":pw", $pw);

            return $query->execute();
        }

        private function validateFirstName($fn) {
            if(strlen($fn) < 2 || strlen($fn) > 25 ) {
                array_push($this->errArr, Constants::$firstNameCharacters);
            }
        }

        private function validateLastName($ln) {
            if(strlen($ln) < 2 || strlen($ln) > 25 ) {
                array_push($this->errArr, Constants::$lastNameCharacters);
            }
        }

        private function validateUsername($un) {
            if(strlen($un) < 2 || strlen($un) > 25 ) {
                array_push($this->errArr, Constants::$usernameCharacters);
                return;
            }

            //check username in database or not *MAGIC 1*
            $query = $this->conn->prepare("SELECT * FROM users WHERE username=:un");
            $query->bindValue(":un", $un);
            $query->execute();

            if($query->rowCount() != 0) {
                array_push($this->errArr, Constants::$usernameTaken);
            }
        }

        private function validateEmail($em, $em2) {
            if($em != $em2 ) {
                array_push($this->errArr, Constants::$emailDontMatch);
                return;
            }

            if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
                array_push($this->errArr, Constants::$emailInvalid);
                return;
            }

            //check email already in database or not
            $query = $this->conn->prepare("SELECT * FROM users WHERE email=:em");
            $query->bindValue(":em", $em);
            $query->execute();

            if($query->rowCount() != 0) {
                array_push($this->errArr, Constants::$emailTaken);
            }
        }

        //begin validate password

        private function validatePassword($pw, $pw2) {
            if($pw != $pw2 ) {
                array_push($this->errArr, Constants::$passwordDontMatch);
                return;
            }

            if(strlen($pw) < 4 || strlen($pw) > 20) {
                array_push($this->errArr, Constants::$passwordLength);
                return;
            }
        }

        public function getError($err) {
            if(in_array($err, $this->errArr)) {
                return "<span class='errMessage'>$err</span>";
            }
        }
    }
?>