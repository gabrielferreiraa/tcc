<?php

namespace App\Auth;

use Cake\Auth\AbstractPasswordHasher;

class Sha512PasswordHasher extends AbstractPasswordHasher {

    public function hash($password) {
        return hash('sha512', $password);
    }

    public function check($password, $hashedPassword) {
        return hash('sha512', $password) === $hashedPassword;
    }

}
