class ValidarFormulario {
	constructor(formulario){
		this.formulario = formulario;
		this.inputs = document.querySelectorAll('#edit__cedula');
		this.expresiones = {
			cedula: /^[0-9]{1,10}$/ // numeros de 10 digitos
		}
		this.campos = {
			cedula: false
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
			case "edit__cedula":
				this.validarCampo(this.expresiones.cedula, e.target, 'cedula');
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

	
	sendFormulario() {
		
		const formulario = this.formulario;
		formulario.addEventListener('submit', (e) => {
			

			e.preventDefault();
			
			if ( this.campos.cedula ) {
				
				let btnSubmit = document.querySelector('#btn__edit');
				btnSubmit.disabled = true;

				// const formData = new FormData();
				// formData.append('add__cedula', this.inputs[0].value);
				// formData.append('add__nombre',this.inputs[1].value);
				// formData.append('add__email',this.inputs[2].value);
				// formData.append('add__tlf',this.inputs[3].value);
				let id =  e.target.parentNode.parentNode.dataset.asignatura;

				const formData = JSON.stringify({
					edit__id : id,
					edit__cedula : this.inputs[0].value
				});

				let direccion = `${URL}admin/asignatura/${id}`;
				let xmlhttp = new XMLHttpRequest();

				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
						// TODO FUE CORRECTO
						let datos = JSON.parse(xmlhttp.response);
						if ( datos.status == true ) {

							let tr = e.target.parentNode.parentNode;

							let cedula = tr.querySelector('.cedula');
							let nombre = tr.querySelector('.nombre');
							let boton = tr.querySelector('.td__btnEditar');

							cedula.innerHTML = datos.json.cedula;
							nombre.innerHTML = datos.json.nombre;
							boton.innerHTML = `
								<button type="submit" class="btnEditar" data-asignatura="${datos.json.id}">ASIGNAR <br>PROFESOR</button>
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

		const tr = e.target.parentNode.parentNode
		const cedula = tr.querySelector('.cedula');
		const nombre = tr.querySelector('.nombre');
		const boton = tr.querySelector('.td__btnEditar');

		let ci = cedula.innerHTML;
		let n = nombre.innerHTML;



		cedula.innerHTML = `
			<form id="edit__periodo" name="edit__periodo" enctype="multipart/form-data">
				<div class="inputs">
					<input id="edit__cedula" name="edit__cedula" type="text" placeholder="solo numeros" value="${ci}">
					<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
				</div>
					<div class="grupo__error">
						<div class="mensaje__error">
							<p>No se puedo guardar, por favor revise todo los campos y verifique que no tengan ningun error.</p>
						</div>
					<div class="mensaje__exito">
					</div>
				</div>
			</form>
		`;
		boton.innerHTML = `
			<div class="grupo__botones">
				<button type="submit" form="edit__periodo" id="btn__edit">GUARDAR</button>
				<button type="button" id="btn__cancelar">CANCELAR</button>
			</div>
		`;

		let addFormulario = document.getElementById('edit__periodo');
		let validarFormulario = new ValidarFormulario(addFormulario);

		

		let btnCancelar = boton.querySelector('#btn__cancelar');
		let id = tr.dataset.profesor;
		btnCancelar.addEventListener('click', () => {
			cedula.innerHTML = ci;
			boton.innerHTML = `
				<button type="submit" class="btnEditar" data-asignatura="${tr.dataset.asignatura}">ASIGNAR <br>PROFESOR</button>
			`;
			

		});
		

	}

	deleteContenido(e) {
		let profesor = e.target.dataset.profesor;

		let eliminar = confirm('Deseas eliminar al profesor?');
		if( eliminar ) {
			let direccion = `${URL}admin/profesor/${profesor}`;
			let xmlhttp = new XMLHttpRequest();

			xmlhttp.onreadystatechange = function() {
				if ( this.readyState == 4 && this.status == 200 ) {
					// TODO FUE CORRECTO
					let datos = JSON.parse(xmlhttp.response);
					if ( datos.status == true ) {
						let tbody = e.target.parentNode.parentNode.parentNode;
						let profesorEliminar = e.target.parentNode.parentNode;
						tbody.removeChild(profesorEliminar);

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

const periodos = document.querySelector('.table');




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