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
        $contact -> name = 'phone';
        $contact -> slug = 'phone';
        $contact -> value = '0856428270';
        $contact -> type = 3;
        $contact -> status = 1;
        $contact->save();
        $contact = new Config;
        $contact -> name = 'email';
        $contact -> slug = 'email';
        $contact -> value = 'levietphu171993@gmail.com';
        $contact -> type = 3;
        $contact -> status = 1;
        $contact->save();
        $contact = new Config;
        $contact -> name = 'address';
        $contact -> slug = 'address';
        $contact -> value = 'Gia Cẩm, Việt trì, Phú thọ';
        $contact -> type = 3;
        $contact -> status = 1;
        $contact->save();
        $contact = new Config;
        $contact -> name = 'map';
        $contact -> slug = 'map';
        $contact -> value = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14867.2522857449!2d105.38246867063175!3d21.318401363005812!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31348d5c3d10d605%3A0x8e49e94702d0da4e!2zR2lhIEPhuqltLCBUcC4gVmnhu4d0IFRyw6wsIFBow7ogVGjhu40sIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1626857902745!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';
        $contact -> type = 3;
        $contact -> status = 1;
        $contact->save();
        $contact = new Config;
        $contact -> name = 'Work time';
        $contact -> slug = 'work-time';
        $contact -> value = 'Monday – Saturday: 08 AM – 21 PM';
        $contact -> type = 3;
        $contact -> status = 1;
        $contact->save();
    }
}
