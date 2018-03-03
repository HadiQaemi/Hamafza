<?php

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

        DB::table('user')->truncate();
        DB::table('user')->insert
        ([
            'Uname' => 'hamafza',
            'password' => '$2y$10$TWc9wBHZPeQkjscyctwlt.n.kNncye9a6EC8qasEd2MINw21rH2Ta',
            'Email' => 'info@hamafza.ir',
            'Name' => '-',
            'Family' => '-',
            //'created_at' => date('Y-m-d h:i:s'),
        ]);

        DB::table('smartdetect')->truncate();
        DB::table('smartdetect')->insert
        ([
            'content' => '89.165.122.115',
            'content_type' => 'ip',
        ]);
        DB::table('smartdetect')->insert
        ([
            'content' => '5.202.232.229',
            'content_type' => 'ip',
        ]);
        DB::table('smartdetect')->insert
        ([
            'content' => '5.202.233.153',
            'content_type' => 'ip',
        ]);
        DB::table('smartdetect')->insert
        ([
            'content' => 'dev',
            'content_type' => 'request_any',
        ]);

    }
}
