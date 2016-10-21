<?php

return function ($installer) {

	$installer->setSchema(function ($schema) {

		if ($schema::connection('ximu_wechat')->hasTable('wechat_token')) {

			exception('failed', ['tip' => '目标数据库 wechat_token 表已经存在']);

		} else {

			$schema::create('wechat_token', function ($table) {
				$table->increments('id');
				$table->string('access_token');
				$table->string('jsapi_ticket');
				$table->string('token_time');
				$table->string('ticket_time');
			});

		}
		if ($schema::connection('ximu_wechat')->hasTable('wechat_user')) {

			exception('failed', ['tip' => '目标数据库 wechat_user 表已经存在']);

		} else {

			$schema::create('wechat_user', function ($table) {
				$table->increments('id');
				$table->string('openid');
				$table->int('subscribe');
				$table->string('nickname');
				$table->int('sex');
				$table->string('headimgurl');
				$table->string('subscribe_time');
				$table->string('groupid');
			});

		}

	});

	// return 需要写在最外围
	return status('success');
};