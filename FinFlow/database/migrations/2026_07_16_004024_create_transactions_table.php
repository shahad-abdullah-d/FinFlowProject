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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

$table->foreignId('customer_id')
    ->constrained()
    ->cascadeOnDelete();

$table->foreignId('created_by')
    ->constrained('users')
    ->restrictOnDelete();

$table->foreignId('approved_by')
    ->nullable()
    ->constrained('users')
    ->nullOnDelete();

$table->string('transaction_type');
$table->decimal('amount', 15, 2);

$table->enum('status', [
    'draft',
    'pending_review',
    'returned',
    'approved',
    'rejected',
    'completed'
])->default('draft');

$table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
