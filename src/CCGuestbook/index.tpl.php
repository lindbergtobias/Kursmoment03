<h2>En gästbok</h2>
<form action="<?=$formAction?>" method='post'>
  <p>
    <label>Meddelande: <br/>
    <textarea name='newEntry' cols='80' rows='8'></textarea></label>
  </p>
  <p>
    <input type='submit' name='doAdd' value='Skicka' />
    <input type='submit' name='doClear' value='Ta bort alla' />
    <input type='submit' name='doCreate' value='Skapa en databastabell' />
  </p>
</form>

<h3>Alla meddelanden:</h3>

<?php foreach($entries as $val):?>
<div style='background-color:#eee;border:1px solid #ccc;margin-bottom:1em;padding:1em;'>
  <p>Tid: <?=$val['created']?></p>
  <p><?=htmlent($val['entry'])?></p>
</div>
<?php endforeach;?>
