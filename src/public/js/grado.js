class ValidarFormulario {
	constructor(formulario){
		this.formulario = formulario;
		this.inputs = document.querySelectorAll('#add__grado, #add__seccion, #add__periodo');
		this.expresiones = {
			grado: /^(?!0).*$/, // numeros de 10 digitos
			seccion: /^(?!0).*$/, // valida letras mayusculas y minusculas y punto(.) de 1 a 100 caracteres
			periodo: /^(?!0).*$/, // valida los correos cualquier caracter + @  + caracteres + . caracteres
		}
		this.campos = {
			grado: false,
			seccion: false,
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
		
		switch (e.target.id) {
			case "add__grado":
				this.validarCampo(this.expresiones.grado, e.target, 'grado');
				break;
			case "add__seccion":
				this.validarCampo(this.expresiones.seccion, e.target, 'seccion');
				break;
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
			if ( this.campos.grado && this.campos.seccion && this.campos.periodo ) {
				let btnSubmit = document.querySelector('#btn__add');
				btnSubmit.disabled = true;

				const formData = new FormData();
				formData.append('add__grado', this.inputs[1].value);
				formData.append('add__seccion',this.inputs[2].value);
				formData.append('add__periodo',this.inputs[3].value);

				let direccion = `${URL}admin/grado`;
				let xmlhttp = new XMLHttpRequest();
				
				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
						// TODO FUE CORRECTO
						let datos = JSON.parse(xmlhttp.response);
						console.log(datos)
						if ( datos.status == true ) {


					
							let tbody = document.querySelector('tbody');
							let errores = document.querySelector('.errores');
							let nuevo = document.createElement('tr');
							nuevo.className = 'periodo';
							nuevo.dataset.profesor = datos.json.id;

							nuevo.innerHTML += `
								<td class="educacion">${datos.json.educacion}</td>
								<td class="grado">${datos.json.grado}</td>
								<td class="seccion">${datos.json.seccion}</td>
								<td class="periodo">${datos.json.periodo}</td>
								<td class="td__btnInscritos"><button type="button" class="btnAlumnosInscritos" data-grado="<?= $grado['id_profesorcursogrupo'] ?>">Alumnos Inscitos</button></td>
								<td class="td__btnEliminar"><button type="button" class="btnEliminar" data-grado="">ELIMINAR</button></d>
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
		
		const btnModalPreview = document.getElementById('btnModalPreview');
		const btnCerrar = document.getElementById('btnCerrarPreview');
		const btnInscribir = document.getElementById('btn__inscribir');
		const flex = document.getElementById('flexPreview');
		const modal = document.getElementById('modalPreview');

	

		const previewNumero = document.getElementById('preview__numero');
		const previewArchivos = document.getElementById('preview__archivos');

		var fila = e.target.parentNode.parentNode;
		document.querySelector('#modal__grado').innerHTML = fila.querySelector('.grado').innerHTML;
		document.querySelector('#modal__seccion').innerHTML = fila.querySelector('.seccion').innerHTML;
		modal.style.display = 'block';
		
		const formulario = document.getElementById('ins__form');
		const inputCedula = document.getElementById('ins__cedula');
		inputCedula.value = "";
		inputCedula.classList.remove('correcto');
		inputCedula.classList.remove('incorrecto');
		inputCedula.parentNode.querySelector('.formulario__input-error').classList.remove('formulario__input-error-activo');


		let expresion = {
			cedula: /^[0-9]{7,20}$/
		}
		let campos = {
			cedula: false
		}



		let validar = () => {
			if ( expresion.cedula.test(event.target.value) ) {
				event.target.classList.remove('incorrecto');
				event.target.classList.add('correcto');
				let grupo = event.target.parentNode;
				grupo.querySelector('.formulario__input-error').classList.remove('formulario__input-error-activo');
				campos['cedula'] = true;
			}else{
				event.target.classList.remove('correcto');
				event.target.classList.add('incorrecto');
				let grupo = event.target.parentNode;
				grupo.querySelector('.formulario__input-error').classList.add('formulario__input-error-activo');
				campos['cedula'] = false;
			}

		}
		inputCedula.addEventListener('keyup', validar);
		
		
		let eliminarInscrito = () =>{
			let eliminar = event.target.parentNode.parentNode;
			let tbody = document.querySelector('#ins__tbody');
			let grado = fila.querySelector('.grado').innerHTML;
			let seccion = fila.querySelector('.seccion').innerHTML;
			let periodo = fila.querySelector('.periodo').innerHTML;
			let cedula = event.target.parentNode.parentNode.querySelector('.cedula').innerHTML;

			// tbody.removeChild(event.target.parentNode.parentNode);
			const formData = JSON.stringify({
				delete__grado : grado,
				delete__seccion : seccion,
				delete__periodo : periodo,
				delete__cedula : cedula
			});

			
			let direccion = `${URL}admin/inscripcionGrado/`;
			let xmlhttp = new XMLHttpRequest();

			xmlhttp.onreadystatechange = function() {
				if ( this.readyState == 4 && this.status == 200 ) {
					let datos = JSON.parse(xmlhttp.response);
					if ( datos.status ){

						tbody.removeChild(eliminar);
					}
				}
			}
			xmlhttp.open('DELETE', direccion);
			xmlhttp.send(formData);
		}

		const cargarInscritos = () => {
			let tbody = document.querySelector('#ins__tbody');
			let cargados = document.querySelectorAll('.cargados');
			cargados.forEach(cargado => {
				tbody.removeChild(cargado);
			});


			let grado = fila.querySelector('.grado').innerHTML;
			let seccion = fila.querySelector('.seccion').innerHTML;
			let periodo = fila.querySelector('.periodo').innerHTML;

			let direccion = `${URL}admin/inscripcionGrado/${grado}/${seccion}/${periodo}/`;
			// let direccion = `${URL}admin/inscripcionGrado/5`;
			let xmlhttp = new XMLHttpRequest();
			
			xmlhttp.onreadystatechange = function() {
				
				if ( this.readyState == 4 && this.status == 200 ) {
					
					let datos = JSON.parse(xmlhttp.response);
					let tbody = document.querySelector('#ins__tbody');
					let trForm = document.querySelector('#ins__alumno');



					datos.json.forEach(inscrito => {
						let nuevo = document.createElement('tr');
						nuevo.className = 'cargados';

						nuevo.innerHTML += `
							<td class="cedula">${inscrito.cedula}</td>
							<td class="nombre">${inscrito.p_nombres}</td>
							<td class="apellido">${inscrito.p_apellido}</td>
							<td class="td__btnEliminar__ins"><button type="button" class="btnEliminar__ins" data-grado="${datos.json.cedula}">ELIMINAR</button></td>
						`;
						tbody.insertBefore(nuevo,trForm.nextSibling);
					});

					let btnEliminarGrado = document.querySelectorAll('.btnEliminar__ins');
					
					btnEliminarGrado.forEach(element => {
						element.addEventListener('click', eliminarInscrito );
					});
					
					
				}
			}
			xmlhttp.open('GET', direccion);
			xmlhttp.send();
		}
		cargarInscritos();



		let enviarInscripcion = () => {
			event.preventDefault();
			if (campos.cedula){

				let btnSubmit = document.querySelector('#btn__ins');
				btnSubmit.disabled = true;

				btnSubmit.style.background = 'grey';
				btnSubmit.style.cursor = 'none';

				
				const formData = new FormData();
				formData.append('ins__cedula', inputCedula.value);
				formData.append('ins__grado',fila.querySelector('.grado').innerHTML);
				formData.append('ins__seccion',fila.querySelector('.seccion').innerHTML);
				formData.append('ins__periodo',fila.querySelector('.periodo').innerHTML);

				let direccion = `${URL}admin/inscripcionGrado`;
				let xmlhttp = new XMLHttpRequest();
				
				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
						// TODO FUE CORRECTO
						let datos = JSON.parse(xmlhttp.response);
						if ( datos.status == true ) {


							let tbody = document.querySelector('#ins__tbody');
							let trForm = document.querySelector('#ins__alumno');
							let nuevo = document.createElement('tr');
							nuevo.className = 'cargados';
							// nuevo.dataset.profesor = datos.json.id;

							nuevo.innerHTML += `
								<td class="cedula">${datos.json.cedula}</td>
								<td class="nombre">${datos.json.nombre}</td>
								<td class="apellido">${datos.json.apellido}</td>
								<td class="td__btnEliminar__ins"><button type="button" class="btnEliminar__ins" data-grado="${datos.json.cedula}">ELIMINAR</button></td>
                            `;
                            
							tbody.insertBefore(nuevo,trForm.nextSibling);

							
							alert(datos.respuesta);
						} else {
							alert(datos.respuesta)
						}
						btnSubmit.disabled = false;
						btnSubmit.style.background = '#1e8449';
					btnSubmit.style.cursor = 'pointer';
					}
				}

				xmlhttp.open('POST', direccion);
				xmlhttp.send(formData);

				btnSubmit.disabled = false;
			}
		}

		formulario.addEventListener('submit', enviarInscripcion);

		btnCerrar.addEventListener('click', () => {
			modal.style.display = 'none';
			inputCedula.removeEventListener('keyup', validar);
			formulario.removeEventListener('submit', enviarInscripcion);
		});
		flex.addEventListener('click', (e) => {
			if ( e.target == flex) {
				modal.style.display = 'none';
				inputCedula.addEventListener('keyup', validar);
				formulario.removeEventListener('submit', enviarInscripcion);
			}
		});

	
		

	}

	deleteContenido(e) {
		let gradoEliminar = e.target.parentNode.parentNode;
	
		
		const formData = JSON.stringify({
			delete__grado : gradoEliminar.querySelector('.grado').innerHTML,
			delete__seccion : gradoEliminar.querySelector('.seccion').innerHTML,
			delete__periodo: gradoEliminar.querySelector('.periodo').innerHTML
		});

		let eliminar = confirm('Deseas eliminar el grado?');
		if( eliminar ) {
			let direccion = `${URL}admin/grado`;
			let xmlhttp = new XMLHttpRequest();

			xmlhttp.onreadystatechange = function() {
				if ( this.readyState == 4 && this.status == 200 ) {
					// TODO FUE CORRECTO
					let datos = JSON.parse(xmlhttp.response);
					if ( datos.status == true ) {
						let tbody = e.target.parentNode.parentNode.parentNode;
						tbody.removeChild(gradoEliminar);

					}else{
						alert('El periodo no se pudo eliminar, Compruebe su conexion a internet');
					}
				}
			}

			xmlhttp.open('DELETE', direccion);
			xmlhttp.send(formData);
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
		case 'btnAlumnosInscritos':
			ui.editContenido(event);
			break;
	}
})