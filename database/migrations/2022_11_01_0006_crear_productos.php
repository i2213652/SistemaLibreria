<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\General\Sede;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('inventario_productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 7)->nullable();
            $table->string('descripcion', 300);
            $table->decimal('cantidad', 10, 2);
            $table->unsignedBigInteger('marca_id')->nullable();
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->decimal('precio_compra', 10, 2)->default(0);
            $table->decimal('precio_venta', 10, 2)->default(0);

            $table->timestamps();

            $table->foreign('marca_id')->references('id')->on('inventario_marcas');
            $table->foreign('categoria_id')->references('id')->on('inventario_categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('inventario_productos');
        Schema::enableForeignKeyConstraints();
    }
};
