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
    Schema::create('employees', function (Blueprint $table) {
        $table->id();

        $table->foreignId('department_id')
            ->constrained('departments')
            ->cascadeOnDelete();

        $table->string('employee_code')->unique();
        $table->string('first_name');
        $table->string('last_name')->nullable();
        $table->string('email')->unique();
        $table->string('phone')->nullable();
        $table->date('date_of_birth')->nullable();
        $table->string('gender')->nullable();
        $table->text('address')->nullable();
        $table->date('joining_date');
        $table->string('designation')->nullable();
        $table->decimal('salary', 12, 2)->nullable();
        $table->string('profile_photo')->nullable();
        $table->boolean('status')->default(true);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
