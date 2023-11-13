<?php $this->extend('templates/layout') ?>

<?php $this->section('title') ?>
ACTIVITEES LIST - PAGE
<?php $this->endsection() ?>

<?php $this->section('logg') ?>
active
<?php $this->endsection() ?>

<?php $this->section('content') ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Activitées</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
                    <li class="breadcrumb-item active">Activitées Utilisqteurs</li>
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
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Liste de Commerciaux</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="export_btns" style="float: right;margin: 8px 0px 12px 0px;"></div><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table id="myDataTable" class="table myDataTable table-bordered table-striped">
                            <thead>
                            <th>Commercial</th>
                            <th>Magasin</th>
                            <th>Role</th>
                            <th>Identifiant</th>
                            <th style="width: 50%;">Dernière Activité</th>
                            <th class="current-width no-export">Options</th>
                            </thead>
                            <tbody>
                                                            <tr>
                                    <td>Demo Access</td>
                                    <td>
                                        <span class="label label-success" data-toggle="tooltip" data-placement="top" title="Magasin OUED FES ">Magasin OUED FES </span>  
                                    </td>
                                    <td>
                                                                                <span class="label label-info" data-toggle="tooltip" data-placement="top" title="Administrateur">Administrateur</span>                                    </td>
                                    <td>[ <b>demo</b> ]</td>
                                    <td style="width: 50%;">
                                        26/09/2023 10:53<br>Connexion                                    </td>
                                    <td class="current-width no-export">
                                                                                                                        <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/modifier/2" class="btn btn-success rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                                                                                                    </td>
                                </tr>
                                                            <tr>
                                    <td>Simohammed</td>
                                    <td>
                                        <span class="label label-success" data-toggle="tooltip" data-placement="top" title="Magasin OUED FES ">Magasin OUED FES </span>  
                                    </td>
                                    <td>
                                                                                <span class="label label-info" data-toggle="tooltip" data-placement="top" title="Administrateur">Administrateur</span>                                    </td>
                                    <td>[ <b>simo </b> ]</td>
                                    <td style="width: 50%;">
                                        22/09/2023 09:52<br>Connexion                                    </td>
                                    <td class="current-width no-export">
                                                                                                                        <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/modifier/4" class="btn btn-success rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                                                                                                            <form method="post" action="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/supprimer/" id="form_4" style="display:none;">
                                                <input type="hidden" name="id_user" value="4">
                                            </form>
                                            <a href="#" onclick="confirmDelete('form_4')" class="btn btn-danger btn-sm rounded" data-toggle="tooltip" data-placement="top" title="Supprimer">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                                                            </td>
                                </tr>
                                                            <tr>
                                    <td>Compte1</td>
                                    <td>
                                        <span class="label label-success" data-toggle="tooltip" data-placement="top" title="Magasin OUED FES ">Magasin OUED FES </span>  
                                    </td>
                                    <td>
                                                                                <span class="label label-warning" data-toggle="tooltip" data-placement="top" title="Géstionnaire">Géstionnaire</span>                                    </td>
                                    <td>[ <b>compte1</b> ]</td>
                                    <td style="width: 50%;">
                                        01/09/2023 11:54<br>Connexion                                    </td>
                                    <td class="current-width no-export">
                                                                                <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/permission/17" class="btn btn-primary rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Détails">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                                                                                                        <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/modifier/17" class="btn btn-success rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                                                                                                            <form method="post" action="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/supprimer/" id="form_17" style="display:none;">
                                                <input type="hidden" name="id_user" value="17">
                                            </form>
                                            <a href="#" onclick="confirmDelete('form_17')" class="btn btn-danger btn-sm rounded" data-toggle="tooltip" data-placement="top" title="Supprimer">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                                                            </td>
                                </tr>
                                                            <tr>
                                    <td>Commercial</td>
                                    <td>
                                        <span class="label label-success" data-toggle="tooltip" data-placement="top" title="Magasin OUED FES ">Magasin OUED FES </span>  
                                    </td>
                                    <td>
                                                                                <span class="label label-warning" data-toggle="tooltip" data-placement="top" title="Géstionnaire">Géstionnaire</span>                                    </td>
                                    <td>[ <b>commercial</b> ]</td>
                                    <td style="width: 50%;">
                                                                            </td>
                                    <td class="current-width no-export">
                                                                                <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/permission/19" class="btn btn-primary rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Détails">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                                                                                                        <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/modifier/19" class="btn btn-success rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                                                                                                            <form method="post" action="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/supprimer/" id="form_19" style="display:none;">
                                                <input type="hidden" name="id_user" value="19">
                                            </form>
                                            <a href="#" onclick="confirmDelete('form_19')" class="btn btn-danger btn-sm rounded" data-toggle="tooltip" data-placement="top" title="Supprimer">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                                                            </td>
                                </tr>
                                                            <tr>
                                    <td>Compte 1</td>
                                    <td>
                                        <span class="label label-success" data-toggle="tooltip" data-placement="top" title="Magasin OUED FES ">Magasin OUED FES </span>  
                                    </td>
                                    <td>
                                                                                <span class="label label-warning" data-toggle="tooltip" data-placement="top" title="Géstionnaire">Géstionnaire</span>                                    </td>
                                    <td>[ <b>compte</b> ]</td>
                                    <td style="width: 50%;">
                                        19/09/2023 16:08<br>Déconnexion                                    </td>
                                    <td class="current-width no-export">
                                                                                <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/permission/21" class="btn btn-primary rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Détails">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                                                                                                        <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/modifier/21" class="btn btn-success rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                                                                                                            <form method="post" action="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/supprimer/" id="form_21" style="display:none;">
                                                <input type="hidden" name="id_user" value="21">
                                            </form>
                                            <a href="#" onclick="confirmDelete('form_21')" class="btn btn-danger btn-sm rounded" data-toggle="tooltip" data-placement="top" title="Supprimer">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                                                            </td>
                                </tr>
                                                            <tr>
                                    <td>Telaj med</td>
                                    <td>
                                        <span class="label label-success" data-toggle="tooltip" data-placement="top" title="Magasin OUED FES ">Magasin OUED FES </span>  
                                    </td>
                                    <td>
                                                                                <span class="label label-warning" data-toggle="tooltip" data-placement="top" title="Géstionnaire">Géstionnaire</span>                                    </td>
                                    <td>[ <b>med</b> ]</td>
                                    <td style="width: 50%;">
                                        26/09/2023 10:53<br>Déconnexion                                    </td>
                                    <td class="current-width no-export">
                                                                                <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/permission/22" class="btn btn-primary rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Détails">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                                                                                                        <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/modifier/22" class="btn btn-success rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                                                                                                            <form method="post" action="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/supprimer/" id="form_22" style="display:none;">
                                                <input type="hidden" name="id_user" value="22">
                                            </form>
                                            <a href="#" onclick="confirmDelete('form_22')" class="btn btn-danger btn-sm rounded" data-toggle="tooltip" data-placement="top" title="Supprimer">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                                                            </td>
                                </tr>
                                                            <tr>
                                    <td>Test</td>
                                    <td>
                                        <span class="label label-success" data-toggle="tooltip" data-placement="top" title="Magasin OUED FES ">Magasin OUED FES </span>  
                                    </td>
                                    <td>
                                                                                <span class="label label-warning" data-toggle="tooltip" data-placement="top" title="Géstionnaire">Géstionnaire</span>                                    </td>
                                    <td>[ <b>test</b> ]</td>
                                    <td style="width: 50%;">
                                        20/09/2023 10:35<br>Déconnexion                                    </td>
                                    <td class="current-width no-export">
                                                                                <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/permission/23" class="btn btn-primary rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Détails">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                                                                                                        <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/modifier/23" class="btn btn-success rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                                                                                                            <form method="post" action="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/supprimer/" id="form_23" style="display:none;">
                                                <input type="hidden" name="id_user" value="23">
                                            </form>
                                            <a href="#" onclick="confirmDelete('form_23')" class="btn btn-danger btn-sm rounded" data-toggle="tooltip" data-placement="top" title="Supprimer">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                                                            </td>
                                </tr>
                                                            <tr>
                                    <td>Simo_3</td>
                                    <td>
                                        <span class="label label-success" data-toggle="tooltip" data-placement="top" title="Magasin OUED FES ">Magasin OUED FES </span>  
                                    </td>
                                    <td>
                                                                                <span class="label label-warning" data-toggle="tooltip" data-placement="top" title="Géstionnaire">Géstionnaire</span>                                    </td>
                                    <td>[ <b>simo_3</b> ]</td>
                                    <td style="width: 50%;">
                                        21/09/2023 15:43<br>Connexion                                    </td>
                                    <td class="current-width no-export">
                                                                                <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/permission/26" class="btn btn-primary rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Détails">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                                                                                                        <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/modifier/26" class="btn btn-success rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                                                                                                            <form method="post" action="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/supprimer/" id="form_26" style="display:none;">
                                                <input type="hidden" name="id_user" value="26">
                                            </form>
                                            <a href="#" onclick="confirmDelete('form_26')" class="btn btn-danger btn-sm rounded" data-toggle="tooltip" data-placement="top" title="Supprimer">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                                                            </td>
                                </tr>
                                                            <tr>
                                    <td>Salim</td>
                                    <td>
                                        <span class="label label-success" data-toggle="tooltip" data-placement="top" title="Magasin OUED FES ">Magasin OUED FES </span>  
                                    </td>
                                    <td>
                                                                                <span class="label label-warning" data-toggle="tooltip" data-placement="top" title="Géstionnaire">Géstionnaire</span>                                    </td>
                                    <td>[ <b>salim</b> ]</td>
                                    <td style="width: 50%;">
                                        25/09/2023 13:05<br>Déconnexion                                    </td>
                                    <td class="current-width no-export">
                                                                                <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/permission/28" class="btn btn-primary rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Détails">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                                                                                                        <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/modifier/28" class="btn btn-success rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                                                                                                            <form method="post" action="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/supprimer/" id="form_28" style="display:none;">
                                                <input type="hidden" name="id_user" value="28">
                                            </form>
                                            <a href="#" onclick="confirmDelete('form_28')" class="btn btn-danger btn-sm rounded" data-toggle="tooltip" data-placement="top" title="Supprimer">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                                                            </td>
                                </tr>
                                                            <tr>
                                    <td>Dqsfsd</td>
                                    <td>
                                        <span class="label label-success" data-toggle="tooltip" data-placement="top" title=" MAGAZIN MERJA "> MAGAZIN MERJA </span>  
                                    </td>
                                    <td>
                                                                                <span class="label label-warning" data-toggle="tooltip" data-placement="top" title="Géstionnaire">Géstionnaire</span>                                    </td>
                                    <td>[ <b>sdfsdf</b> ]</td>
                                    <td style="width: 50%;">
                                                                            </td>
                                    <td class="current-width no-export">
                                                                                <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/permission/14" class="btn btn-primary rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Détails">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                                                                                                        <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/modifier/14" class="btn btn-success rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                                                                                                            <form method="post" action="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/supprimer/" id="form_14" style="display:none;">
                                                <input type="hidden" name="id_user" value="14">
                                            </form>
                                            <a href="#" onclick="confirmDelete('form_14')" class="btn btn-danger btn-sm rounded" data-toggle="tooltip" data-placement="top" title="Supprimer">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                                                            </td>
                                </tr>
                                                            <tr>
                                    <td>Compte 2</td>
                                    <td>
                                        <span class="label label-success" data-toggle="tooltip" data-placement="top" title=" MAGAZIN MERJA "> MAGAZIN MERJA </span>  
                                    </td>
                                    <td>
                                                                                <span class="label label-warning" data-toggle="tooltip" data-placement="top" title="Géstionnaire">Géstionnaire</span>                                    </td>
                                    <td>[ <b>compte 2</b> ]</td>
                                    <td style="width: 50%;">
                                                                            </td>
                                    <td class="current-width no-export">
                                                                                <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/permission/18" class="btn btn-primary rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Détails">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                                                                                                        <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/modifier/18" class="btn btn-success rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                                                                                                            <form method="post" action="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/supprimer/" id="form_18" style="display:none;">
                                                <input type="hidden" name="id_user" value="18">
                                            </form>
                                            <a href="#" onclick="confirmDelete('form_18')" class="btn btn-danger btn-sm rounded" data-toggle="tooltip" data-placement="top" title="Supprimer">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                                                            </td>
                                </tr>
                                                            <tr>
                                    <td>Simohammed2</td>
                                    <td>
                                        <span class="label label-success" data-toggle="tooltip" data-placement="top" title=" MAGAZIN MERJA "> MAGAZIN MERJA </span>  
                                    </td>
                                    <td>
                                                                                <span class="label label-warning" data-toggle="tooltip" data-placement="top" title="Géstionnaire">Géstionnaire</span>                                    </td>
                                    <td>[ <b>Simohammed</b> ]</td>
                                    <td style="width: 50%;">
                                        22/09/2023 09:51<br>Déconnexion                                    </td>
                                    <td class="current-width no-export">
                                                                                <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/permission/24" class="btn btn-primary rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Détails">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                                                                                                        <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/modifier/24" class="btn btn-success rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                                                                                                            <form method="post" action="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/supprimer/" id="form_24" style="display:none;">
                                                <input type="hidden" name="id_user" value="24">
                                            </form>
                                            <a href="#" onclick="confirmDelete('form_24')" class="btn btn-danger btn-sm rounded" data-toggle="tooltip" data-placement="top" title="Supprimer">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                                                            </td>
                                </tr>
                                                            <tr>
                                    <td>Simo_2</td>
                                    <td>
                                        <span class="label label-success" data-toggle="tooltip" data-placement="top" title=" MAGAZIN MERJA "> MAGAZIN MERJA </span>  
                                    </td>
                                    <td>
                                                                                <span class="label label-warning" data-toggle="tooltip" data-placement="top" title="Géstionnaire">Géstionnaire</span>                                    </td>
                                    <td>[ <b>simo_2</b> ]</td>
                                    <td style="width: 50%;">
                                        22/09/2023 09:52<br>Connexion                                    </td>
                                    <td class="current-width no-export">
                                                                                <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/permission/25" class="btn btn-primary rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Détails">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                                                                                                        <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/modifier/25" class="btn btn-success rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                                                                                                            <form method="post" action="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/supprimer/" id="form_25" style="display:none;">
                                                <input type="hidden" name="id_user" value="25">
                                            </form>
                                            <a href="#" onclick="confirmDelete('form_25')" class="btn btn-danger btn-sm rounded" data-toggle="tooltip" data-placement="top" title="Supprimer">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                                                            </td>
                                </tr>
                                                            <tr>
                                    <td>Ahmed</td>
                                    <td>
                                        <span class="label label-success" data-toggle="tooltip" data-placement="top" title=" MAGAZIN MERJA "> MAGAZIN MERJA </span>  
                                    </td>
                                    <td>
                                                                                <span class="label label-warning" data-toggle="tooltip" data-placement="top" title="Géstionnaire">Géstionnaire</span>                                    </td>
                                    <td>[ <b>ahmed</b> ]</td>
                                    <td style="width: 50%;">
                                        25/09/2023 11:24<br>Déconnexion                                    </td>
                                    <td class="current-width no-export">
                                                                                <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/permission/27" class="btn btn-primary rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Détails">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                                                                                                        <a href="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/modifier/27" class="btn btn-success rounded btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                                                                                                            <form method="post" action="http://fms.dyndns.info/demo/gestion_new_multi/index.php/administration/user/supprimer/" id="form_27" style="display:none;">
                                                <input type="hidden" name="id_user" value="27">
                                            </form>
                                            <a href="#" onclick="confirmDelete('form_27')" class="btn btn-danger btn-sm rounded" data-toggle="tooltip" data-placement="top" title="Supprimer">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                                                            </td>
                                </tr>
                                                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<?php $this->endsection() ?>