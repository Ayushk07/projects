<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('billing_details', function (Blueprint $table) {
            $table->id();
            $table->string('customername', 250);
            $table->string('customeremail', 250);
            $table->string('customeraddress', 250);
            $table->string('customerstate', 250);
            $table->string('customerzipcode', 250);
            $table->string('nameoncard', 250);
            $table->string('creditcardnumber', 250);
            $table->string('expmonth', 250);
            $table->string('expyear', 250);
            $table->string('cvv', 250);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billing_details');
    }
};
