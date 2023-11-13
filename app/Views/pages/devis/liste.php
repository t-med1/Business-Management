<?php $this->extend('templates/layout') ?>

<!-- titre du page -->
<?php $this->section('title') ?>
LISTE DEVIS - PAGE
<?php $this->endsection() ?>

<!-- class active -->
<?php $this->section('devisli') ?>
active
<?php $this->endsection() ?>
<?php $this->section('devis') ?>
active
<?php $this->endsection() ?>

<!-- Le contenue du page home -->
<?php $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Devis</h1>
			</div>
			
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= base_url('/')?>">Acceuil</a></li>
					<li class="breadcrumb-item active">Liste Devis</li>
				</ol>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>
<?php $successFlash = session()->getFlashdata('success'); ?>
<?php if (isset($successFlash)): ?>
	<div class="row" id="myDiv">
		<div class="alert alert-success">
			<?= $successFlash ?>
		</div>
	</div>
<?php endif; ?>
<?php $errorFlash = session()->getFlashdata('error'); ?>
<?php if (isset($errorFlash)): ?>
	<div class="row" id="myDiv">
		<div class="alert alert-danger">
			<?= $errorFlash ?>
		</div>
	</div>
<?php endif; ?>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header bg-info">
						<h3 class="card-title">Filtrer Les Commandes</h3>
					</div>
					<div class="card-body">

						<form method="get" action="">

							<div class="row">

								<div class="col-md-3"></div>

								<div class="col-md-3">

									<div class="form-group">

										<label>Entre Le :</label>

										<input type="date" class="form-control" name="date_debut" value=""
											required>

									</div>
								</div>

								<div class="col-md-3">

									<div class="form-group">

										<label>Et Le :</label>

										<input type="date" class="form-control" name="date_fin" value=""
											required>

									</div>

								</div>

								<div class="col-md-3"></div>

							</div>

							<div class="row">

								<div class="col-md-3"></div>

								<div class="col-md-6">

									<button class="btn btn-info"
										style="width:100%; box-shadow: 8px 8px 2px #ECF0EF;">
										<i class="fa fa-search"></i> &nbsp; Filtrer
									</button>



								</div>

								<div class="col-md-3"></div>

							</div>

						</form>

					</div>

				</div>

			</div>

		</div>
	</div>
