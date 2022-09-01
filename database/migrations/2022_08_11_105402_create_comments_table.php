<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', static function (Blueprint $table): void {
            $table->id();

            $table->unsignedBigInteger('parent_comment_id')->nullable();

            $table->string('locale', 16);
            $table->string('doc', 32);
            $table->string('version', 16);
            $table->string('page', 128);

            $table->string('commenter_fingerprint');

            $table->string('name');
            $table->string('delete_password');

            $table->text('content');

            $table->boolean('is_approved')->default(false);

            $table->json('reactions_counter');

            $table->timestamps();
            $table->softDeletes();

            $table->index('parent_comment_id');
            $table->index('doc');
            $table->index('version');
            $table->index('page');
            $table->index('commenter_fingerprint');
            $table->index('is_approved');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
