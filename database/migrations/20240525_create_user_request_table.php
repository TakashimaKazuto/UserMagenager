<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 * ユーザ項目情報変更申請テーブルを作成
	 */
	public function up(): void
	{
		Schema::create('user_request', function (Blueprint $table) {
			$table->increments('id')->primary();;
			$table->integer('user_id')->index();
			$table->tinyInteger('status')->default(1);       //申請状況
			$table->tinyInteger('noticed_flg')->default(0);  //申請結果通知済フラグ
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('user_request');
	}
};