</section>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header bg-info">
						<h3 class="card-title">Liste Des Devis</h3>
					</div>
					<div class="row">

					</div>
					<div class="card-body">
						<table id="example1" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>N° Devis</th>
									<th>Date Saisie</th>
									<th>Client</th>
									<th>Description</th>
									<th>Prix Unitaire</th>
									<th>Total HT</th>
									<th>Total TTC</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php if($liste_devis):?>
									<?php $count = 1;
									  foreach ($liste_devis as $list): ?>
										<tr class="text-center">
											<td>
												<?= $list["code_devis"]; ?>
											</td>
											<td>
												<?= $list["date_saisie"]; ?>
											</td>
											<td>
												<a href="" style="font-weight:bold;text-decoration:none">
													<?= $list["societe"] ?>
												</a>
											</td>
											<td>
												<?php foreach ($list["infos"] as $infos) { ?>
													<?= '<strong>' . $infos["titre"] . '</strong><br><br>' ?>
												<?php } ?>
											</td>

											<td>
												<?php foreach ($list["infos"] as $infos) { ?>
													<?= $infos["prix_unitaire"] . "<br><br>" ?>
												<?php } ?>
											</td>
											<td>
												<?= $list["total_ht"] ?>
											</td>
											<td>
												<?= $list["total_ttc"] ?>
											</td>
											<td>
												<div class="btn-container" style="display:flex;justify-content:center;gap:5px">
													<a href="<?= base_url('/devis/details/' . $list['id_devis']) ?>"
														class="btn btn-primary btn-sm" data-toggle="tooltip"
														data-placement="top" title="Détails">
														<i class="fa fa-list-alt" aria-hidden="true"></i>
													</a>
													<a href="<?= base_url('/devis/modifier/' . $list['id_devis']) ?>"
														class="btn btn-success btn-sm" data-toggle="tooltip"
														data-placement="top" title="Modifier">
														<i class="fa fa-wrench" aria-hidden="true"></i>
													</a>
													<a href="<?= base_url('/devis/delete/' . $list['id_devis']) ?>"
														class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"
														title="Supprimer"
														onclick="return confirmSwalDelete(<?= $list['id_devis'] ?>);">
														<i class="fa fa-trash" aria-hidden="true"></i>
													</a>
													<a href="#" class="btn btn-warning btn-sm"
														data-toggle="tooltip" placement="top" title="Imprimer">
														<i class="fa fa-file-pdf-o download" aria-hidden="true" id="<?= $count ?>"></i>
													</a>
												</div>
											</td>
										</tr>
										<tr>
										<td colspan="10" style="padding: 0;">
											<div class="devis" id="<?= 'devis' . $count ?>">
												<img src="<?= base_url('css/Devis.jpg')?>" width="100%" class="bg">
												<p style="position: absolute; left: 25.3%; top: 36.2%; font-size: 20px;"><?= $list['societe'] ?> </p>
												<p style="position: absolute;  left: 49%; top: 39.8%; font-size: 20px;"><?= $list['ville'] ?> </p>
												<p style="position: absolute;  left: 80%;  top: 36.3%; font-size: 20px;"><?= $list['date_saisie'] ?> </p>
												<p style="position: absolute;  left: 80%;  top: 37.5%; font-size: 20px;"><?= $list['code_devis'] ?> </p>
												
												<?php $count = 5 ;?>
												<div style="position:absolute ; width:80% ;height:400px ;margin-left:10% ;top:44.9% ">
													<?php foreach ($list["infos"] as $infos): ?>
														<div style='padding-left:10px;height:375px ;position: absolute;width:100px; top: <?= $count ?>.7%; font-size: 20px;'>
															1
														</div>

														<div style="padding-left:10px;width:468px;height:375px ;position: absolute; left: 13%; top: <?= $count ?>.7%; font-size: 20px;display:flex;flex-wrap:wrap">
															<div>
																<strong><?= $infos["titre"] ?>:</strong> <span style="font-size:17px"><?= $infos["description"] ?></span>
															</div> <br><br>
														</div>

														<div style="padding-left:10px;width:100px;height:375px ;position: absolute; left: 72.7%; top: <?= $count ?>.7%; font-size: 20px;">
															<?= $infos["prix_unitaire"] ?> DH
														</div>
														<?php $count += 25?>
													<?php endforeach; ?>
												</div>

												<div style="position: absolute; left: 78.8%;  top: 67.8%; font-size: 19px;width: 11%;height:22px;text-align:center">
													<?= $list['total_ht'] ?>
												</div>
												<div style="position: absolute; left: 78.8%;  top: 72.3%; font-size: 19px;width: 11%;height:22px;text-align:center">
													<?= $list['total_ttc'] ?>
												</div>
												<div style="position: absolute; left: 10%;  top: 73%; font-size: 20px;height:80px;width: 34%;display:flex;justify-content:center;align-items:center;">
													<p><?= $list['modalite_paiement'] ?> </p>
												</div>
											</div>
										</td>
									</tr>
									
									<?php $count++ ; endforeach;?>
								<?php else :?>
									<td colspan="14" style="text-align:center" class="bg-light">
										<p>Aucun Devis trouvé...</p>
									</td>
								<?php endif;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
		function confirmSwalDelete(id_devis) {
		Swal.fire({
			title: 'Êtes-vous sûr?',
			text: 'Cela va supprimer cet devis et ses details de devis  !',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Oui, supprimer'
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = '<?= site_url('/devis/delete') ?>' + id_devis;
			}
		});
		return false;
		}
</script>

<?php $this->endsection()?>


<?php $this->section("script")?>
<script src="../../css/home.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js" integrity="sha512-234m/ySxaBP6BRdJ4g7jYG7uI9y2E74dvMua1JzkqM3LyWP43tosIqET873f3m6OQ/0N6TKyqXG4fLeHN9vKkg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	$(document).ready(function() {
		setTimeout(function() {
			$('#myDiv').slideUp();
		}, 1000);
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
<script>
	console.clear()
	document.querySelectorAll('.download').forEach(btn => {
		btn.addEventListener('click', e => {
			$('#devis' + e.target.id).show()
			html2canvas(document.getElementById('devis' + e.target.id))
				.then(canvas => {
					let base64image = canvas.toDataURL('image/png');
					console.log(base64image);

					let pdf = new jsPDF('p', 'px', [1117, 1423]);
					pdf.addImage(base64image, 'PNG', 4, -30, 1117, 1400);
					pdf.save('Devis.pdf')
				});
			$('#devis' + e.target.id).hide()

		})
	})
</script>
<script>
$(function () {
$("#example1").DataTable({
  "responsive": true, "lengthChange": false, "autoWidth": false,
  "buttons": ["excel", "pdf", "print"]
}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
$('#example2').DataTable({
  "paging": true,
  "lengthChange": false,
  "searching": false,
  "ordering": true,
  "info": true,
  "autoWidth": true,
  "responsive": true,
});
});
</script>
<?php $this->endsection() ?>