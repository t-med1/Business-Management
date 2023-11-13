<?php $this->extend('templates/layout') ?>

<!-- titre du page -->
<?php $this->section('title') ?>
LISTE CLIENT - PAGE
<?php $this->endsection() ?>

<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
<?php $this->endsection() ?>

<?php $this->section('client') ?>
active
<?php $this->endsection() ?>
<?php $this->section('clientl') ?>
active
<?php $this->endsection() ?>

<?php $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Client</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= base_url('/')?>">Acceuil</a></li>
					<li class="breadcrumb-item active">Client</li>
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
						<h3 class="card-title">Liste Des Clients</h3>
					</div>
					<div class="row">
					</div>
					<div class="card-body">
						<table id="example1" class="table table-bordered table-hover text-center">
							<thead>
								<tr>
									<th>Code Client</th>
									<th>Commercial</th>
									<th>Client</th>
									<th>Ville</th>
									<th>Email</th>
									<th>Tel</th>
									<th>Options</th>
								</tr>
							</thead>
							<tbody>
								<?php if ($result): ?>
									<?php foreach ($result as $list): ?>
										<tr>
											<td>
												<?= $list['code_client']?>
											</td>

											<td>
												<span class="badge <?= $list['role']=='admin' ? 'bg-success' : 'bg-warning' ?>" data-toggle="tooltip" data-placement="top" title="<?= $list['role']=='admin'?'admin':'géstionnaire' ?>">
													<?= $list['id_emp'] == session('id_employe') ? "VOUS" : $list['nom'].' '.$list['prenom'] ?>
												</span>
											</td>
											<td>
												<?php echo $list["societe"]; ?>
											</td>
											<td>
												<?php echo $list["ville"]; ?>
											</td>
											<td>
												<?php echo $list["email_client"]; ?>
											</td>
											<td>
												<?php echo $list["numero_telephone"]; ?>
											</td>
											<td class="text-center">
												<div class="btn-container" style="display:flex;justify-content:center;gap:5px">
													<a href="<?= base_url('client/details/commande/' . $list['id_client']) ?>"
														class="btn btn-primary btn-sm" data-toggle="tooltip"
														data-placement="top" title="Détails">
														<i class="fa fa-list-alt" aria-hidden="true"></i>
													</a>
													<a href="<?= base_url('client/modifier/' . $list['id_client']) ?>"
														class="btn btn-success btn-sm" data-toggle="tooltip"
														data-placement="top" title="Modifier">
														<i class="fa fa-wrench" aria-hidden="true"></i>
													</a>
													
												</div>
											</td>
										</tr>

									<?php endforeach; ?>
								<?php else: ?>
									<td colspan="10" style="text-align:center" class="bg-light">
										<p>Aucun Client trouvé...</p>
									</td>
								<?php endif; ?>
							</tbody>

						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="content" id="section">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header bg-info">
						<h3 class="card-title">Liste Des Relancements pour chaque Clients</h3>
					</div>
					<div class="card-body">
						<table id="example1" class="table table-bordered table-hover text-center">
							<thead>
								<tr>
									<th> Nombre </th>
									<th> Nom Client </th>
									<th> Email </th>
									<th> Numero Telephone </th>
									<th> Status Relancement </th>
								</tr>
							</thead>
							<tbody>
								<?php if ($resultRelance): ?>
									<?php foreach ($resultRelance as $res): ?>
										<tr class='text-dark' <?= $res['relance_faite'] ? 'class="disabled"' : '' ?>>
											<td>
												<?php echo $res['id_facture'] ?>
											</td>
											<td>
												<?php echo $res['societe'] ?>
											</td>
											<td>
												<?php echo $res['email_client'] ?>
											</td>
											<td>
												<?php echo $res['numero_telephone'] ?>
											</td>
											<td>
												<label class="text-danger" name='lab'>Relance à Faire</label>
												<input type="checkbox"
													name="relance_faite"
													value="0"
													data-id-facture="<?= $res['id_facture'] ?>"
													data-relance-faite="<?= $res['relance_faite'] ?>"
													<?= $res['relance_faite'] == 1 ? 'checked disabled' : '' ?>
													class="checks">
											</td>
										</tr>
									<?php endforeach; ?>
								<?php else:?>
										<tr>
                                            <td colspan="7" style="text-align:center" class="bg-light">
                                                <p>Aucun Relancement trouvé...</p>
                                            </td>
                                        </tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="content text-right" id="sec">
	<button type="button" class="btn btn-outline-info btn-sm" id="voir">Voir Le Relancement</button>
	<button type="button" class="btn btn-outline-danger btn-sm" id="annulerBTN">
		<i class="fa fa-eye-slash" aria-hidden="true"></i> Annuler
	</button>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	function confirmSwalDelete(id_client) {
		Swal.fire({
			title: 'Êtes-vous sûr?',
			text: 'Cela va supprimer cet employé et ses tâches et congés associés !',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Oui, supprimer'
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = '<?= site_url('client/delete/') ?>' + id_client;
			}
		});
		return false;
	}
</script>
<?php $this->endsection() ?>

<?php $this->section("script") ?>
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
	$(document).ready(function () {
    // Handler for checkbox change event
	$('[data-toggle="tooltip"]').tooltip();
    $('input[name="relance_faite"]').change(function () {
        var checkbox = $(this);
        var label = checkbox.siblings('label');
        var idFacture = checkbox.data('id-facture');
        var relanceFaite = checkbox.is(':checked') ? 1 : 0;

        // Update the label text and class
        if (relanceFaite) {
            label.text('Relance Faite').addClass('text-primary').removeClass('text-danger');
        } else {
            label.text('Relance à Faire').addClass('text-danger').removeClass('text-primary');
        }
		
        $.ajax({
            type: 'get',
            url: '/client/updateRelancement/' + idFacture,
            data: {
                relance_faite: relanceFaite,
            },
            success: function (response) {
                // Handle the server response if needed
				if (relanceFaite === 1) {
                    checkbox.prop('disabled', true);
                } else {
                    checkbox.prop('disabled', false);
                }
            },
            error: function (xhr, status, error) {
                // Handle errors if necessary
            }
        });
    });

    // Initial label text and class setup
    $('input[name="relance_faite"]').each(function () {
        var label = $(this).siblings('label');
        if ($(this).is(':checked')) {
            label.text('Relance Faite').addClass('text-primary').removeClass('text-danger');
        } else {
            label.text('Relance à Faire').addClass('text-danger').removeClass('text-primary');
        }
    });
});

$(document).ready(function(){
    $('#voir').on('click' , function(){
        $('#section, #annulerBTN').css({ 'display': 'block', 'opacity': 0 }).animate({ 'opacity': 1, 'transform': 'translateY(0)' }, 500);
        $('#voir').addClass('hide');
    });

    $('#annulerBTN').on('click' , function(){
        $('#section, #annulerBTN').animate({ 'opacity': 0, 'transform': 'translateY(-10px)' }, 500, function() {
            $(this).css('display', 'none');
        });
        $('#voir').removeClass('hide');
    });
});




</script>
<script>
	$(document).ready(function () {
		setTimeout(function () {
			$('#myDiv').slideUp();
		}, 1000);
	});
</script>
<?php $this->endsection() ?>