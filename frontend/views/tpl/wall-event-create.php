<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 10.03.15
 * Time: 1:42
 * @var $model  \common\models\Wall
 * @var $status int
 * @var $event  \common\models\Event
 * @var $user   \common\models\User
 */
use common\helpers\Time;
use common\models\Wall\SubscribeEvent;
use yii\helpers\Url;

?>
<div class=" panel panel-default">
	<div class="panel-body">
		<div class="media">
			<div class="media-left">
				<a href="<%= dt.model.event.link.view%>">
					<img class="media-object" src="<%=dt.model.event.img.md%>" alt="..." width="120">
				</a>
			</div>
			<div class="media-body">
				<div class="pull-right text-muted"><%=dt.date%></div>
				<div class="media-heading">
					<a href="<%=dt.model.user.link.home%>"><%= dt.model.user.username%></a> создал событие:
				</div>
				<hr class="separator"/>
				<strong><%=dt.model.event.name%></strong><br/>
				<span title="Категория"><i class="md  md-label"></i> <%= dt.model.event.type.name%></span><br/>
				<span title="Адрес"><i class="md  md-place"></i> <%= dt.model.event.geo_description%></span><br/>
			</div>
		</div>
	</div>
</div>