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
        Schema::create('formateur_filiere', function (Blueprint $table) {

            $table->foreignId("formateur_id")->references("id")->on("formateurs")->cascadeOnDelete();
            $table->foreignId("filiere_id")->references("id")->on("filieres")->cascadeOnDelete();

            $table->primary(["formateur_id","filiere_id"]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formateur_filiere');
    }
};
