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
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'codigo_operador')) {
                $table->string('codigo_operador')->nullable()->after('email');
            }
            if (! Schema::hasColumn('users', 'perfil')) {
                $table->string('perfil')->nullable()->after('codigo_operador');
            }
            if (! Schema::hasColumn('users', 'access_token')) {
                $table->text('access_token')->nullable()->after('perfil');
            }
            if (! Schema::hasColumn('users', 'token_type')) {
                $table->string('token_type')->default('bearer')->after('access_token');
            }
            if (! Schema::hasColumn('users', 'ativo')) {
                $table->boolean('ativo')->default(true)->after('token_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columnsToDrop = array_filter(
                ['codigo_operador', 'perfil', 'access_token', 'token_type', 'ativo'],
                fn (string $column) => Schema::hasColumn('users', $column)
            );

            if (! empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
