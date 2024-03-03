<?php

use App\Models\Township;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('phone');
            $table->unsignedInteger('township_id');
            $table->string('address');

            $table->boolean('cod')->default(true);

            $table->unsignedInteger('payment_account_id')->nullable();
            //payment confirmation slip

            $table->unsignedInteger('total');
            $table->unsignedInteger('tax');
            $table->unsignedInteger('grand_total');
            $table->enum('status', ['new', 'processing', 'shipped', 'delivered', 'cancelled'])->default('new');
            $table->string('note');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
