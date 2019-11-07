$(document).ready(function() {
var iCnt = 0;

// Crear un elemento div añadiendo estilos CSS
var cont = $(document.createElement('div')).css({
padding: '5px', margin: '0px', width: '100%', border: '1px dashed',
borderTopColor: '#999', borderBottomColor: '#999',
borderLeftColor: '#999', borderRightColor: '#999'
});
 
$('#btAdd').click(function() {
if (iCnt <= 99) {
 
iCnt = iCnt + 1;
 
// Añadir caja de texto.
$(cont).append('<input type="text" class="form-control" list="ciudades" style="display: inline;width: 50%;" id="ciudad" onchange="getIdCiudad(this)" required placeholder="Ciudad ' + iCnt + '" /><input type="hidden" id="id_ciudad[]" name="id_ciudad[]" value=""/><input type="number" class="form-control" style="display: inline;width: 50%;" name="distancia[]" value="0" required placeholder="Distancia en kms" />');
 
$('#main').after(cont);
}
else { //se establece un limite para añadir elementos, 100 es el limite
 
$(cont).append('<label>Limite Alcanzado</label>');
$('#btAdd').attr('class', 'bt-disable');
$('#btAdd').attr('disabled', 'disabled');
 
}
});
 
$('#btRemove').click(function() { // Elimina un elemento por click
if (iCnt != 0) { $('#tb' + iCnt).remove(); iCnt = iCnt - 1; }
 
if (iCnt == 0) { $(cont).empty();
 
$(cont).remove();
$('#btSubmit').remove();
$('#btAdd').removeAttr('disabled');
$('#btAdd').attr('class', 'bt')
 
}
});
 
$('#btRemoveAll').click(function() { // Elimina todos los elementos del contenedor
 
$(cont).empty();
$(cont).remove();
$('#btAdd').removeAttr('disabled');
$('#btAdd').attr('class', 'bt');
 
});
});
 
