<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->after('question', function ($table) {
                $table->string('answer')->nullable();
                $table->string('type')->nullable();
                $table->string('reference')->nullable();
                $table->unsignedInteger('marks')->nullable();
                $table->tinyInteger('status')->default(1)->comment('0=>Inactive, 1=>Active');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('answer');
            $table->dropColumn('type');
            $table->dropColumn('reference');
            $table->dropColumn('status');
        });
    }
};
