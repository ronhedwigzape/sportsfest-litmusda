<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>NoShow</title>

	<link rel="stylesheet" type="text/css" href="../dist/bootstrap-5.2.3/css/bootstrap.min.css" />
	<script type="text/javascript" src="../dist/jquery-3.6.4/jquery-3.6.4.min.js" ></script>
	<script type="text/javascript" src="../dist/bootstrap-5.2.3/js/bootstrap.min.js" ></script>

	<style type="text/css">
		code{ color: #013512; }

		.team{
			cursor: pointer;
			transition: 0.5s linear;
		}
		.team:hover .avatar{
			transform: scale(1.05);
		}

		.team .avatar{
			transition: 0.2s ease;
			height: 5rem;
			width: 5rem;
			background-size: cover;
			background-position: center center;
			margin: 0 auto;
		}

		.team.noShow{
			filter: grayscale(1);
			opacity: 0.2;
		}
	</style>

</head>
<body>

	<div class="container p-4">
		<div class="text-center" >
			<h3>NoShow</h3>
		</div>

		<div id="app" class="row">
		</div>

	</div>

	<script type="text/javascript">
		(function(){			
			let app = $("#app");
			let teams = [];
			let events = [];

			$.ajax({
				url: "controller.php?type=TEAMS",
				success: function(res){
					teams = res;
					
					$.ajax({
						url: "controller.php",
						success: function(res){
							events = res;

							events.forEach(function(event){

								let dom_teams = "";
								teams.forEach(function(team){
									let is_found = ( event.no_show.filter(e => e.id == team.id).length > 0 );

									dom_teams += `<div data-team="${ team.id }" data-event="${ event.id }" class="flex-grow-1 text-center team ${ is_found ? "botUp" : "" }" >
													<div class="avatar" style="background-image: url('../uploads/${ team.logo }')" ></div>
												</div>`;
								});

								app.append(`
								<div class="cards col-md-4 text-center g-3" style="display: none;" >
									<div class="card">
										<div class="card-body">
											<code>@${ event.slug }</code>
											<h2 class="fs-3 fw-semibold mb-4" >${ event.title }</h2>
											<div class="d-flex flex-wrap" >
												${ dom_teams }
											</div>	
										</div>
									</div>
								</div>
								`);
							});

							var cs = $(".cards");
							for( var i = 0; i < cs.length; i++ ){
								$(cs[i]).delay(100 * i).fadeIn();
							}
							setTimeout(() => {
								$(".botUp").addClass("noShow");
							}, (cs.length * 100) + 300);

							$(".team").click(function(){
								var _this = $(this);

								$.ajax({
									url: "controller.php",
									method: "POST",
									data: {
										team: _this.data("team"),
										event: _this.data("event")
									},
									success: function(res){
										if( res.action === 1 ){
											_this.addClass('noShow');
										}else{
											_this.removeClass('noShow');
										}
									}
								});

							});	
						}
					});
				}
			});

		})();
	</script>
</body>
</html>