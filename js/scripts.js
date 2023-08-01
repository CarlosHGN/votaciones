$(document).ready(function(){
  $('#id_region').on('change',function(){
    var id_region = $(this).val();
    var cadenaID = 'accion=comunas&id_region='+id_region;
    if(id_region){
      $.ajax({
        type:'POST',
        url:'index.php?pg=process_election',
        data: cadenaID,
        success:function(html){
          $('#id_comuna').html(html);
        }
      }); 
    }
  });

  $.ajax({
    type:'POST',
    url:'index.php?pg=process_election',
    data:'accion=regiones',
    success:function(html){
      $('#id_region').html(html);
    }
  });
  
  $.ajax({
    type:'POST',
    url:'index.php?pg=process_election',
    data:'accion=contactos',
    success:function(html){
      $('#datacontacto').html(html);
    }
  });

  $.ajax({
    type:'POST',
    url:'index.php?pg=process_election',
    data:'accion=candidatos',
    success:function(html){
      $('#id_candidato').html(html);
    }
  });
  
  $('#alias').on('focusout', function() {
    var inputVal = $(this).val();
    var regExp = /^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+){6,}$/;
    var mensaje;
    if(regExp.test(inputVal)) {
      var cadenaID = 'accion=alias&dato='+inputVal;
      $.ajax({
        type:'POST',
        url:'index.php?pg=process_election',
        data: cadenaID,
        success:function(html){
          $('#msgalias').html(html);
        }
      });
    } else {
      mensaje = '<span class="text text-danger">El alias debe tener al menos 5 caracteres y un número</span>';
      $('#msgalias').html(mensaje);
    }
  });

  $('#rut').on('focusout', function() {
    var inputVal = $(this).val();
    var rut = inputVal.split('-')[0];
    var dv = inputVal.split('-')[1];
    var mensaje;
    if(!$.isNumeric(rut) || !/^[0-9K]$/.test(dv)) {
      $(this).val('');
      mensaje = '<span class="text text-danger">El valor ingresado no es válido. No cumple con el formato de RUT</span>';
      $('#msgrut').html(mensaje);
    } else {
      var sum = 0;
      var mul = 2;
      for(var i = rut.length - 1; i >= 0; i--) {
          sum = sum + rut.charAt(i) * mul;
          mul = (mul + 1) % 8 || 2;
      }
      var res = 11 - sum % 11;
      if(res === 10) res = 'K';
      if(res === 11) res = '0';
      if(dv.toUpperCase() !== res.toString()) {
        $(this).val('');
        mensaje = '<span class="text text-danger">El valor ingresado no es válido. No cumple con el formato de RUT</span>';
        $('#msgrut').html(mensaje);
      }else{
        cadenaID = 'accion=rut&dato='+rut,
        $.ajax({
          type:'POST',
          url:'index.php?pg=process_election',
          data: cadenaID,
          success:function(html){
            $('#msgrut').html(html);
          }
        });
      }
    }
  });

  $('form').submit(function(event) {
    event.preventDefault();
    var formData = $(this).serializeArray();
    var email = $('#email').val();
    var id_contacto = $('input[name="id_contacto[]"]:checked').length;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var mensaje;
    if (!emailReg.test(email)) {
      mensaje = '<span class="text text-danger">Por favor ingrese un correo electrónico válido</span>';
      $('#msgemail').html(mensaje);
      return false;
    }
    if (id_contacto < 2) {
      mensaje = '<span class="text text-danger">Por favor seleccione al menos dos opciones de "Como se enteró de Nosotros"</span>';
      $('#msgcontacto').html(mensaje);
      return false;
    }
    $.ajax({
      type: 'POST',
      url:'index.php?pg=process_election',
      data: formData,
      encode: true,
      success:function(html){
        $('#msgvotar').html(html);
      }
    });
  });
});
