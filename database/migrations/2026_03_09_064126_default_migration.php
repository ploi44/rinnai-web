<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // 1. 회원 테이블 확장 (기본 users 활용)
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_id')->unique()->after('id');
            $table->string('phone')->nullable()->after('email');
            $table->integer('level')->default(1)->after('phone'); // 1: 일반, 10: 관리자 등
        });

        // 2. 배너 관리
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image_path');
            $table->boolean('is_active')->default(true);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // 3. 게시판 설정
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // 게시판 아이디 (예: notice, gallery)
            $table->string('name');
            $table->enum('type', ['general', 'album'])->default('general');
            $table->integer('read_level')->default(1);
            $table->integer('write_level')->default(1);
            $table->timestamps();
        });

        // 4. 게시물
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->string('title');
            $table->text('content');
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });

        // 5. 사이트 설정 (Key-Value 방식)
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }
};
