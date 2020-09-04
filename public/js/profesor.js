class ValidarFormulario {
	constructor(formulario){
		this.formulario = formulario;
		this.inputs = document.querySelectorAll('#add__cedula, #add__nombre, #add__email, #add__tlf');
		this.expresiones = {
			cedula: /^[0-9]{1,10}$/, // numeros de 10 digitos
			nombre: /^[A-z .]{1,100}$/, // valida letras mayusculas y minusculas y punto(.) de 1 a 100 caracteres
			email: /^([^@]+@[^@]+\.[a-zA-Z]{2,}){0,}$/, // valida los correos cualquier caracter + @  + caracteres + . caracteres
			tlf: /^[0-9]{0,14}$/ //valida numeros de 12 digitos
		}
		this.campos = {
			cedula: false,
			nombre: false,
			email: true,
			tlf: true
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
			case "add__cedula":
				console.log(e.target.name)
				this.validarCampo(this.expresiones.cedula, e.target, 'cedula');
				break;
			case "add__nombre":
				this.validarCampo(this.expresiones.nombre, e.target, 'nombre');
				break;
			case "add__email":
				this.validarCampo(this.expresiones.email, e.target, 'email');
				break;
			case "add__tlf":
				this.validarCampo(this.expresiones.tlf, e.target, 'tlf');
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
			if ( this.campos.cedula && this.campos.nombre && this.campos.email && this.campos.tlf ) {
				let btnSubmit = document.querySelector('#btn__add');
				btnSubmit.disabled = true;

				const formData = new FormData();
				formData.append('add__cedula', this.inputs[0].value);
				formData.append('add__nombre',this.inputs[1].value);
				formData.append('add__email',this.inputs[2].value);
				formData.append('add__tlf',this.inputs[3].value);

				let direccion = `${URL}admin/profesor/`;
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
							nuevo.dataset.profesor = datos.json.id;

							nuevo.innerHTML += `
								<td class="cedula">${datos.json.cedula}</td>
								<td class="nombre">${datos.json.nombre}</td>
								<td class="email">${datos.json.email}</td>
								<td class="tlf">${datos.json.tlf}</td>
								<td class="td__btnEditar"><button type="submit" class="btnEditar" data-profesor="${datos.json.id}">EDITAR</button></td>
								<td class="td__btnEliminar"><button type="button" class="btnEliminar" data-profesor="${datos.json.id}">ELIMINAR</button></td>
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
		this.inputs = document.querySelectorAll('#edit__cedula, #edit__nombre, #edit__email, #edit__tlf');
		this.campos = {
			cedula: true,
			nombre: true,
			email: true,
			tlf: true
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
			case "edit__cedula":
				this.validarCampo(this.expresiones.cedula, e.target, 'cedula');
				break;
			case "edit__nombre":
				this.validarCampo(this.expresiones.nombre, e.target, 'nombre');
				break;
			case "edit__email":
				this.validarCampo(this.expresiones.email, e.target, 'email');
				break;
			case "edit__tlf":
				this.validarCampo(this.expresiones.tlf, e.target, 'tlf');
				break;
		}
	}


	sendFormulario() {
		const formulario = this.formulario;
		formulario.addEventListener('submit', (e) => {

			e.preventDefault();
			if ( this.campos.cedula && this.campos.nombre && this.campos.email && this.campos.tlf ) {
				console.log('aqui')
				let btnSubmit = document.querySelector('#btn__edit');
				btnSubmit.disabled = true;



				// const formData = new FormData();
				// formData.append('add__cedula', this.inputs[0].value);
				// formData.append('add__nombre',this.inputs[1].value);
				// formData.append('add__email',this.inputs[2].value);
				// formData.append('add__tlf',this.inputs[3].value);
				let id =  e.target.parentNode.dataset.profesor;
				const formData = JSON.stringify({
					edit__cedula : this.inputs[0].value,
					edit__nombre : this.inputs[1].value,
					edit__email: this.inputs[2].value,
					edit__tlf: this.inputs[3].value
				});



				let direccion = `${URL}admin/profesor/${id}`;
				let xmlhttp = new XMLHttpRequest();

				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
						// TODO FUE CORRECTO
						let datos = JSON.parse(xmlhttp.response);
						if ( datos.status == true ) {

							let tr = e.target.parentNode;

							tr.innerHTML = `
								<td class="cedula">${datos.json.cedula}</td>
								<td class="nombre">${datos.json.nombre}</td>
								<td class="email">${datos.json.email}</td>
								<td class="tlf">${datos.json.tlf}</td>
								<td class="td__btnEditar"><button type="submit" class="btnEditar" data-profesor="${datos.json.id}">EDITAR</button></td>
								<td class="td__btnEliminar"><button type="button" class="btnEliminar" data-profesor="${datos.json.id}">ELIMINAR</button></td>
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
		const email = tr.querySelector('.email');
		const tlf = tr.querySelector('.tlf');

		const btnEditar = tr.querySelector('.td__btnEditar');
		const btnEliminar = tr.querySelector('.td__btnEliminar');

		let ci = cedula.innerHTML;
		let n = nombre.innerHTML;
		let em = email.innerHTML;
		let t = tlf.innerHTML;


		tr.innerHTML = `
			<form id="edit__periodo" name="edit__periodo" enctype="multipart/form-data">
				<td>
					<div class="inputs">
						<input id="edit__cedula" name="edit__cedula" type="text" placeholder="solo numeros" value="${ci}">
						<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
					</div>
				</td>
				<td>
					<div class="inputs">
						<input id="edit__nombre" name="edit__nombre" type="text" placeholder="Nombre y Apellido" value="${n}">
						<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
					</div>
				</td>
				<td>
					<div class="inputs">
						<input id="edit__email" name="edit__email" type="text" placeholder="ejemplo@email.com" value="${em}">
						<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
					</div>
				</td>
				<td>
					<div class="inputs">
						<input id="edit__tlf" name="edit__tlf" type="text" placeholder="04169300910" value="${t}">
						<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
					</div>
				</td>
				<td>
					<button type="submit" form="edit__periodo" id="btn__edit">GUARDAR</button>
				</td>
				<td>
					<button type="button" id="btn__cancelar">CANCELAR</button>
				</td>
			</form>
		`;

		
		const editFormulario = document.getElementById('edit__periodo');
		const validarFormularioEditar = new ValidarFormularioEditar(editFormulario);

		

		let btnCancelar = tr.querySelector('#btn__cancelar');
		let id = tr.dataset.profesor;
		btnCancelar.addEventListener('click', () => {
			tr.innerHTML = `
				<td class="cedula">${ci}</td>
				<td class="nombre">${n}</td>
				<td class="email">${em}</td>
				<td class="tlf">${t}</td>
				<td class="td__btnEditar"><button type="submit" class="btnEditar" data-profesor="${id}">EDITAR</button></td>
				<td class="td__btnEliminar"><button type="button" class="btnEliminar" data-profesor="${id}">ELIMINAR</button></td>
			`;
			

		});
		

	}

	deleteContenido(e) {
		let profesor = e.target.dataset.profesor;
		console.log(profesor);

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