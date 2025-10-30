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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('position');
            $table->string('link');
            $table->string('contact')->nullable();
            $table->date('applied_date');
            $table->string('interview_date')->nullable();
            $table->decimal('salary', total: 8, places: 2)->nullable();
            $table->text('feedback')->nullable();
            $table->foreignId('status_id')->constrained('statuses');
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('city_id')->nullable()->constrained('cities');
            $table->foreignId('modality_id')->constrained('modalities');
            $table->foreignId('contract_id')->constrained('contracts');
            $table->foreignId('category_id')->constrained('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
