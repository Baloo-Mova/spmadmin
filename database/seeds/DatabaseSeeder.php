<?php

use App\FindSmtpSettings;
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

        if (SettingsForCheckSMTP::find(1) == null) {
            SettingsForCheckSMTP::create(['id' => 1]);
        }
        if (MailSettings::find(1) == null) {
            MailSettings::create(['id' => 1]);
        }
        if (PannelSettings::find(1) == null) {
            PannelSettings::create(['id' => 1]);
        }
        if (FindSmtpSettings::find(1) == null) {
            FindSmtpSettings::create(['id' => 1]);
        }
    }
}

