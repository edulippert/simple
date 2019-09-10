<?php

use App\File;
use Illuminate\Database\Seeder;

class FileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        File::create([
            'file' => 'teste',
            'name' => 'my',
            'type' => 'txt',
            'subtype' => 'nothing'
        ]);
    }
}
