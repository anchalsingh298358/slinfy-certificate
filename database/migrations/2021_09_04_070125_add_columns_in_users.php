<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('date')->nullable()->after('email');
            $table->string('father_name')->nullable()->after('date');
            $table->string('mother_name')->nullable()->after('father_name');
            $table->string('country_code', 50)->nullable()->after('mother_name');
            $table->string('phone_number')->nullable()->after('country_code');
            $table->string('gender')->nullable()->after('phone_number');
            $table->string('profile_pic')->nullable()->after('gender');
            $table->text('address')->nullable()->after('profile_pic');
            $table->string('city')->nullable()->after('address');
            $table->string('state')->nullable()->after('city');
            $table->integer('duration_id')->nullable()->comment('6 week or 6 month')->after('state');
            $table->date('date_from')->nullable()->after('duration_id');
            $table->date('date_to')->nullable()->after('date_from');
            $table->string('batch_id')->nullable()->after('date_to');
            $table->integer('technology_id')->nullable()->after('batch_id');
            $table->string('college_name')->nullable()->after('technology_id');
            $table->string('session')->nullable()->after('college_name');
            $table->time('last_login')->nullable()->after('session');
            $table->integer('is_logged_in')->nullable()->after('last_login');
            $table->string('device_type')->nullable()->after('is_logged_in');
            $table->string('device_token')->nullable()->after('device_type');
            $table->integer('created_by')->nullable()->after('device_token');
            $table->integer('status')->default(1)->comment('0 inactive 1 active')->after('created_by');
            $table->softDeletes()->after('updated_at');


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
        });
    }
}
