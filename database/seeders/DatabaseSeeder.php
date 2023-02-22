<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     *
     *
     * @return void
     */
    public function run()
    {
        $roles=[3,2,2,3,2,3];

        if(Subject::count() == 0)
        {
            Subject::create(['name' => 'تجويد',"description"=>"...description"]);
            Subject::create(['name' => 'حفظ',"description"=>"...description"]);
            Subject::create(['name' => 'نظافة',"description"=>"...description"]);
            Subject::create(['name' => 'سلوك',"description"=>"...description"]);
        }
        if(Admin::count() == 0){
            $user=User::create(['first_name' => "Admin",
            'last_name' => "Admin",
            'image'=> 'storage/app/public/profiles/default.jpg',
            'phone'=> '123123123',
            'password' => bcrypt('12345678'),
            'is_approved' => 1,]);
                $user->admin()->create(['admin_id'=>$user->id]);
                $user->role()->attach(1);
        }




         \App\Models\User::factory(10)->create()->each(function($user) use ($roles){
            for($i=0;$i<2;$i++){
                $number=rand(0,5);
               // $user->load('role');
               //if($user->role()->first())
               //echo($user->role()->first()->role_id==$number);

            if(!$user->role()->first()||!($user->role()->first()->role_id==$roles[$number])){
                $user->role()->attach($roles[$number]);
            }

            if($user->role()->first()->role_id==2){
                if(!$user->father()->first()){
                    $user->father()->create(['father_id'=>$user->id]);
                }
            }

            if($user->role()->first()->role_id==3){
                   if(!$user->teacher()->first()){
                       $user->teacher()->create(['teacher_id'=>$user->id]);
                    }
               }
//if user is a father then add some students
            }
         });
         \App\Models\Student::factory(20)->create();
         \App\Models\Session::factory(30)->create();
         \App\Models\Rating::factory(15)->create();
         \App\Models\Book::factory(15)->create();
         \App\Models\Favorite_book::factory(10)->create();
    }
}
