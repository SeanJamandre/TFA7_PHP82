<?php
namespace Database\Seeders;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder {
 public function run(): void {
  Customer::firstOrCreate(['email'=>'ana@example.com'],['full_name'=>'Ana Reyes']);
  Customer::firstOrCreate(['email'=>'marco@example.com'],['full_name'=>'Marco Santos']);
  User::firstOrCreate(['username'=>'sean'],['full_name'=>'Sean James Jamandre']);
  User::firstOrCreate(['username'=>'cashier'],['full_name'=>'Sample Cashier']);
 }
}
