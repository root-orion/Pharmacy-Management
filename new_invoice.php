<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>New Invoice</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script src="bootstrap/js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="shortcut icon" href="images/icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sidenav.css">
    <link rel="stylesheet" href="css/home.css">
    <script src="js/suggestions.js"></script>
    <script src="js/add_new_invoice.js"></script>
    <script src="js/manage_invoice.js"></script>
    <script src="js/validateForm.js"></script>
    <script src="js/restrict.js"></script>
  </head>
  <body>
    <div id="add_new_customer_model">
      <div class="modal-dialog">
      	<div class="modal-content">
      		<div class="modal-header" style="background-color: #ff5252; color: white">
            <div class="font-weight-bold">Ajouter nouveau client</div>
      			<button class="close" style="outline: none;" onclick="document.getElementById('add_new_customer_model').style.display = 'none';"><i class="fa fa-close"></i></button>
      		</div>
      		<div class="modal-body">
            <?php
              include('sections/add_new_customer.html');
            ?>
      		</div>
      	</div>
      </div>
    </div>
    <!-- including side navigations -->
    <?php include("sections/sidenav.html"); ?>

    <div class="container-fluid">
      <div class="container">

        <!-- header section -->
        <?php
          require "php/header.php";
          createHeader('clipboard', 'Facture', 'Enregistrer une nouvelle facture');
        ?>
        <!-- header section end -->

        <!-- form content -->
        <div class="row">
          <!-- customer details content -->
          <div class="row col col-md-12">
            <div class="col col-md-3 form-group">
              <label class="font-weight-bold" for="customers_name">Nom client :</label>
              <input id="customers_name" type="text" class="form-control" placeholder="Nom" name="customers_name" onkeyup="showSuggestions(this.value, 'customer');">
              <code class="text-danger small font-weight-bold float-right" id="customer_name_error" style="display: none;"></code>
              <div id="customer_suggestions" class="list-group position-fixed" style="z-index: 1; width: 18.30%; overflow: auto; max-height: 200px;"></div>
            </div>
            <div class="col col-md-3 form-group">
              <label class="font-weight-bold" for="customers_address">Adresse :</label>
              <input id="customers_address" type="text" class="form-control" name="customers_address" placeholder="Adresse" disabled>
            </div>
            <div class="col col-md-2 form-group">
              <label class="font-weight-bold" for="invoice_number">No Facture :</label>
              <input id="invoice_number" type="text" class="form-control" name="invoice_number" placeholder="No Facture" disabled>
            </div>
            <div class="col col-md-2 form-group">
              <label class="font-weight-bold" for="">Methode de paiement :</label>
              <select id="payment_type" class="form-control">
              	<option value="1">Cash </option>
              	<option value="2">Carte </option>
                <option value="3">Virement</option>
              </select>
            </div>
            <div class="col col-md-2 form-group">
               <label class="font-weight-bold" for="">Date :</label>
              <input type="date" class="datepicker form-control hasDatepicker" id="invoice_date" value='<?php echo date('Y-m-d'); ?>' onblur="checkDate(this.value, 'date_error');">
              <code class="text-danger small font-weight-bold float-right" id="date_error" style="display: none;"></code>
            </div>
          </div>
          <!-- customer details content end -->

          <!-- new user button -->
          <div class="row col col-md-12">
            <div class="col col-md-2 form-group">
              <button class="btn btn-primary form-control" onclick="document.getElementById('add_new_customer_model').style.display = 'block';">Nouveau client</button>
            </div>
            <div class="col col-md-1 form-group"></div>
            <div class="col col-md-2 form-group">
              <label class="font-weight-bold" for="customers_contact_number">Contact :</label>
              <input id="customers_contact_number" type="number" class="form-control" name="customers_contact_number" placeholder="Contact " disabled>
            </div>
          </div>
          <!-- closing new user button -->

          <div class="col col-md-12">
            <hr class="col-md-12" style="padding: 0px; border-top: 3px solid  #02b6ff;">
          </div>

          <!-- add medicines -->
          <div class="row col col-md-12">
            <div class="row col col-md-12 font-weight-bold">
              <div class="col col-md-2">Designation</div>
              <div class="col col-md-2">Code</div>
              <div class="col col-md-1">Qte en stock</div>
              <div class="col col-md-1"> Date Exp</div>
              <div class="col col-md-1">Quantite</div>
              <div class="col col-md-1">PVM</div>
              <div class="col col-md-1">Remise (%)</div>
              <div class="col col-md-1">Total</div>
              <div class="col col-md-2">Actions</div>
            </div>
          </div>
          <div class="col col-md-12">
            <hr class="col-md-12" style="padding: 0px; border-top: 2px solid  #02b6ff;">
          </div>

          <div class="row col col-md-12 " id="invoice_medicine_list_div">
            <script> addRow(); getInvoiceNumber(); </script>
          </div>
          <!-- end medicines -->

          <div class="row col col-md-12">
            <div class="col col-md-6 form-group"></div>
            <div class="col col-md-2 form-group float-right">
              <label class="font-weight-bold" for="">Total :</label>
              <input type="text" class="form-control" value="0" id="total_amount" disabled>
            </div>
            <div class="col col-md-2 form-group float-right">
              <label class="font-weight-bold" for="">Total Remise :</label>
              <input type="text" class="form-control" value="0" id="total_discount" disabled>
            </div>
            <div class="col col-md-2 form-group float-right">
              <label class="font-weight-bold" for="">Total Net :</label>
              <input type="text" class="form-control" value="0" id="net_total" disabled>
            </div>
          </div>

          <div class="col col-md-12">
            <hr class="col-md-12" style="padding: 0px;">
          </div> 

          <div class="row col col-md-12">
            <div id="save_button" class="col col-md-2 form-group float-right">
              <label class="font-weight-bold" for=""></label>
              <button class="btn btn-success form-control font-weight-bold" onclick="addInvoice();">Enregistrer</button>
            </div>
            <div id="new_invoice_button" class="col col-md-2 form-group float-right"  style="display: none;">
              <label class="font-weight-bold" for=""></label>
              <button class="btn btn-primary form-control font-weight-bold" onclick="location.reload();;">Nouvelle facture</button>
            </div>
            <div id="print_button" class="col col-md-2 form-group float-right" style="display: none;">
              <label class="font-weight-bold" for=""></label>
              <button class="btn btn-warning form-control font-weight-bold" onclick="printInvoice(document.getElementById('invoice_number').value);">Imprimer</button>
            </div>
            <div class="col col-md-4 form-group"></div>
            <div class="col col-md-2 form-group float-right">
              <label class="font-weight-bold" for="">Montant paye :</label>
              <input type="text" class="form-control" name="total_discount" onkeyup="getChange(this.value);">
            </div>
            <div class="col col-md-2 form-group float-right">
              <label class="font-weight-bold" for="">Monnaie:</label>
              <input type="text" class="form-control" id="change_amt" disabled>
            </div>
          </div>

          <div id="invoice_acknowledgement" class="col-md-12 h5 text-success font-weight-bold text-center" style="font-family: sans-serif;"</div>

        </div>
        <!-- form content end -->
        <hr style="border-top: 2px solid #ff5252;">
      </div>
    </div>
  </body>
</html>
