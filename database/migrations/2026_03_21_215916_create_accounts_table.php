<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignUuid('account_type_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('currency', 3)->default('USD');
            $table->enum('status', ['active', 'suspended', 'closed'])->default('active');
            $table->softDeletes();

            $table->string('name');
            $table->decimal('balance', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
        DB::statement("DROP TYPE IF EXISTS account_status");
    }
};
