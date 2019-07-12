<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGeoLocationToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
             $table->string('ip_address')->nullable()->after('email');
             $table->string('country')->nullable()->after('ip_address');
             $table->string('city')->nullable()->after('country');
             $table->float('lat')->nullable()->after('city');
             $table->float('lon')->nullable()->after('lat');
             $table->boolean('status')->nullable()->nullable()->after('lon');
             $table->boolean('block_status')->nullable()->after('city');
             $table->string('type')->default('user')->nullable()->after('block_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
          
             $table->dropColumn('ip_address')->nullable()->after('email');
             $table->dropColumn('country')->nullable()->after('ip_address');
             $table->dropColumn('city')->nullable()->after('country');
             $table->dropColumn('lat')->nullable()->after('city');
             $table->dropColumn('lon')->nullable()->after('lat');
             $table->dropColumn('status')->nullable()->after('lon');
             $table->dropColumn('block_status')->default(false)->after('city');
             $table->dropColumn('type')->default('user')->nullable()->after('block_status');
        });
    }
}
