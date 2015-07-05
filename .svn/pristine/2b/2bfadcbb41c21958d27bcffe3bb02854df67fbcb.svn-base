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
<div class=" panel panel-default">
	<div class="panel-body">
		<div class="media">
			<div class="media-left">
				<div class="subscribe-users">
					<a href="<%= dt.model.userFrom.link.home%>" class="wall-user-subscribe-ava">
						<%= Helper.html.avatar(dt.model.userFrom,'sm',{
						"class":"img-circle user-from",
						"title":dt.model.userFrom.username,
						"alt":dt.model.userTo.username
						})%>
					</a>
				</div>
			</div>
			<div class="media-body">
				<div class="pull-right text-muted"><%=dt.date%></div>
				<div class="media-heading">
					<a href="<%=dt.model.userFrom.link.home%>"><%= dt.model.userFrom.username%></a> <%=dt.data.status?'подписался на':'отписался от'%> <a href="<%=dt.model.userTo.link.home%>"><%= dt.model.userTo.username%></a>
				</div>
				<hr class="separator"/>
			</div>
			<div class="media-right">
				<a href="<%= dt.model.userTo.link.home%>" class="wall-user-subscribe-ava">
					<%= Helper.html.avatar(dt.model.userTo,'sm',{
					"class":"img-circle user-to",
					"title":dt.model.userTo.username,
					"alt":dt.model.userTo.username
					})%>
				</a>
			</div>
		</div>
	</div>
</div>
