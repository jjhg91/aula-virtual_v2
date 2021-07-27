class ValidarFormulario {
	constructor(formulario){
		this.formulario = formulario;
		this.inputs = document.querySelectorAll('#add__periodo, #add__lapso,#add__estatus');
		this.expresiones = {
			periodo: /^(\d{4})-(\d{4})$/, // 4 numero un - y 4 numeros
		}
		this.campos = {
			periodo: false
		}

		this.recorreInputs();
		this.sendFormulario();
	}

	recorreInputs() {
		
		this.inputs.forEach( (input) => {
			input.addEventListener('keyup', event => { this.validarFormulario(event) } );
			input.addEventListener('blur', event => { this.validarFormulario(event) } );
			input.addEventListener('change', event => { this.validarFormulario(event) } );
		});
	}

	validarFormulario(e) {
		switch (e.target.name) {
			case "add__periodo":
				this.validarCampo(this.expresiones.periodo, e.target, 'periodo');
				break;
		}
	}

	validarCampo(expresion, input, campo) {
		if ( expresion.test(input.value) ) {
			input.classList.remove('incorrecto');
			input.classList.add('correcto');
			let grupo = input.parentNode;
			grupo.querySelector('.formulario__input-error').classList.remove('formulario__input-error-activo');
			this.campos[campo] = true;
		}else{
			input.classList.remove('correcto');
			input.classList.add('incorrecto');
			let grupo = input.parentNode;
			grupo.querySelector('.formulario__input-error').classList.add('formulario__input-error-activo');
			this.campos[campo] = false;
		}
	}

	
	sendFormulario(){
		const formulario = this.formulario;
		formulario.addEventListener('submit', (e) => {
			e.preventDefault();
			if (this.campos.periodo ) {
				let btnSubmit = document.querySelector('#btn__add');
				btnSubmit.disabled = true;
				

				const formData = new FormData();
				formData.append('add__periodo', this.inputs[1].value);
				formData.append('add__lapso',this.inputs[2].value);
				formData.append('add__estatus',this.inputs[3].value);

				let direccion = `${URL}admin/periodo/`;
				let xmlhttp = new XMLHttpRequest();
				
				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
						// TODO FUE CORRECTO
						let datos = JSON.parse(xmlhttp.response);
						if ( datos.status == true ) {


					
							let tbody = document.querySelector('tbody');
							let errores = document.querySelector('.errores');
							let nuevo = document.createElement('tr');
							nuevo.className = 'periodo';
							nuevo.dataset.periodo =  datos.json.id;

							console.log(datos.json.periodo);
							nuevo.innerHTML += `
									<td  class="id_periodo">${datos.json.id}</td>
									<td class="periodo">${datos.json.periodo}</td>
									<td class="periodo">${datos.json.lapso}</td>
									<td class="status">${datos.json.estatus}</td>
									<td class="td__btnEditar"><button type="submit" class="btnEditar" data-periodo="${datos.json.id}">EDITAR</button></td>
									<td class="td__btnEliminar"><button type="button" class="btnEliminar" data-periodo="${datos.json.id}">ELIMINAR</button></td>
							`;
							tbody.insertBefore(nuevo,errores.nextSibling)

							
							var mensajeError = document.querySelector('.mensaje__exito');
							mensajeError.innerHTML = '<p>'+datos.respuesta+'</p>';
							mensajeError.classList.add('mensaje__exito-activo');
							mensajeError.scrollIntoView({behavior:'auto',block:'center'});
						} else {
							var mensajeError = document.querySelector('.mensaje__exito');
							mensajeError.innerHTML = '<p>'+datos.respuesta+'</p>';
							mensajeError.classList.add('mensaje__error-activo');
						}
						btnSubmit.disabled = false;
					}
				}

				xmlhttp.upload.addEventListener('progress', (e) => {
					let procentaje = Math.round((e.loaded / e.total) * 100);
					console.log (procentaje);
				});

				xmlhttp.addEventListener('load', () => {
					console.log('completado');
				});

				xmlhttp.open('POST', direccion);
				xmlhttp.send(formData);
			}else{
				let mensajeError = document.querySelector('.mensaje__error');
				mensajeError.innerHTML = '<p>No se puedo guardar, por favor revise todo los campos y verifique que no tengan ningun error</p>';
				mensajeError.classList.add('mensaje__error-activo');
			}
		});
	}

}

