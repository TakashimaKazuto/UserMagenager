<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 * ユーザ項目情報変更申請項目内容テーブルを作成
	 */
	public function up(): void
	{
		Schema::create('user_request_item', function (Blueprint $table) {
			$table->increments('id')->primary();;
			$table->integer('user_id')->index();
			$table->integer('item_id')->index();
			$table->integer('user_item_id')->index();
			$table->integer('user_request_id')->index();
			$table->string('string', 255);      //文字列項目の入力値
			$table->text('text');               //長文項目の入力値
			$table->integer('number');          //数値項目の入力値
			$table->integer('item_select_id');  //選択肢項目の入力値
			$table->text('note');               //備考
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('user_request_item');
	}
};
