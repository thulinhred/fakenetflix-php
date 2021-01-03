<?php
    class FormSanitizer {
        public static function sanitizerFormString($inputText) {
            $inputText = strip_tags($inputText);
            $inputText = str_replace(" ", "", $inputText);
            //$inputText = trim($inputText);
            $inputText = strtolower($inputText);
            $inputText = ucfirst($inputText);
            return $inputText;
        }

        public static function sanitizerFormUsername($inputText) {
            $inputText = strip_tags($inputText);
            $inputText = str_replace(" ", "", $inputText);
            return $inputText;
        }

        public static function sanitizerFormPassword($inputText) {
            $inputText = strip_tags($inputText);
            return $inputText;
        }

        public static function sanitizerFormEmail($inputText) {
            $inputText = strip_tags($inputText);
            $inputText = str_replace(" ", "", $inputText);
            return $inputText;
        }

    }
?>