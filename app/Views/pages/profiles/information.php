<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
PROFILE - PAGE
<?php $this->endsection() ?>

<?php $this->section("content") ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('/')?>">Acceuil</a></li>
                    <li class="breadcrumb-item active">Information Personnel</li>
                </ol>
            </div>
        </div>
    </div>
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="#activity" data-toggle="tab">Informations Personnels</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Modifier</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <div class="invoice p-3 mb-3">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h4 style="display:flex;justify-content:space-between">
                                        <img src="http://fms.dyndns.info/planing/uploads/logo-atlashost-1.png"
                                            alt="FES MARKETING SERVICE" />
                                        <strong style="color:#A4ADFA">
                                            <?= $listes_emp['nom'] . ' ' . $listes_emp['prenom'] ?>
                                        </strong>
                                        <small class="float-right">
                                            <?php echo date('d/m/Y'); ?>
                                        </small>
                                    </h4>
                                </div>
                            </div>
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">

                                    <address>
                                        <b>Code :</b>
                                        <?= $listes_emp['code_emp'] ?><br>
                                        <b>Email :</b>
                                        <?= $listes_emp['email'] ?>
                                    </address>
                                </div>
                                <div class="col-sm-4 invoice-col">

                                    <address>
                                        <b>Téléphone :</b>
                                        <?= $listes_emp['telephone'] ?><br>
                                        <b>Role :</b>
                                        <?= $listes_emp['role'] ?>
                                    </address>
                                </div>
                                <div class="col-sm-4 invoice-col">

                                    <address>
                                        <b>Date Début :</b>
                                        <?= $listes_emp['date_debut'] ?>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="settings">
                        <form class="form-horizontal" method="post"
                            action="<?= base_url('profile/update/' . $listes_emp['id_emp']) ?>">
                            <?= csrf_field() ?>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label class="form-label">Code Employé <span class="text-danger"></span></label>
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control" type="text" placeholder="Code ..."
                                        value="<?= $listes_emp['code_emp'] ?>" name="codeEmp" readonly>
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label">Email <span class="text-danger"></span></label>
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control" type="email" placeholder="Email ..."
                                        value="<?= $listes_emp['email'] ?>" name="email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label class="form-label">Nom <span class="text-danger"></span></label>
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control" type="text" placeholder="Nom ..."
                                        value="<?= $listes_emp['nom'] ?>" name="nom">
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label">Téléphone <span class="text-danger"></span></label>
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control" type="text" placeholder="Téléphone ..."
                                        value="<?= $listes_emp['telephone'] ?>" name="telephone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label class="form-label">Prénom <span class="text-danger"></span></label>
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control" type="text" placeholder="Prénom"
                                        value="<?= $listes_emp['prenom'] ?>" name="prenom">
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label">Rôle <span class="text-danger"></span></label>
                                </div>
                                <div class="col-sm-3">
                                    <select class="form-control select2" name="role">
                                        <option value="<?= $listes_emp['role'] ?>"<?= ($listes_emp['role'] == 'admin') ? 'selected' : '' ?>>
                                            admin
                                        </option>
                                        <option value="<?= $listes_emp['role'] ?>"<?= ($listes_emp['role'] == 'gestionnaire') ? 'selected' : '' ?>>
                                            Géstionnaire
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
            </div>
        </div>
    </div>
</section>

<?php $this->endsection() ?>