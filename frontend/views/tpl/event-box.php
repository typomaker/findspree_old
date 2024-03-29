<div class="event-item" itemscope itemtype="http://schema.org/Event">
	<div class="event-img">
		<a href="<%=dt.link.view %>"><img src="<%=dt.img.main%>" class="img-responsive" itemprop="image"/></a>
	</div>
	<div class="event-body">
		<a href="<%=dt.user.link.home %>">
			<%= Helper.html.avatar(dt.user,50,{
			"class":"media-object img-circle owner-img",
			"title":dt.user.username,
			"alt":dt.user.username
			})%>
		</a>

		<div class="event-title" itemprop="name"><%=dt.name%></div>
		<div title="Категория"><i class="md  md-label"></i> <%=dt.type.name %></div>
		<div title="Время начала" class="event-date"><i class="md md-access-time"></i>
			<small itemprop="startDate" content="<%= dt.begin %>"><%= dt.f.begin %></small>
		</div>
		<div itemprop="location" itemscope itemtype="http://schema.org/Place">
			<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"
				 title="<%= dt.geo_description%>">
				<i class="md  md-place"></i>
				<small itemprop="streetAddress"><%= dt.geo_title%></small>
			</div>
		</div>

		<% if(dt.tags.length>0){ %>
		<hr class="separator"/>
		<% for( var key in dt.tags ){
			var tag = dt.tags[key];
			%>
			<div class="label label-primary tag-link" data-tag="<%=tag%>" title="Нажми, что бы найти по тегу">#<%=tag%></div>
			<% } %>
		<% } %>

		<div class="event-control">
			<% if(dt.finished) { %>
			<i class="md md-check" title="Мероприятие завершено"></i>
			<% } else { %>
			<i class="md <% if(dt.subscribe){%> md-add-circle<% }else{ %>md-add-circle-outline <%} %> event-control-subscribe "
			   data-remote="<%=dt.link.subscribe%>"
			   title="<% if(dt.subscribe){%> Отменить подписку<% }else{ %>Подписаться<%} %>"></i>
			<% } %>
			<a href="<%=dt.link.view%>" title="Подробнее"><i class="md md-menu event-control-view"></i></a>
		</div>
	</div>
</div>