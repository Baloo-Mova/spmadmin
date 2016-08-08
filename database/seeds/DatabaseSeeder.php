<?php

use App\MailSettings;
use App\PannelSettings;
use App\SettingsForCheckSMTP;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminUser::class);

        SettingsForCheckSMTP::create(['id'=>1]);
        MailSettings::create(['id'=>1]);
        PannelSettings::create(['id'=>1]);
    }
}

