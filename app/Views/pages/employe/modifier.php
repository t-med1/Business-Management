<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
MODIFIER EMPLOYE - PAGE
<?php $this->endsection() ?>
<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
<?php $this->endsection() ?>
<?php $this->section('emp') ?>
active
<?php $this->endsection() ?>

<?php $this->section("content") ?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Commerciales</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Acceuil</a></li>
					<li class="breadcrumb-item active">Modifier Commerciale</li>
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
    <!-- general form elements disabled -->
    <div class="card card-info">
        <div class="card-header bg-success">
            <h3 class="card-title">Modifier Commerciale</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form class="form-horizontal" method="post"
                action="<?= base_url('Commeciale/update/' . $employee['id_emp']) ?>">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="form-label">Code Employé <span class="text-danger"></span></label>
                    </div>
                    <div class="col-sm-3">
                    <input class="form-control" type="text" placeholder="Code ..."
                        value="<?= $employee['code_emp'] ?>" name="codeEmp" readonly>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label">Email <span class="text-danger"></span></label>
                    </div>
                    <div class="col-sm-3">
                        <input class="form-control" type="email" placeholder="Email ..."
                            value="<?= $employee['email'] ?>" name="email">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="form-label">Nom <span class="text-danger"></span></label>
                    </div>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" placeholder="Nom ..."
                            value="<?= $employee['nom'] ?>" name="nom">
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label">Téléphone <span class="text-danger"></span></label>
                    </div>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" placeholder="Téléphone ..."
                            value="<?= $employee['telephone'] ?>" name="telephone">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="form-label">Prénom <span class="text-danger"></span></label>
                    </div>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" placeholder="Prénom"
                            value="<?= $employee['prenom'] ?>" name="prenom">
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label">Rôle <span class="text-danger"></span></label>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="role">
                            <option value="<?= ($employee['role'] == 'admin') ? 'admin' : '' ?>" <?= ($employee['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                            <option value="<?= ($employee['role'] == 'gestionnaire') ? 'gestionnaire' : '' ?>" <?= ($employee['role'] == 'gestionnaire') ? 'selected' : '' ?>>gestionnaire</option>
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-7 ml-sm-auto">
                        <button class="btn btn-outline-success btn-fw" style="border-radius: 100px;"
                            type="submit">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            Modifier
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

    <?php $this->endsection() ?>