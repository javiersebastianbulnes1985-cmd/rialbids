<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('auctions', function (Blueprint $table) {
            $table->string('tracking_carrier')->nullable()->after('tracking_number');
            $table->timestamp('payment_release_scheduled_at')->nullable()->after('payment_released_at');
            $table->string('dispute_id')->nullable()->after('payment_release_scheduled_at');
            $table->string('dispute_status')->nullable()->after('dispute_id');
            $table->timestamp('disputed_at')->nullable()->after('dispute_status');
        });
    }
    public function down(): void {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropColumn(['tracking_carrier','payment_release_scheduled_at','dispute_id','dispute_status','disputed_at']);
        });
    }
};
