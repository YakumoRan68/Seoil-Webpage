<?php if (isset($results['errorMessage'])) { ?>
  <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>

<?php if (isset($results['statusMessage'])) { ?>
  <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
<?php } ?>

<h2 class = "page_name"><?php echo getCategoryName($_GET['location'])[1] ?></h2>