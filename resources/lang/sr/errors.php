<?php

return [
    'general' => [
        'unexpected_error' => 'Došlo je do neočekivane greške.',
    ],
    'register' => [
        'passwords_dont_match' => 'Lozinke se ne poklapaju.',
        'username_taken' => 'Korisničko ime je zauzeto.',
        'email_already_in_use' => 'Nalog sa ovom email adresom već postoji.',
        'username_min' => 'Korisničko ime mora da bude duže od 2 karaktera.',
        'username_max' => 'Korisničko ime ne sme da bude duže od 20 karaktera.',
        'email_max' => 'Email adresa ne sme da bude duže od 80 karaktera.',
        'password_min' => 'Lozinka mora da bude duža od 4 karaktera.',
        'password_max' => 'Lozinka ne sme da bude duža od 80 karaktera.',
        'email_email' => 'Email adresa nije u tačnom formatu.',
        'username_required' => 'Korisničko ime je obavezno.',
        'email_required' => 'Email adresa je obavezna.',
        'password_required' => 'Lozinka je obavezna.',
        'password_regex' => 'Lozinka mora da sadrži minimum 1 broj i 1 slovo.',
    ],
    'login' => [
        'email_isnt_in_use' => 'Ne postoji nalog sa unetom Email adresom.',
        'incorrect_password' => 'Netačna lozinka.',
        'email_required' => 'Email adresa je obavezna.',
        'password_required' => 'Lozinka je obavezna.',
    ],
    'create_new_build' => [
        'build_name_max' => 'Naziv konfiguracije ne sme da bude duži od 30 karaktera.',
        'build_visibility_reqired' => 'Preglednost je obavezna.',
        'build_visibility_boolean' => 'Preglednost mora biti tipa boolean.',
    ],
    'get_build_delivery_groups' => [
        'build_id_required' => 'Greška prilikom obrade grupa za dostavu linkova kupovine.',
        'build_id_int' => 'Greška prilikom obrade grupa za dostavu linkova kupovine.',
    ],
    'add_build_component' => [
        'name_required' => 'Naziv komponente je obavezan.',
        'name_max' => 'Naziv komponente ne sme da bude duži od 30 karaktera.',
        'type_id_required' => 'Greška prilikom obrade tipa komponente.',
        'type_id_int' => 'Greška prilikom obrade tipa komponente.',
        'type_id_min' => 'Greška prilikom obrade tipa komponente.',
        'type_id_max' => 'Greška prilikom obrade tipa komponente.',
        'build_id_required' => 'Greška prilikom obrade konfiguracije komponente.',
        'build_id_int' => 'Greška prilikom obrade konfiguracije komponente.',
    ],
];