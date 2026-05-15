<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            if (!Schema::hasColumn('auctions', 'youtube_url')) {
                $table->string('youtube_url', 500)->nullable()->after('description');
            }
            if (!Schema::hasColumn('auctions', 'base_price')) {
                $table->decimal('base_price', 15, 2)->default(0)->after('youtube_url');
            }
            if (!Schema::hasColumn('auctions', 'starting_price')) {
                $table->decimal('starting_price', 15, 2)->default(0)->after('base_price');
            }
            if (!Schema::hasColumn('auctions', 'current_price')) {
                $table->decimal('current_price', 15, 2)->default(0)->after('starting_price');
            }
            if (!Schema::hasColumn('auctions', 'min_increment')) {
                $table->decimal('min_increment', 15, 2)->default(1)->after('current_price');
            }
            if (!Schema::hasColumn('auctions', 'category_id')) {
                $table->unsignedBigInteger('category_id')->default(1)->after('user_id');
            }
            if (!Schema::hasColumn('auctions', 'starts_at')) {
                $table->dateTime('starts_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn('auctions', 'end_time')) {
                $table->dateTime('end_time')->nullable()->after('starts_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropColumn([
                'youtube_url', 'base_price', 'starting_price', 
                'current_price', 'min_increment', 'category_id', 
                'starts_at', 'end_time'
            ]);
        });
    }
};