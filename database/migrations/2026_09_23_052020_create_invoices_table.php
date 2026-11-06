<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lease_id')->constrained('leases')->onDelete('cascade');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->decimal('old_water_meter', 8, 2);
            $table->decimal('new_water_meter', 8, 2);
            $table->decimal('old_elec_meter', 8, 2);
            $table->decimal('new_elec_meter', 8, 2);
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['unpaid', 'pending_verification', 'paid', 'overdue'])->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
