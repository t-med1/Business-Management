<?php $this->extend('templates/layout') ?>

<!-- titre du page -->
<?php $this->section('title') ?>
LISTE SERVICE - PAGE
<?php $this->endsection() ?>

<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
<?php $this->endsection() ?>
<?php $this->section('service') ?>
active
<?php $this->endsection() ?>
<?php $this->section('servicel') ?>
active
<?php $this->endsection() ?>

<!-- Le contenue du page home -->
<?php $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Service</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= base_url('/')?>">Acceuil</a></li>
					<li class="breadcrumb-item active">Liste Service</li>
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
						<h3 class="card-title">Liste Des Service</h3>
					</div>
					<div class="row">

					</div>
					<div class="card-body">
						<table id="example1" class="table table-bordered table-hover text-center">
							<thead>
								<tr>
									<th>Code</th>
									<th>Service</th>
									<th>Prix unitaire</th>
									<th>Option</th>

								</tr>
							</thead>
							<tbody>
								<?php if($liste):?>
									<?php foreach ($liste as $list): ?>
										<tr>
											<td>
												<strong class="text-info" data-toggle="tooltip" data-placement="top" title="Code Service" >
													<?php echo $list["code_service"]; ?>
												</strong>
											</td>
											<td>
												<?php echo $list["titre"]; ?>
											</td>
											<td>
												<?php echo $list["prix_unitaire"]; ?>
											</td>
											<td>
												<a href="<?= base_url('service/modifier/' . $list['id_service']) ?>"
													class="btn btn-success btn-sm" data-toggle="tooltip"
													data-placement="top" title="Modifier">
													<i class="fa fa-wrench" aria-hidden="true"></i>
												</a>
												<!-- <a href="<?= base_url('delete/service/' . $list['id_service']) ?>"
													class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"
													title="Supprimer"
													onclick="return confirmSwalDelete(<?= $list['id_service'] ?>);">
													<i class="fa fa-trash" aria-hidden="true"></i>
												</a> -->
											</td>
										</tr>

									<?php endforeach ?>
								<?php else :?>
									<td colspan="4" style="text-align:center" class="bg-light">
                                        <p>Aucun Service trouvé...</p>
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
    function confirmSwalDelete(id_service) {
    Swal.fire({
        title: 'Êtes-vous sûr?',
        text: 'Cela va supprimer cet employé et ses tâches et congés associés !',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, supprimer'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= site_url('delete/service/') ?>' + id_service;
        }
    });
    return false;
}
</script>
<?php $this->endsection()?>

<?php $this->section("script")?>
<script>
	$(document).ready(function () {
		setTimeout(function () {
			$('#myDiv').slideUp();
		}, 1000);
	});
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
<script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#myDiv').slideUp();
            }, 1000);
        });
    </script>
<?php $this->endsection() ?>