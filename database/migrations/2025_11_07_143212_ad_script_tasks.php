<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\AdScriptTaskStatus;

return new class extends Migration
{
    const TABLE_NAME = 'ad_script_tasks';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $statuses = [
                AdScriptTaskStatus::PENDING->value,
                AdScriptTaskStatus::COMPLETED->value,
                AdScriptTaskStatus::FAILED->value,
            ];

            $table->id();
            $table->text('reference_script');
            $table->text('outcome_description');
            $table->longText('new_script')->nullable();
            $table->longText('analysis')->nullable();
            $table->enum('status', $statuses)
                ->default(AdScriptTaskStatus::PENDING->value);
            $table->text('error')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
