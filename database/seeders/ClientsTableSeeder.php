<?php

namespace Database\Seeders;

use App\Models\ERP\Sales\Client;
use App\Models\ERP\Sales\ClientContact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('client_contacts')->delete();
        DB::table('clients')->delete();

        Client::factory(10)->create()->each(function ($c){
            $c->contacts()->saveMany(ClientContact::factory(rand(1,4))->make());
        });
    }
}
