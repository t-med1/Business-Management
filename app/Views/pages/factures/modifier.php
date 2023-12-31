<?php $this->extend('templates/layout') ?>

<!-- titre du page -->
<?php $this->section('title') ?>
MODIFIER FACTURE - PAGE
<?php $this->endsection() ?>


<?php $this->section('facture') ?>
active
<?php $this->endsection() ?>

<!-- Le contenue du page home -->
<?php $this->section('content') ?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Facture</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
          <li class="breadcrumb-item active">Modifier Facture</li>
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
      <h3 class="card-title">Modifier Facture</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <form method="post" action="<?= base_url('facture/update/'.$facture['id_facture'])?>">
      <?= csrf_field() ?>
        <div class="row">
          <div class="mb-5 col-sm-3">
            <label for="ref" class="form-label">Numéro de Facture</label>
            <input type="text" class="form-control" name="id_facture" id="id_facture"
              value="<?= $facture['id_facture'] ?>" readonly>

          </div>
          <div class="mb-5 col-sm-3">
            <label for="ref" class="form-label">Numéro de DU Devis</label>
            <input class="form-control" value="<?= $devis['id_devis'] ?>" name="id_devis" readonly>
          </div>
          <div class="mb-5 col-sm-3">
            <label for="desc" class="form-label">ICE Client</label>
            <input type="text" class="form-control" id="desc" name="descriptif"
              value="<?= ($client['ICE'] == 0 || $client['ICE'] == null) ? "Personne Normale" : $client['ICE'] ?>" readonly>
          </div>
          <div class="mb-5 col-sm-3">
            <label for="saisie" class="form-label">Date de saisie</label>
            <input type="date" class="form-control" id="date_saisie" value="<?= $facture['date_saisie'] ?>"
              name="date_saisie" readonly>
          </div>
        </div>
        <div class="row">

          <div class="mb-5 col-sm-4">
            <label for="nameClient" class="form-label">Nom Du Client</label>
            <input type="text" class="form-control" id="nameClient" value="<?= $client['societe'] ?>" name="societe"
              readonly>
          </div>
          <div class="mb-5 col-sm-4">
            <label for="mail" class="form-label">Email</label>
            <input type="email" class="form-control" id="mail" value="<?= $client['email_client'] ?>" name="email_client"
              readonly>
          </div>
          <div class="mb-5 col-sm-4">
            <label for="numnberPhone" class="form-label">Numero de Telephone</label>
            <input type="text" class="form-control" id="numnberPhone" value="<?= $client['numero_telephone'] ?>"
              name="numnberPhone" readonly>
          </div>

        </div>
        <div class="row">

        </div>
        <div class="row">
          <div class="mb-5 col-sm-4">
            <label for="ttc" class="form-label">Total HT</label>
            <input type="text" class="form-control text-dark" id="ht" value="<?= $devis['total_ht'] ?>" name="ht"
              readonly>
          </div>
          <div class="mb-5 col-sm-4">
            <label for="ttc" class="form-label">Total TTC</label>
            <input type="text" class="form-control text-dark" id="ttc" value="<?= $devis['total_ttc'] ?>" name="ttc"
              readonly>
          </div>
          <div class="mb-5 col-sm-4">
            <label for="montant" class="form-label">Montant Restant</label>
            <input type="number" class="form-control text-dark" id="montantrest" value="<?= $paiment['montant_rest'] ?>"
              name="montantRest" readonly>
          </div>
          <div class="mb-5 col-sm-4">
            <label for="emission" class="form-label">Date Émission <font color="red">*</font></label>
            <input type="date" class="form-control" id="emission" value="<?= $facture['date_emission'] ?>"
              name="emission" required>
          </div>
          <div class="mb-5 col-sm-4">
            <label for="echeance" class="form-label">Date Echéance <font color="red">*</font></label>
            <input type="date" class="form-control" id="echeance" value="<?= $facture['date_echeance'] ?>"
              name="echeance" required>
          </div>
          <div class="mb-5 col-sm-4">
            <label for="montant" class="form-label">Montant payé <font color="red">*</font></label>
            <input type="number" class="form-control" id="montant" value="<?= $paiment['montant_paye'] ?>" name="montant"
              required>
          </div>
        </div>
        <div class="row">
          <div class="mb-5 col-sm-2">
          </div>
          <div class="mb-5 col-sm-4">
            <label for="status" class="form-label">Statut <font color="red">*</font></label>
            <select class="form-control" aria-label="Default select" name="status" id="select-status" required>
              <option value="echue" <?= ($paiment['status'] == 'echue') ? 'selected' : '' ?>>Echue</option>
              <option value="non Echue" <?= ($paiment['status'] == 'non Echue') ? 'selected' : '' ?>>Non Echue</option>
              <option value="encaisse" <?= ($paiment['status'] == 'encaissee') ? 'selected' : '' ?>>Encaissée</option>
            </select>
          </div>
          <div class="mb-5 col-sm-4">
            <label for="statusPaiment" class="form-label">Statut de paiement <font color="red">*</font></label>
            <select class="form-control" aria-label="Default select" name="status_paiment" id="select-option" required>
              <option value="impayee" <?= ($paiment['status_paiment'] == 'impayee') ? 'selected' : '' ?>>Impayée</option>
              <option value="paiement partiel" <?= ($paiment['status_paiment'] == 'paiement partiel') ? 'selected' : '' ?>>
                Paiement Partiel</option>
              <option value="encaissee" <?= ($paiment['status_paiment'] == 'encaissee') ? 'selected' : '' ?>>Encaissee
              </option>
            </select>
          </div>
          <div class="mb-5 col-sm-2">
          </div>
        </div>
        <div class="row">
          <div class="mb-5 col-sm-2">
          </div>
          <div class="mb-5 col-sm-4">
            <label for="statusLitige" class="form-label">Status Litige ? <font color="red">*</font></label>
            <select class="form-control" aria-label="Default select" name="litige" required>
              <option value="normal" <?= ($paiment['status_litige'] == 'normal') ? 'selected' : '' ?>>Normal</option>
              <option value="technique" <?= ($paiment['status_litige'] == 'technique') ? 'selected' : '' ?>>Litige
                Technique</option>
              <option value="commercial" <?= ($paiment['status_litige'] == 'commercial') ? 'selected' : '' ?>>Litige
                Commercial</option>
              <option value="irrecouvrable" <?= ($paiment['status_litige'] == 'irrecouvrable') ? 'selected' : '' ?>>
                Irrécouvrable</option>
            </select>

          </div>
          <div class="mb-5 col-sm-4">
            <label for="datePaiment" class="form-label">Date Paiment <font color="red">*</font></label>
            <input type="date" class="form-control" id="datePaiment" name="datePaiment"
              value="<?= $paiment['date_dernier_paiment'] ?>" required>
          </div>
          <div class="mb-5 col-sm-2">
          </div>
        </div>
        <div class="row" style="display:flex; justify-content:center">
          <div class="col-sm-3">
            <button type="submit" class="btn btn-outline-success btn-block btn-flat" style="border-radius:10px;"><i
            class="fa fa-wrench"></i> Modifier</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<?php $this->endsection() ?>

<?php $this->section("script") ?>
<script>
  var montantInput = document.getElementById("montant");
  var optionSelect1 = document.getElementById("select-option");
  var optionSelect2 = document.getElementById("select-status")
  var montantRest = document.getElementById('montantrest');
  var ttcInput = document.getElementById("ttc");
  var htInput = document.getElementById("ht");

  montantInput.addEventListener("input", function () {
    var montantPaye = parseFloat(montantInput.value);
    // var Rest = parseFloat(montantRest.value);
    var calc = ttcInput.value - montantPaye;
    // mettre à jour la valeur de l'option sélectionnée en fonction de la valeur de l'entrée de montant
    if (montantPaye == '') {
      optionSelect1.value = "impayee";
      optionSelect2.value = "echue";
    } else if (montantPaye == ttcInput.value) {
      optionSelect1.value = "encaissee";
      optionSelect2.value = "encaisse";
    } else if (montantPaye < ttcInput.value && montantPaye.length !== 0) {
      optionSelect1.value = "paiement partiel";
      optionSelect2.value = "non Echue";
    }
    if (montantInput.value !== '') {
      montantRest.value = calc;
    } if (montantInput.value == '') {
      datePaiment.value = '';
    }
  });
</script>

<?php $this->endsection() ?>