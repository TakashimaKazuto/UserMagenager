<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 * 項目情報マスタテーブルを作成
	 */
	public function up(): void
	{
		Schema::create('item', function (Blueprint $table) {
			$table->increments('id')->primary();
			$table->string('name', 20);              //項目名
			$table->string('description', 100);      //項目説明
			$table->tinyInteger('type');             //項目種別
			$table->tinyInteger('procedure');        //一般アカウントの編集権限
			$table->tinyInteger('required_flg');     //必須フラグ
			$table->integer('sort');                 //並び順
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('item');
	}
};
