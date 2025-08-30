<?php

use App\Models\User;
use App\Models\Workshop;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('speeches', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('untitled');
            $table->string('length');
            $table->string('pathway');
            $table->integer('level')->nullable();
            $table->integer('project')->nullable();
            $table->text('objectives');
            $table->text('evaluator_notes')->nullable();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(User::class, 'evaluator_id')->nullable();
            $table->foreignIdFor(Workshop::class)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('speeches');
    }
};
