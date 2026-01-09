<div class="mainHeader">
  <h2>
    <?=$mainHeaderTitle?>
    <?php if(isset($videoPath)){ ?>
      <div class="info-icon" onclick="openVideoModal('<?=$videoPath?>')">
        <i class="acuarela acuarela-Informacion acuarela-24"></i>
      </div>
    <?php } ?>
  </h2>
  <div class="actions">
    <?=$action?>
  </div>
</div>
