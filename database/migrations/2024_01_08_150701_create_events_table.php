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
            $table->double('price')->nullable()->comment('Contem o preco do evento');
            $table->integer('qtdParcelamento')->nullable(true)->comment('Contem a quantidade de parcelamento');
            $table->string('department')->nullable()->comment('Contem o departamento que esta envolvido com o evento');
            $table->string('occupation')->nullable()->comment('Contem a ocupacao do local');
            $table->date('dateEvent')->nullable()->comment('Contem a data do evento');
            $table->string('timeEvent')->nullable(true)->comment('Contem a hora do evento');
            $table->boolean('statusEvent')->nullable(true)->comment('Contem o status do evento, se esta ativo ou nao');
            $table->text('description')->nullable()->comment('Contem a descricao do evento');
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
