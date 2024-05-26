<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 * 項目情報選択肢マスタテーブルを作成
	 */
	public function up(): void
	{
		Schema::create('item_selects', function (Blueprint $table) {
			$table->increments('id')->primary();;
			$table->integer('item_id');
			$table->string('name', 20);
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();

			$table->index(['id', 'item_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('item_selects');
	}
};
