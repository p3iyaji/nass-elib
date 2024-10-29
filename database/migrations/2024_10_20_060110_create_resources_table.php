<?php

use App\Models\Category;
use App\Models\ResourceCategory;
use App\Models\User;
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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('authors');
            $table->string('authors_affiliation')->nullable();
            $table->string('publisher');
            $table->date('date_of_publication');
            $table->year('year_of_publication');
            $table->string('issn_isbn_doi')->nullable();
            $table->string('edition')->nullable();
            $table->string('volume')->nullable();
            $table->string('issue')->nullable();
            $table->string('abstract')->nullable();
            $table->string('references')->nullable();
            $table->string('tags');
            $table->string('pages')->default(1);
            $table->string('cover_image')->nullable();
            $table->string('file');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
