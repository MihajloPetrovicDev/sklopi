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
        'tos_privacy_policy_check_accepted' => 'Morate da prihvatite Uslove Korišćenja i Politiku Privatnosti.',
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
    'add_new_build_component' => [
        'build_component_name_required' => 'Naziv komponente je obavezan.',
        'build_component_name_max' => 'Naziv komponente ne sme da bude duži od 200 karaktera.',
        'build_component_type_id_required' => 'Greška prilikom obrade tipa komponente.',
        'build_component_type_id_int' => 'Greška prilikom obrade tipa komponente.',
        'build_component_type_id_min' => 'Greška prilikom obrade tipa komponente.',
        'build_component_type_id_max' => 'Greška prilikom obrade tipa komponente.',
        'build_component_build_id_required' => 'Greška prilikom obrade konfiguracije komponente.',
        'build_component_build_id_int' => 'Greška prilikom obrade konfiguracije komponente.',
        'build_component_add_buy_links_array' => 'Greška prilikom obrade novih linkova za kupovinu komponente.',
        'build_component_add_buy_links_*_name_max' => 'Naziv linka za kupovinu komponente ne sme da bude duži od 50 karaktera.',
        'build_component_add_buy_links_*_link_required' => 'Link za kupovinu komponente mora da ima link.',
        'build_component_add_buy_links_*_link_max' => 'Link linka za kupovinu komponente ne sme da bude duži od 300 karaktera.',
        'build_component_add_buy_links_*_price_numeric' => 'Greška prilikom obrade novih linkova za kupovinu komponente.',
        'build_component_add_buy_links_*_price_min' => 'Cena linka za kupovinu komponente ne može da bude negativna.',
        'build_component_add_buy_links_*_delivery_group_id_int' => 'Greška prilikom obrade grupa za dostavu novih linkova za kupovinu komponente.',
    ],
    'create_new_delivery_group' => [
        'delivery_group_name_required' => 'Naziv grupe za dostavu je obavezan.',
        'delivery_group_name_max' => 'Naziv grupe za dostavu ne sme da bude duži od 50 karaktera.',
        'delivery_group_free_delivery_at_min' => 'Greška prilikom obrade grupe za dostavu.',
        'delivery_group_free_delivery_at_numeric' => 'Greška prilikom obrade grupe za dostavu.',
        'delivery_group_delivery_cost_min' => 'Greška prilikom obrade grupe za dostavu.',
        'delivery_group_delivery_cost_numeric' => 'Greška prilikom obrade grupe za dostavu.',
        'build_id_required' => 'Greška prilikom obrade konfiguracije grupe za dostavu.',
        'build_id_int' => 'Greška prilikom obrade konfiguracije grupe za dostavu.',
    ],
    'delete_build_component' => [
        'delete_build_component_id_required' => 'Greška prilikom obrade konfiguracije komponente za brisanje.',
        'delete_build_component_id_int' => 'Greška prilikom obrade konfiguracije komponente za brisanje.',
    ],
    'update_build_component' => [
        'build_component_id_required' => 'Greška prilikom obrade komponente.',
        'build_component_id_int' => 'Greška prilikom obrade komponente.',
        'build_component_name_required' => 'Naziv komponente je obavezan.',
        'build_component_name_max' => 'Naziv komponente ne sme da bude duži od 200 karaktera.',
        'build_component_buy_links_array' => 'Greška prilikom obrade postojećih linkova za kupovinu komponente.',
        'build_component_buy_links_*_id_required' => 'Greška prilikom obrade linka za kupovinu komponente.',
        'build_component_buy_links_*_id_int' => 'Greška prilikom obrade linka za kupovinu komponente.',
        'build_component_buy_links_*_name_required' => 'Postojećem linku za kupovinu komponente se ne može ukloniti naziv.',
        'build_component_buy_links_*_name_max' => 'Naziv linka za kupovinu komponente ne sme da bude duži od 50 karaktera.',
        'build_component_buy_links_*_link_required' => 'Link za kupovinu komponente mora da ima link.',
        'build_component_buy_links_*_link_max' => 'Link linka za kupovinu komponente ne sme da bude duži od 300 karaktera.',
        'build_component_buy_links_*_price_required' => 'Postojećem linku za kupovinu komponente se ne može ukloniti cena.',
        'build_component_buy_links_*_price_numeric' => 'Greška prilikom obrade postojećih linkova za kupovinu komponente.',
        'build_component_buy_links_*_price_min' => 'Cena linka za kupovinu komponente ne može da bude negativna.',
        'build_component_buy_links_*_delivery_group_id_int' => 'Greška prilikom obrade grupa za dostavu postojećih linkova za kupovinu komponente.',
        'build_component_add_buy_links_array' => 'Greška prilikom obrade novih linkova za kupovinu komponente.',
        'build_component_add_buy_links_*_name_max' => 'Naziv linka za kupovinu komponente ne sme da bude duži od 50 karaktera.',
        'build_component_add_buy_links_*_link_required' => 'Link za kupovinu komponente mora da ima link.',
        'build_component_add_buy_links_*_link_max' => 'Link linka za kupovinu komponente ne sme da bude duži od 300 karaktera.',
        'build_component_add_buy_links_*_price_numeric' => 'Greška prilikom obrade novih linkova za kupovinu komponente.',
        'build_component_add_buy_links_*_price_min' => 'Cena linka za kupovinu komponente ne može da bude negativna.',
        'build_component_add_buy_links_*_delivery_group_id_int' => 'Greška prilikom obrade grupa za dostavu novih linkova za kupovinu komponente.',
    ],
    'save_build_name' => [
        'build_id_required' => 'Greška prilikom obrade konfiguracije.',
        'build_id_int' => 'Greška prilikom obrade konfiguracije.',
        'new_build_name_required' => 'Naziv konfiguracije je obavezan.',
        'new_build_name_max' => 'Naziv konfiguracije ne sme biti duži od 30 karaktera.',
    ],
    'update_delivery_groups' => [
        'build_id_int' => 'Greška prilikom obrade konfiguracije grupa za dostavu.',
        'delivery_groups_array' => 'Greška prilikom obrade postojećih grupa za dostavu.',
        'delivery_groups_*_id_required' => 'Greška prilikom obrade postojećih grupa za dostavu.',
        'delivery_groups_*_id_int' => 'Greška prilikom obrade postojećih grupa za dostavu.',
        'delivery_groups_*_name_required' => 'Greška prilikom obrade postojećih grupa za dostavu.',
        'delivery_groups_*_name_max' => 'Naziv grupe za dostavu ne može da bude duži od 50 karaktera.',
        'delivery_groups_*_free_delivery_at_numeric' => 'Greška prilikom obrade postojećih grupa za dostavu.',
        'delivery_groups_*_free_delivery_at_min' => 'Greška prilikom obrade postojećih grupa za dostavu.',
        'delivery_groups_*_delivery_cost_required' => 'Greška prilikom obrade postojećih grupa za dostavu.',
        'delivery_groups_*_delivery_cost_numeric' => 'Greška prilikom obrade postojećih grupa za dostavu.',
        'delivery_groups_*_delivery_cost_min' => 'Greška prilikom obrade postojećih grupa za dostavu.',
        'add_delivery_groups_array' => 'Greška prilikom obrade novih grupa za dostavu.',
        'add_delivery_groups_*_name_required' => 'Greška prilikom obrade novih grupa za dostavu.',
        'add_delivery_groups_*_name_max' => 'Naziv grupe za dostavu ne može da bude duži od 50 karaktera.',
        'add_delivery_groups_*_free_delivery_at_numeric' => 'Greška prilikom obrade novih grupa za dostavu.',
        'add_delivery_groups_*_free_delivery_at_min' => 'Greška prilikom obrade novih grupa za dostavu.',
        'add_delivery_groups_*_delivery_cost_numeric' => 'Greška prilikom obrade novih grupa za dostavu.',
        'add_delivery_groups_*_delivery_cost_min' => 'Greška prilikom obrade novih grupa za dostavu.',
    ],
    'forgot_your_password' => [
        'email_exists' => 'Ne postoji nalog sa unetom Email adresom.',
        'email_required' => 'Email adresa je obavezna.',
        'email_email' => 'Email adresa nije u tačnom formatu.',
        'email_max' => 'Email adresa nije u tačnom formatu.',
    ],
    'change_password' => [
        'new_passwords_dont_match' => 'Lozinke se ne poklapaju.',
        'new_password_min' => 'Lozinka mora da bude duža od 4 karaktera.',
        'new_password_max' => 'Lozinka ne sme da bude duža od 80 karaktera.',
        'new_password_required' => 'Lozinka je obavezna.',
        'new_password_regex' => 'Lozinka mora da sadrži minimum 1 broj i 1 slovo.',
        'token_expired' => 'Token za promenu lozinke je istekao.',
        'password_reset_token_required' => 'Greška prilikom obrade tokena za promenu lozinke.',
        'password_reset_token_min' => 'Greška prilikom obrade tokena za promenu lozinke.',
        'password_reset_token_max' => 'Greška prilikom obrade tokena za promenu lozinke.',
        'password_reset_token_exists' => 'Greška prilikom obrade tokena za promenu lozinke.',
    ],
    'generate_and_send_change_email_verification_link' => [
        'new_email_required' => 'Email adresa nije u tačnom formatu.',
        'new_email_email' => 'Email adresa nije u tačnom formatu.',
        'new_email_max' => 'Email adresa nije u tačnom formatu.',
        'new_email_unique' => 'Nalog sa ovom email adresom već postoji.',
    ],
    'change_email' => [
        'email_change_token_required' => 'Greška prilikom obrade tokena za promenu email adrese.',
        'email_change_token_min' => 'Greška prilikom obrade tokena za promenu email adrese.',
        'email_change_token_max' => 'Greška prilikom obrade tokena za promenu email adrese.',
        'email_change_token_exists' => 'Greška prilikom obrade tokena za promenu email adrese.',
        'token_expired' => 'Token za promenu email adrese je istekao.',
        'access_forbiden' => 'Zabranjen pristup. Ovaj zahtev za promenu email adrese nije vezan za vaš nalog.',
    ]
];