<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('provider_name')->nullable()->after('id');
            $table->string('provider_id')->nullable()->after('provider_name');
            $table->string('password')->nullable()->change();
            $table->string('avatar')->nullable();
        });
    }
};
