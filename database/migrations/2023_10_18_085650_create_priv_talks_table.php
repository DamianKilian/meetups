<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('priv_talks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_user_id');
            $table->unsignedBigInteger('to_user_id');
            $table->foreign('from_user_id')->references('id')->on('users');
            $table->foreign('to_user_id')->references('id')->on('users');
            $fromAndToVirtualQuery = <<<SQL
            CASE
                WHEN from_user_id > to_user_id THEN CONCAT(from_user_id,'&',to_user_id)
                ELSE CONCAT(to_user_id,'&',from_user_id)
            END
            SQL;
            $table->string('from_and_to_virtual')->virtualAs($fromAndToVirtualQuery)->unique();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE priv_talks ADD CONSTRAINT chk_same_user CHECK (from_user_id != to_user_id);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('priv_talks');
    }
};
