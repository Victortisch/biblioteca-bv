num=0;
function crear(ciudad,id_ciudad,distancia) {
  num++;
  fi = document.getElementById('fiel');
  contenedor = document.createElement('div');
  contenedor.id = 'div'+num;
  fi.appendChild(contenedor); 

  ele = document.createElement('input');
  ele.type = 'text';
  ele.name = 'ciudad'+num;
  ele.id = 'ciudad';
  ele.setAttribute('list', 'ciudades');
  ele.className ='form-control';
  ele.style.display ='inline';
  ele.style.width ='44%';
  ele.value=ciudad;
  ele.setAttribute('placeholder','Ciudad '+num);
  ele.setAttribute("required", "");
  ele.onchange = function () {getIdCiudad(this)}
  contenedor.appendChild(ele);

  ele = document.createElement('input');
  ele.type='hidden';
  ele.id='id_ciudad[]';
  ele.name='id_ciudad[]';
  ele.value=id_ciudad;
  contenedor.appendChild(ele);

  ele = document.createElement('input');
  ele.type = 'text';
  ele.name = 'distancia[]';
  ele.className ='form-control';
  ele.style.display ='inline';
  ele.style.width ='44%';
  ele.value=distancia;
  ele.setAttribute('placeholder','Distancia '+num+' en kms.');
  ele.setAttribute("required", "");
  contenedor.appendChild(ele);

  ele = document.createElement('input');
  ele.type = 'button';
  ele.value = 'Borrar';
  ele.className ='form-control';
  ele.name = 'div'+num;
  ele.style.display ='inline';
  ele.style.width ='12%';
  ele.onclick = function () {borrar(this.name)}
  contenedor.appendChild(ele);
}
function borrar(obj) {
  fi = document.getElementById('fiel'); 
  fi.removeChild(document.getElementById(obj));
}
function borrarTodo() {
  for (var i = 1; i <= num; i++) {
    fi = document.getElementById('fiel'); 
    fi.removeChild(document.getElementById('div'+i));
  };
  num=0;
}
