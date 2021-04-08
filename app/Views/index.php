<!doctype html>
<html lang="en">

<head>
	<title>Mitransfer</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css" integrity="sha256-PF6MatZtiJ8/c9O9HQ8uSUXr++R9KBYu4gbNG5511WE=" crossorigin="anonymous" />

	<link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">

	<script>
		const BASE_URL = "<?php base_url() ?>"
	</script>
</head>

<body>
	<div class="wrap mt-5">
		<div class="container">
			<div class="col col-md-6 col-lg-6 col-sm-12 col-xl-4">
				<div class="card border-purple-top">
					<form id="formFiles" method="POST" enctype="multipart/form-data">
						<input type="hidden" id="csrf" class="csrf" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
						<div class="card-body">
							<h5 class="card-title select-files">
								<div class="btn rounded-circle btn-primary"> <i class="fa fa-plus"></i></div>
								<label for="files" class="text-white">Adicionar arquivos</label>
								<input type="file" name="files[]" id="files" multiple>
								<br>
								<small style="font-size: 14px;" class="text-white" id="selectedFiles"></small>
							</h5>
						</div>
						<ul class="list-group list-group-flush">
							<li class="list-group-item">
								<div id="resultMessage"></div>
								<div class="form-group">
									<label for="emailFrom" class="text-white">Seu endereço de e-mail</label>
									<input type="email" class="form-control form-control-sm" id="emailFrom" name="emailFrom" placeholder="">
								</div>

								<div class="form-group">
									<label for="emailTo" class="text-white">Endereço de e-mail de destino</label>
									<input type="email" class="form-control form-control-sm" id="emailTo" name="emailTo" placeholder="">
								</div>

								<div class="form-group">
									<label for="emailFrom" class="text-white">Mensagem</label>
									<textarea class="form-control form-control-sm" name="message" id="message" rows="3"></textarea>
								</div>

							</li>
							<li class="list-group-item">
								<button type="button" class="btn btn-primary btn-sm" id="sendFiles"> <i class="fa fa-paper-plane"></i> Enviar arquivos </button>
							</li>
						</ul>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
	</script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
	</script>

	<script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>

</html>