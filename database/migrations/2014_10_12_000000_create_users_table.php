<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->unique()->index();
            $table->string('name',100)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->tinyInteger('role')->default(0)->comment('0=user ,1 admin');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->string('device_type')->nullable();
            $table->string('device_token')->nullable();
            $table->boolean('status')->default(0)->comment('0 = pending, 1 = verified,2 = blocked');
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
