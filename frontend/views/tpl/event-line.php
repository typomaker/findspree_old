	<div class="panel panel-default">
		<div class="panel-body item">
			<h3><%= dt.name%></h3>
			<span title="Категория"><i class="md  md-label"></i> <%= dt.type.name%></span><br/>
			<span title="Адрес"><i class="md  md-place"></i> <%= dt.geo_description%></span><br/>
			<div class="row">
				<hr class="separator"/>
				<a href="<%= dt.link.view%>">
					<img src="<%=dt.img.main%>" class="img-responsive"  alt=""/>
				</a>
			</div>
		</div>
	</div>