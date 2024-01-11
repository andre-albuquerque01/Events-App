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
        Schema::create('user_has_events', function (Blueprint $table) {
            $table->id('idUser_has_events');
            $table->float('valuePay')->comment('Contem o valor total do evento');
            $table->string('qtdTicket')->comment('Contem a quantidade de ingressos');
            $table->boolean('statusPay')->comment('Contem o status de pagamento do usuario');
            $table->string('numberPix')->comment('Contem o numero do pix, qr code');
            $table->string('pathName')->comment('Contem o caminho da imagem que será reenvio do usuário');

            $table->unsignedBigInteger('idUser')->comment('Contem a chave estrangeira do user');
            $table->foreign('idUser')->references('idUser')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('idEvents')->comment('Contem a chave estrangeira do events');
            $table->foreign('idEvents')->references('idEvents')->on('events')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_has_events');
    }
};