class ValidarFormularioEditar  extends ValidarFormulario{
	constructor(formulario) {
		super(formulario)
		this.inputs = document.querySelectorAll('#edit__periodo, #edit__lapso,#edit__estatus, #edit__id_periodo');
		console.log(this.inputs[1].value)
		this.campos = {
			periodo: true
		}
		this.recorreInputs();
	}

	recorreInputs() {
		this.inputs.forEach( (input) => {
			input.addEventListener('keyup', event => { this.validarFormulario(event) } );
			input.addEventListener('blur', event => { this.validarFormulario(event) } );
			input.addEventListener('change', event => { this.validarFormulario(event) } );
		});
	}

	validarFormulario(e) {
		switch (e.target.name) {
			case "edit__periodo":
				this.validarCampo(this.expresiones.periodo, e.target, 'periodo');
				break;
		}
	}


	sendFormulario() {
		const formulario = this.formulario;
		formulario.addEventListener('submit', (e) => {

			e.preventDefault();
			if ( this.campos.periodo ) {
				console.log('aqui')
				let btnSubmit = document.querySelector('#btn__edit');
				btnSubmit.disabled = true;



				// const formData = new FormData();
				// formData.append('edit__periodo', this.inputs[1].value);
				// formData.append('edit__estatus',this.inputs[2].value);
				
				const formData = JSON.stringify({
					edit__periodo : this.inputs[2].value,
					edit__lapso : this.inputs[3].value,
					edit__estatus : this.inputs[4].value
				});


				let direccion = `${URL}admin/periodo/${this.inputs[1].value}`;
				let xmlhttp = new XMLHttpRequest();

				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
						// TODO FUE CORRECTO
						let datos = JSON.parse(xmlhttp.response);
						if ( datos.status == true ) {

							let tr = e.target.parentNode;

							tr.innerHTML = `
								<td class="id_periodo">${datos.json.id}</td>
								<td class="periodo">${datos.json.periodo}</td>
								<td class="lapso">${datos.json.lapso}</td>
								<td class="status">${datos.json.estatus}</td>
								<td class="td__btnEditar"><button type="submit" class="btnEditar" data-periodo="${datos.json.id}">EDITAR</button></td>
								<td class="td__btnEliminar"><button type="button" class="btnEliminar" data-periodo="${datos.json.id}">ELIMINAR</button></td>
							`;
						}
						btnSubmit.disabled = false;
					}
				}
				xmlhttp.upload.addEventListener('progress', (e) => {
					let procentaje = Math.round((e.loaded / e.total) * 100);
					console.log (procentaje);
				});

				xmlhttp.addEventListener('load', () => {
					console.log('completado');
				});

				xmlhttp.open('PUT', direccion);
				xmlhttp.send(formData);
			}
			
		});

	}
}


class UI {
	constructor(){

	}


