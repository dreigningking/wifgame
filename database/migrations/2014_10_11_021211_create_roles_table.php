<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('subroles');
            $table->timestamps();
        });
        DB::table('roles')->insert([
            ['id' => '1','name'=>'admin', 'subroles' => json_encode(['owner','manager','support'])],
            ['id' => '2','name'=>'individual', 'subroles' => json_encode(['owner'])],
            ['id' => '3','name'=>'merchant', 'subroles' => json_encode(['owner','manager','support'])],
            ['id' => '4','name'=>'logistics', 'subroles' => json_encode(['owner','manager','support'])],
            ['id' => '5','name'=>'insurance', 'subroles' => json_encode(['owner','manager','support'])],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
