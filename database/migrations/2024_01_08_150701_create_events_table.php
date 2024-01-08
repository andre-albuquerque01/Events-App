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
        Schema::create('events', function (Blueprint $table) {
            $table->id('idEvents');
            $table->string('title')->comment('Contem o titulo do evento');
            $table->text('description')->nullable(false)->comment('Contem a descricao do evento');
            $table->double('price')->nullable()->comment('Contem o preco do evento');
            $table->string('department')->nullable(false)->comment('Contem o departamento que esta envolvido com o evento');
            $table->string('occupation')->nullable(false)->comment('Contem a ocupacao do local');
            $table->boolean('statusEvent')->nullable(true)->comment('Contem o status do evento, se esta ativo ou nao');
            $table->unsignedBigInteger('idFile')->nullable()->comment('Contem o id da tabela das imagens');
            $table->foreign('idFile')->references('idFile')->on('files')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
