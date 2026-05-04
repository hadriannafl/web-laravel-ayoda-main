<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventory_assets_request', function (Blueprint $table) {
            $table->id('idrec');
            $table->string('idreqform')->nullable();
            $table->string('pr_title')->nullable();
            $table->date('pr_date')->nullable();
            $table->string('pr_file')->nullable();
            $table->string('applicant')->nullable();
            $table->string('prepared_by')->nullable();
            $table->date('prepared_date')->nullable();
            $table->string('department')->nullable();
            $table->string('division')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('pic')->nullable();
            $table->text('delivery_address')->nullable();
            $table->date('delivery_date')->nullable();
            $table->decimal('delivery_charge', 20, 2)->default(0);
            $table->string('idsupplier')->nullable();
            $table->string('category')->nullable();
            $table->string('purch_type')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('subtotal', 20, 2)->default(0);
            $table->decimal('discount', 20, 2)->default(0);
            $table->decimal('ppn', 20, 2)->default(0);
            $table->decimal('gtotal', 20, 2)->default(0);
            $table->decimal('total', 20, 2)->default(0);
            $table->decimal('balance', 20, 2)->default(0);
            $table->string('id_rab')->nullable();
            $table->date('rab_date')->nullable();
            $table->string('id_warehouse')->nullable();
            $table->string('loc')->nullable();
            $table->string('payment_by')->nullable();
            $table->string('approval_to')->nullable();
            $table->string('approval1_status')->nullable();
            $table->string('approval1stat')->nullable();
            $table->string('approved1by')->nullable();
            $table->dateTime('approvaldate')->nullable();
            $table->string('approval2_to')->nullable();
            $table->string('approval2_status')->nullable();
            $table->string('approval2stat')->nullable();
            $table->string('approved2by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('approvalstat')->nullable();
            $table->string('approval3_to')->nullable();
            $table->string('reviewed_by')->nullable();
            $table->string('reviewed2_by')->nullable();
            $table->string('quotation1')->nullable();
            $table->string('quotation2')->nullable();
            $table->string('quotation3')->nullable();
            $table->decimal('total_quo1', 20, 2)->default(0);
            $table->decimal('total_quo2', 20, 2)->default(0);
            $table->decimal('total_quo3', 20, 2)->default(0);
            $table->string('vendor_quo1')->nullable();
            $table->string('vendor_quo2')->nullable();
            $table->string('vendor_quo3')->nullable();
            $table->string('quotation_approval1')->nullable();
            $table->string('quotation_approval2')->nullable();
            $table->string('price_updated')->nullable();
            $table->string('receivestat')->nullable();
            $table->string('print_status')->nullable();
            $table->string('status')->nullable();
            $table->string('aktifyn')->nullable();
            $table->string('reqlevel')->nullable();
            $table->text('note')->nullable();
            $table->text('message')->nullable();
            $table->text('remarks1')->nullable();
            $table->text('remarks2')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_assets_request');
    }
};
