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
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('price', 'selling_price');
            $table->decimal('purchase_price', 15, 2)->after('category_id')->default(0);
        });

        Schema::table('transaction_details', function (Blueprint $table) {
            $table->renameColumn('price', 'selling_price');
            $table->decimal('purchase_price', 15, 2)->after('product_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('selling_price', 'price');
            $table->dropColumn('purchase_price');
        });

        Schema::table('transaction_details', function (Blueprint $table) {
            $table->renameColumn('selling_price', 'price');
            $table->dropColumn('purchase_price');
        });
    }
};
