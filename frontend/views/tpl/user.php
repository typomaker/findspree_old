<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 10.03.15
 * Time: 1:42
 * @var $model         \common\models\Wall
 * @var $userView      User пользователь, которому показываем
 * @var $status        int статус, подписался, отписался @see SubscribeUser::STATUS_*
 * @var $userTo        User список пользователей, на которых подписались
 * @var $userFrom      User пользователь который подписался
 */

use common\helpers\Time;
use common\models\User;
use common\models\Wall\SubscribeUser;

?>
	<div class="panel panel-default">
		<div class="panel-body item text-center">
			<h3><%= dt.username%></h3>
			<hr class="row separator"/>
			<div class="text-center">
				<a href="<%= dt.link.home%>">
					<%= Helper.html.avatar(dt,'md',{
					"class":"img-circle user-to",
					"title":dt.username,
					"alt":dt.username
					})%>
				</a>
			</div>
		</div>
	</div>