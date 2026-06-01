<?php

use App\Models\Ping;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Ping::truncate();

        Schema::table('pings', static function (Blueprint $table) {
            $table->dropColumn('uuid');
            $table->foreignId('device_id')->after('id')->nullable()->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pings', static function (Blueprint $table) {
            $table->dropConstrainedForeignId('device_id');
            $table->string('uuid')->change();
        });
    }
};