	editContenido(e) {
		// validarFormularioEditar.setiarFormulario();
		// validarFormularioEditar.recorreInputs();

		const tr = e.target.parentNode.parentNode
		const idPeriodo = tr.querySelector('.id_periodo');
		const periodo = tr.querySelector('.periodo');
		const lapso = tr.querySelector('.lapso');
		const status = tr.querySelector('.status');
		const btnEditar = tr.querySelector('.td__btnEditar');
		const btnEliminar = tr.querySelector('.td__btnEliminar');

		let id = idPeriodo.innerHTML;
		let p = periodo.innerHTML;
		let l = lapso.innerHTML;
		let s = status.innerHTML;

console.log(l)
		tr.innerHTML = `
			<form id="edit__periodo" name="edit__periodo" enctype="multipart/form-data">
				<td class="id_periodo">
					<div class="inputs">
						<input id="edit__id_periodo" type="text" placeholder="CODIGO ID" disabled='true' value="${id}">
						<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
					</div>
				</td>
				<td class="periodo">
					<div class="inputs">
						<input id="edit__periodo" name="edit__periodo" type="text" placeholder="año inicial - año finalizar" value="${p}">
						<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
					</div>
				</td>
				<td class="lapso">
					<div class="inputs">
						<select id="edit__lapso">
							<option value="1" ${(l === '1')? 'selected="true"':''}>1 lapso</option>
							<option value="2" ${(l === '2')? 'selected="true"':''}>2 lapso</option>
							<option value="3" ${(l === '3')? 'selected="true"':''}>3 lapso</option>
						</select>
						<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
					</div>
				</td>
				<td class="status">
					<div class="inputs">
						<select id="edit__estatus">
							<option value="2" ${(s === 'Desactivado')? 'selected="true"':''}>desabilitado</option>
							<option value="1" ${(s === 'Activo')? 'selected="true"':''}>activo</option>
						</select>
						<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
					</div>
				</td>
				<td class="td__btnEditar">
					<button type="submit" form="edit__periodo" id="btn__edit">GUARDAR</button>
				</td>
				<td class="td__btnEliminar">
					<button type="button" id="btn__cancelar">CANCELAR</button>
				</td>
			</form>
		`;

		
		const editFormulario = document.getElementById('edit__periodo');
		const validarFormularioEditar = new ValidarFormularioEditar(editFormulario);

		

		let btnCancelar = tr.querySelector('#btn__cancelar');

		btnCancelar.addEventListener('click', () => {
			tr.innerHTML = `
				<td class="id_periodo">${id}</td>
				<td class="periodo">${p}</td>
				<td class="status">${l}</td>
				<td class="status">${s}</td>
				<td class="td__btnEditar"><button class="btnEditar" data-periodo="${id}">EDITAR</button></td>
				<td class="td__btnEliminar"><button class="btnEliminar" data-periodo="${id}">ELIMINAR</button></td>
			`;
			

		});
		
		// validarFormularioEditar.inputs.forEach( input => {
		// 	switch (input.name) {
		// 		case 'title':
		// 			input.value = titulo;
		// 			break;
		// 		case 'descripcion':
		// 			let editarDescripcion = document.querySelector('#editor__edit > .ql-editor');
		// 			editarDescripcion.innerHTML = descripcion;
		// 			input.value = descripcion;
		// 			break;
		// 		case 'blog':
		// 			input.value = e.target.dataset.blog;
		// 			break;
				
		// 	}
		// });


		// btnCerrar.addEventListener('click', () => {
		// 	modalEditar.style.display = 'none';
		// });
		// flex.addEventListener('click', (e) => {
		// 	if ( e.target == flex) {
		// 		modalEditar.style.display = 'none';
		// 	}
			
		// });

	}

	deleteContenido(e) {
		let periodo = e.target.dataset.periodo;

		let eliminar = confirm('Deseas eliminar el periodo?');
		if( eliminar ) {
			let direccion = `${URL}admin/periodo/${periodo}`;
			let xmlhttp = new XMLHttpRequest();

			xmlhttp.onreadystatechange = function() {
				if ( this.readyState == 4 && this.status == 200 ) {
					// TODO FUE CORRECTO
					let datos = JSON.parse(xmlhttp.response);
					if ( datos.status == true ) {
						let tbody = e.target.parentNode.parentNode.parentNode;
						let periodoEliminar = e.target.parentNode.parentNode;
						tbody.removeChild(periodoEliminar);

					}else{
						alert('El periodo no se pudo eliminar, Compruebe su conexion a internet');
					}
				}
			}

			xmlhttp.open('DELETE', direccion);
			xmlhttp.send();
		}
	}

}



const ui = new UI();

// const editFormulario = document.getElementById('edit__blog');
// const validarFormularioEditar = new ValidarFormularioEditar(editFormulario);

const addFormulario = document.getElementById('add__periodo');
const periodos = document.querySelector('.table');

validarFormulario = new ValidarFormulario(addFormulario);


periodos.addEventListener('click', (event) => {

	switch (event.target.classList[0]) {
		case 'btnEliminar':
			ui.deleteContenido(event);
			break;
		case 'btnEditar':
			ui.editContenido(event);
			break;
	}
})