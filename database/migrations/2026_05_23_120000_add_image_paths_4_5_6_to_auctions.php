<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('auctions', function (Blueprint $table) {
            $table->string('image_path_4')->nullable()->after('image_path_3');
            $table->string('image_path_5')->nullable()->after('image_path_4');
            $table->string('image_path_6')->nullable()->after('image_path_5');
        });
    }
    public function down() {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropColumn(['image_path_4','image_path_5','image_path_6']);
        });
    }
};
