<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Method;

class MethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $walk = new Method;
        $walk->name = "Walking";
        $walk->co2_constant = 0;
        $walk->save();

        $bike = new Method;
        $bike->name = "Cycling";
        $bike->co2_constant = 0;
        $bike->save();

        $pub = new Method;
        $pub->name = "Public transport";
        $pub->co2_constant = 1;
        $pub->save();
    }
}
