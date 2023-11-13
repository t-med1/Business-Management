<?php $this->extend('templates/layout') ?>

<!-- titre du page -->
<?php $this->section('title') ?>
AJOUTER CLIENT - PAGE
<?php $this->endsection() ?>
<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
<?php $this->endsection() ?>
<?php $this->section('client') ?>
active
<?php $this->endsection() ?>
<?php $this->section('clientadd') ?>
active
<?php $this->endsection() ?>

<!-- Le contenue du page home -->
<?php $this->section('content') ?>
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Client</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Acceuil</a></li>
					<li class="breadcrumb-item active">Ajouter Client</li>
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
<section class="content" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
	<div class="row" style="width: 100%;">
		<form method="post" style="width: 100%;" action="<?= base_url('client/save') ?>">
			<?= csrf_field() ?>
			<div class="col-md-11" style="margin-left:3%">
				<div class="card card-info card-solid" style="width: 100%;">
					<div class="card-header with-border">
						<h3 class="card-title">Ajouter Client</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><span class="text-red" data-toggle="tooltip" title="Obligatoire">*</span>
										Code Client :</label>
									<input type="text" class="form-control" name="code_client" value="<?= $ClientCode ?>"
										id="code_client" placeholder="Code Client" readonly required>
								</div>
								<div class="form-group">
									<label>ICE :</label>
									<input type="text" class="form-control" name="ICE" placeholder="ICE">
								</div>
								<div class="form-group">
									<label><span class="text-red" data-toggle="tooltip" title="Obligatoire">*</span> Nom
										de Client :</label>
									<input type="text" class="form-control" name="societe" placeholder="Nom de Client"
										required>
								</div>
								<div class="form-group">
									<label>Contact :</label>
									<input type="text" class="form-control" name="contact" placeholder="Résponsable">
								</div>
								<div class="form-group">
									<label><span class="text-red" data-toggle="tooltip" title="Obligatoire">*</span>
										Commerciaux :</label>
									<select class="form-control select2" id="pays" name="id_emp" required>
										<option value="">Séléctionner Un Commerciale</option>
										<?php foreach ($employeeData as $employe): ?>
											<option value="<?= $employe['id_emp'] ?>" data-toggle="tooltip" title="<?= $employe['role']?>">
												<?= $employe['nom'] ?>
												<?= $employe['prenom'] ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label><span class="text-red" data-toggle="tooltip" title="Obligatoire">*</span> Téléphone :</label>
									<input type="text" class="form-control" name="numero_telephone"
										placeholder="Téléphone" required>
								</div>
								<div class="form-group">
									<label>Email :</label>
									<input type="email" class="form-control" name="email_client" placeholder="Email">
								</div>
								<div class="form-group">
									<label>Adresse :</label>
									<input type="text" class="form-control" name="adresse" placeholder="Adresse">
								</div>
								<div class="form-group">
									<label><span class="text-red" data-toggle="tooltip" title="Obligatoire">*</span>
										Ville :</label>
									<input type="text" class="form-control" name="ville" placeholder="Ville" required>
								</div>
								<div class="form-group">
									<label><span class="text-red" data-toggle="tooltip" title="Obligatoire">*</span> Source :</label>
									<select class="form-control select2" id="pays" name="source" required>
										<option value="">Séléctionner une source</option>
										<option value="Par Tel">Par Tel</option>
										<option value="Facebook">Facebook</option>
										<option value="Site internet">Site internet</option>
										<option value="Publicite">Publicite</option>
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Description :</label>
									<textarea name="remarque" class="form-control" maxlength="200" rows="3"
										placeholder="Description"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer" style="text-align: center;">
						<button type="submit" style="width: 40%;" class="btn btn-primary">
							<i class="fa fa-save"></i> &nbsp; Enregistrer
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>

</section>
<?php $this->endsection() ?>
<?php $this->section('script') ?>
<script>
	$(function () {
		//Initialize Select2 Elements
		$('.select2').select2()

		//Initialize Select2 Elements
		$('.select2bs4').select2({
			theme: 'bootstrap4'
		})
	})
	$(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
	});
</script>
<?php $this->endsection() ?>