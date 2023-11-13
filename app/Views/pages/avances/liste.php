<?php $this->extend('templates/layout') ?>

<!-- titre du page -->
<?php $this->section('title') ?>
AVANCE CLIENT - PAGE
<?php $this->endsection() ?>

<?php $this->section('client') ?>
active
<?php $this->endsection() ?>
<?php $this->section('avance') ?>
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
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Acceuil</a></li>
                    <li class="breadcrumb-item active">Avances Clients</li>
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
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info card-solid">
                <div class="card-header with-border">
                    <h3 class="card-title">Période</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form method="get" action="<?= base_url('client/avance') ?>">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Entre Le :</label>
                                    <input type="date" class="form-control" name="date_debut" value="<?= $debut ?>"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Et Le :</label>
                                    <input type="date" class="form-control" name="date_fin" value="<?= $fin ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <button class="btn btn-primary" style="width:100%">
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
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning card-solid">
                <div class="card-header with-border">
                    <h3 class="card-title">Historique d'avances de clients</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <a href="<?= base_url('client/avance/ajouter')?>"
                                class="btn btn-primary" style="width:100%;">
                                <i class="fa fa-plus"></i> &nbsp; Nouvelle Avance
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('client/avance/ajouterRe')?>"
                                class="btn btn-info" style="width:100%;">
                                <i class="fa fa-undo"></i> &nbsp; Nouveau Retour
                            </a>
                        </div>
                        <div class="col-md-6">
                            <div id="export_btns" style="float: right;margin: 8px 0px 12px 0px;"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table id="example1" class="table myDataTable table-bordered table-striped text-center">
                                <thead>
                                    <th>Date</th>
                                    <th>Commercial</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Mode de Paiement</th>
                                    <th>Description</th>
                                    <th class="current-width no-export">Options</th>
                                </thead>
                                <tbody>
                                    <?php if($avances):?>
                                        <?php foreach($avances as $avance):?>
                                            <tr>
                                                <td>
                                                    <?= $avance['date_avance']?>
                                                </td>
                                                <td>
                                                    <span class="badge <?= $avance['role']=='admin' ? 'bg-success' : 'bg-warning' ?>" data-toggle="tooltip" data-placement="top" title="<?= $avance['role']=='admin'?'admin':'géstionnaire' ?>">
                                                        <?= $avance['nom']?> <?= $avance['prenom']?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('client/details/commande/'.$avance['id_client'])?>" data-toggle="tooltip" data-placement="top" title="Voir Details De Ce Client">
                                                        <strong><?= $avance['societe']?></strong>
                                                    </a>
                                                </td>
                                                <td data-sorDHHDSHDHDHASDAAHAHt="2000">
                                                    <strong><?= $avance['montant']?></strong> <small>DH</small>
                                                    <br> <span class="text-primary">( <?= $avance['status'] == 'avance' ? "Avance" : "Retour D'avance" ?> )</span>
                                                </td>
                                                <td>
                                                    <?php if($avance['mode_pay'] == 'espece'):?>
                                                        Espèce
                                                    <?php elseif($avance['mode_pay'] == 'cheque'):?>
                                                        Chèque
                                                    <?php elseif($avance['mode_pay'] == 'virement'):?>
                                                        Virement Bancaifa-rotate-90
                                                    <?php elseif($avance['mode_pay'] == 'effet'):?>
                                                        Effet
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                    <?= $avance['description'] ? $avance['description'] : 'Aucune Description...' ?>
                                                </td>
                                                <td class="current-width no-export">
                                                    
                                                    <a href="<?= base_url('avance/delete/' . $avance['id_avance']) ?>"
														class="btn btn-danger btn-sm rounded" data-toggle="tooltip" data-placement="top"
														title="Supprimer"
														onclick="return confirmSwalDelete(<?= $avance['id_avance'] ?>);">
														<i class="fa fa-trash" aria-hidden="true"></i>
													</a>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                    <?php else:?>
                                        <tr>
                                            <td colspan="10" style="text-align:center" class="bg-light">
										        <p>Aucune Avance trouvée...</p>
									        </td>
                                        </tr>
                                    <?php endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div id="myModalImage" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body" style="text-align: center;">
                    <img style="border: 2px solid black; max-width: 100%;" src="" />
                </div>
            </div>

        </div>
    </div>

</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	function confirmSwalDelete(id_avance) {
		Swal.fire({
			title: 'Êtes-vous sûr?',
			text: 'Cela va supprimer cette Avance !',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Oui, supprimer'
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = '<?= site_url('avance/delete/') ?>' + id_avance;
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
</script>
<?php $this->endsection() ?>