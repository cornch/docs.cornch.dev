<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comment_reactions', static function (Blueprint $table): void {
            $table->id();

            $table->unsignedBigInteger('comment_id');
            $table->string('reactor_fingerprint');
            $table->enum('reaction', ['thumbs_up', 'thumbs_down', 'laugh', 'hooray', 'confused', 'heart', 'rocket', 'eyes']);

            $table->timestamps();

            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
            $table->index('comment_id');
            $table->index('reactor_fingerprint');
            $table->unique(['comment_id', 'reactor_fingerprint', 'reaction']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comment_reactions');
    }
};
