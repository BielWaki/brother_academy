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
        Schema::create('Planos', function (Blueprint $table) {
            $table->id('idPlano');
            $table->string('nomePlano', 50);
            $table->decimal('valor', 10, 2);
            $table->integer('duracaoMeses');
            $table->boolean('deletado')->default(0);
            $table->dateTime('data_exclusao')->nullable();
            $table->integer('excluido_por_idAluno')->nullable();
        });

        Schema::create('Modalidades', function (Blueprint $table) {
            $table->id('idModalidade');
            $table->string('nome', 50)->unique();
            $table->text('descricao')->nullable();
        });

        Schema::create('Professores', function (Blueprint $table) {
            $table->id('idProfessor');
            $table->string('nome', 100);
            $table->string('telefone', 20)->nullable();
        });

        Schema::create('Alunos', function (Blueprint $table) {
            $table->id('idAluno');
            $table->string('nome', 100);
            $table->date('data_nascimento')->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('email', 100)->unique();
            $table->string('senha', 255);
            $table->unsignedBigInteger('idPlano')->nullable();
            $table->unsignedBigInteger('idProfessor')->nullable();
            $table->integer('tentativas_login')->default(0);
            $table->boolean('status_bloqueio')->default(0);

            $table->foreign('idPlano')->references('idPlano')->on('Planos');
            $table->foreign('idProfessor')->references('idProfessor')->on('Professores');
        });

        Schema::create('Pagamentos', function (Blueprint $table) {
            $table->id('idPagamento');
            $table->unsignedBigInteger('idAluno');
            $table->unsignedBigInteger('idPlano');
            $table->date('data_pagamento');
            $table->decimal('valor_pago', 10, 2);
            $table->string('status', 20)->default('Pendente'); // Ex: Pago, Pendente, Vencido

            $table->foreign('idAluno')->references('idAluno')->on('Alunos');
            $table->foreign('idPlano')->references('idPlano')->on('Planos');
        });

        Schema::create('Treinos', function (Blueprint $table) {
            $table->id('idTreino');
            $table->unsignedBigInteger('idAluno');
            $table->text('descricao');
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();

            $table->foreign('idAluno')->references('idAluno')->on('Alunos');
        });
        
        Schema::create('PlanoModalidade', function (Blueprint $table) {
            $table->unsignedBigInteger('idPlano');
            $table->unsignedBigInteger('idModalidade');
            $table->primary(['idPlano', 'idModalidade']);

            $table->foreign('idPlano')->references('idPlano')->on('Planos')->onDelete('cascade');
            $table->foreign('idModalidade')->references('idModalidade')->on('Modalidades')->onDelete('cascade');
        });
        
        Schema::create('ProfessorModalidade', function (Blueprint $table) {
            $table->unsignedBigInteger('idProfessor');
            $table->unsignedBigInteger('idModalidade');
            $table->primary(['idProfessor', 'idModalidade']);

            $table->foreign('idProfessor')->references('idProfessor')->on('Professores')->onDelete('cascade');
            $table->foreign('idModalidade')->references('idModalidade')->on('Modalidades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ProfessorModalidade');
        Schema::dropIfExists('PlanoModalidade');
        Schema::dropIfExists('Treinos');
        Schema::dropIfExists('Pagamentos');
        Schema::dropIfExists('Alunos');
        Schema::dropIfExists('Professores');
        Schema::dropIfExists('Modalidades');
        Schema::dropIfExists('Planos');
    }
};