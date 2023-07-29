<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Config;


class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contact = new Config;
        $contact -> name = 'logo header';
        $contact -> slug = 'logo-header';
        $contact -> value = 'logo-header.png';
        $contact -> type = 1;
        $contact -> status = 1;
        $contact->save();

        $contact = new Config;
        $contact -> name = 'logo footer';
        $contact -> slug = 'logo-footer';
        $contact -> value = 'logo-footer.png';
        $contact -> type = 1;
        $contact -> status = 1;
        $contact->save();
       
    }
}
