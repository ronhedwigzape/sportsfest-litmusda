<?php
	require_once "../auth.php";
	require_once "../../config/database.php";
	require_once "../../models/Event.php";
	require_once "../../models/Team.php";
	require_once "../../models/Competition.php";
	require_once "../../models/Category.php";
?>
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
		<div id="app" class="row">
			<?php
				foreach (Competition::all() as $competition){ 
			?>
			<div class="mb-5 competitions" style="display: none;" >
				<h3 class="text-center fw-semibold fst-italic" ><?php echo $competition->getTitle(); ?></h3>
				<hr width="5%" class="mx-auto" >

				<?php foreach(Category::all($competition->getId()) as $category){ ?>
				<div class="mb-5 categories" >
					<h4 class="fst-italic" ><?php echo $category->getTitle(); ?></h4>

					<div class="row events">
						<?php foreach(Event::all($category->getId()) as $event){ ?>
						<div class="cards col-md-4 text-center g-3 event-item" >
							<div class="card">
								<div class="card-body">
									<code>@<?php echo $event->getSlug(); ?></code>
									<h2 class="fs-3 fw-semibold mb-4" ><?php echo $event->getTitle(); ?></h2>
									<div class="d-flex flex-wrap" >
										<?php foreach(Team::rows($event->getID()) as $team){ ?>
											<div data-team="<?php echo $team["id"]; ?>" data-event="<?php echo $event->getID(); ?>" class="flex-grow-1 text-center team <?php echo $event->hasTeamNotShownUp(Team::findById($team["id"])) ? "noShow" : ""; ?>" >
												<div class="avatar" style="background-image: url('../uploads/<?php echo $team["logo"]; ?>')" ></div>
											</div>
										<?php } ?>
									</div>	
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>

	</div>

	<script type="text/javascript">
		(function(){
			$(".event-item").parent().parent().parent().fadeIn();

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
		})();
	</script>
</body>
</html>