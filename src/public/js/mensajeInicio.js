class ValidarFormulario {
	constructor(formulario){
		this.formulario = formulario;
		this.inputs = this.formulario.querySelectorAll('input , textarea');
		this.expresiones = {
			titulo: /^[\s\S]{1,1000}$/, // cualquier caracter de tamaño 1 a 1 mil
			descripcion: /^[\s\S]{1,100000}$/ // cualquier caracter de tamaño 1 a 100 mil
		}
		this.campos = {
			titulo: false,
			descripcion: true
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
			case "titulo":
				this.validarCampo(this.expresiones.titulo, e.target, 'titulo');
				break;
			case "descripcion":
				this.validarCampo(this.expresiones.descripcion, e.target, 'descripcion');
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
			if (this.campos.titulo && this.campos.descripcion ) {
				let btnSubmit = formulario.querySelector('#btnSubmit');
				btnSubmit.disabled = true;

				let editarDescripcion = formulario.querySelector('#add__descripcion__qe .ql-editor');
				let message = formulario.querySelector('#add__descripcion');
				message.innerHTML = editarDescripcion.innerHTML;

				const formData = new FormData(e.currentTarget);
				let direccion = `${URL}mensajeInicio/mensajes/`;
				let xmlhttp = new XMLHttpRequest();

				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
						// TODO FUE CORRECTO
						let datos = JSON.parse(xmlhttp.response);
						console.log(datos)
						if ( datos.status == true ) {
							let foros = document.getElementById('foros');
							foros.innerHTML += `
								<section class="foro" data-foro="${datos.json.id_mensaje_inicio}">
									<div class="titulo">
										<div class="titulo_izq">
											<h4>${datos.json.titulo}</h4>
										</div>
										<div class="titulo_der">
											<div class="enlaces">
												<!-- <button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-foro=""></button> -->
												<button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="${datos.json.id_mensaje_inicio}" data-foro="${datos.json.id_mensaje_inicio}" type="button" ></button>
											</div>
										</div>
									</div>
									<div class="contenido">
										<p><strong>Descripcion: </strong><?= $tema[3]?></p>
										<div class="contenido__qe">${datos.json.mensaje}</div>
									</div>
								</section>
							`;


							
							let aa = foros.querySelector(`section.foro[data-foro="${datos.json.id_mensaje_inicio}"] .contenido__qe`);
							var quill3 = new Quill(aa,{
								readOnly: true,
								theme: 'bubble'
							});
							var mensajeError = formulario.querySelector('.mensaje__exito');
							mensajeError.innerHTML = '<p>'+datos.json.mensaje+'</p>';
							mensajeError.classList.add('mensaje__exito-activo');
							mensajeError.scrollIntoView({behavior:'auto',block:'center'});
						} else {
							var mensajeError = formulario.querySelector('.mensaje__exito');
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
				let mensajeError = formulario.querySelector('.mensaje__error');
				mensajeError.innerHTML = '<p>No se puedo guardar, por favor revise todo los campos y verifique que no tengan ningun error</p>';
				mensajeError.classList.add('mensaje__error-activo');
			}
		});
	}

}

class ValidarFormularioEditar  extends ValidarFormulario{
	constructor(formulario) {
		super(formulario)
		this.inputs = this.formulario.querySelectorAll(' input , textarea');
		this.campos = {
			titulo: true,
			descripcion: true
		}
		this.setiarFormulario();
	}

	setiarFormulario(){
		let mensajeError = this.formulario.querySelector('.mensaje__error');
		let mensajeExito = this.formulario.querySelector('.mensaje__exito');
		mensajeError.classList.remove('mensaje__error-activo');
		mensajeExito.classList.remove('mensaje__exito-activo');
		const btnSubmit = document.getElementById('btnSubmit__edit');
		btnSubmit.disabled = false;

		this.inputs.forEach(input => {
			input.classList.remove('incorrecto');
			input.classList.remove('correcto');
			let grupo = input.parentNode.querySelector('.formulario__input-error');
			if ( grupo ) {
				grupo.classList.remove('formulario__input-error-activo');
			}
		});
		
	}

	sendFormulario() {
		const formulario = this.formulario;
		formulario.addEventListener('submit', (e) => {
			e.preventDefault();
			if (this.campos.titulo && this.campos.descripcion ) {
				let btnSubmit = formulario.querySelector('#btnSubmit__edit');
				btnSubmit.disabled = true;

				let editarDescripcion = formulario.querySelector('#edit__descripcion__qe > .ql-editor').innerHTML;
				let descripcion = formulario.querySelector('#edit__descripcion');
				descripcion.innerHTML = editarDescripcion;

				const formData = new FormData(e.currentTarget);
				let direccion = `${URL}foro/editForo/${formData.get('materia')}`;
				let xmlhttp = new XMLHttpRequest();

				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
						// TODO FUE CORRECTO
						let datos = JSON.parse(xmlhttp.response);
						if ( datos.status == true ) {
							let editado = document.querySelector('section.foro[data-foro="'+formData.get('foro')+'"]');
							let titulo = document.createElement('div');
							titulo.classList.add('titulo');
							titulo.innerHTML = `
								<div class="titulo_izq">
									<h4>${formData.get('titulo')}</h4>
								</div>
								<div class="titulo_der">
									<div class="enlaces">
										<button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-foro="${datos.idForo}"></button>
										<button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="${formData.get('materia')}" data-foro="${datos.idForo}" type="button" ></button>
									</div>
								</div>
							`;
							let conten = document.createElement('div');
							conten.classList.add('contendio');
							conten.innerHTML = `
								<p><strong>Descripcion: </strong><?= $tema[3]?></p>
								<div class="contenido__qe">${formData.get('descripcion')}</div>
								<br>
								<a href="${URL}foro/detail/${formData.get('materia')}/${datos.idForo}>INGRESAR AL FORO</a>
							`;

							editado.innerHTML = "";
							editado.appendChild(titulo);
							editado.appendChild(conten);

							let mensajeError = formulario.querySelector('.mensaje__exito');
							mensajeError.innerHTML = '<p>'+datos.respuesta+'</p>';
							mensajeError.classList.add('mensaje__exito-activo');

							mensajeError.scrollIntoView({behavior:'auto',block:'center'});

							let refrescar = editado.querySelector('.contenido__qe');
							let quill3 = new Quill(refrescar,{
								readOnly: true,
								theme: 'bubble'
							});

						}else {
							var mensajeError = formulario.querySelector('.mensaje__exito');
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
				let mensajeError = formulario.querySelector('.mensaje__error');
				mensajeError.innerHTML = '<p>No se puedo guardar, por favor revise todo los campos y verifique que no tengan ningun error</p>';
				mensajeError.classList.add('mensaje__error-activo');
			}
			
		});

	}
}


class UI {
	constructor(){

		this.contenidosQE();
		this.previewQE();
		this.addQE();
		this.editQE();
	}

	addContenido() {}

	editContenido(e) {
		validarFormularioEditar.setiarFormulario();
		validarFormularioEditar.recorreInputs();

		const btnCerrar = document.getElementById('btnCerrarEditar');
		const flex = document.getElementById('flexEditar');
		const modalEditar = document.getElementById('modalEditar');

		const section = e.target.parentNode.parentNode.parentNode.parentNode;
		const titulo = section.querySelector('.title').innerHTML;
		const descripcion = section.querySelector('.contenido__qe > .ql-editor').innerHTML;

		validarFormularioEditar.inputs.forEach( input => {
			switch (input.name) {
				case 'titulo':
					input.value = titulo;
					break;
				case 'descripcion':
					let editarDescripcion = document.querySelector('#edit__descripcion__qe > .ql-editor');
					editarDescripcion.innerHTML = descripcion;
					input.innerHTML = descripcion;
					break;
				case 'foro':
					input.value = e.target.dataset.foro;
					break;
			}
		});

		modalEditar.style.display = 'block';

		btnCerrar.addEventListener('click', () => {
			modalEditar.style.display = 'none';
		});
		flex.addEventListener('click', (e) => {
			if ( e.target == flex) {
				modalEditar.style.display = 'none';
			}
			
		});

	}

	deleteContenido(e) {
		let foro = e.target.dataset.foro;
		
		let eliminar = confirm('Deseas eliminar el mensaje?');
		if( eliminar ) {
			
			let direccion = `${URL}mensajeInicio/mensajes/${foro}`;
			let xmlhttp = new XMLHttpRequest();
			
			xmlhttp.onreadystatechange = function() {
				if ( this.readyState == 4 && this.status == 200 ) {
					// TODO FUE CORRECTO
					let datos = JSON.parse(xmlhttp.response);
					if ( datos.status == true ) {
						let foroEliminar = e.target.parentNode.parentNode.parentNode.parentNode;
						let sectionesForos = e.target.parentNode.parentNode.parentNode.parentNode.parentNode;
						sectionesForos.removeChild(foroEliminar);

					}else{
						alert('El mensaje no se pudo eliminar, Compruebe su conexion a internet');
					}
				}
			}

			xmlhttp.open('DELETE', direccion);
			xmlhttp.send();
		}
	}

	modalPreview(inputs) { 
		const btnModalPreview = document.getElementById('btnModalPreview');
		const btnCerrar = document.getElementById('btnCerrarPreview');
		const flex = document.getElementById('flexPreview');
		const modal = document.getElementById('modalPreview');

		const previewTitulo = document.getElementById('preview__titulo');
		const previewDescripcion = document.querySelector('#preview__descripcion > div');

		btnModalPreview.addEventListener('click', () => {
			modal.style.display = 'block';
			previewTitulo.innerHTML = `<h4>${(inputs[0].value == '')? '<small style="color: red;">ingresa un titulo valido</small>' : inputs[0].value}<h4><br/>`;
			previewDescripcion.innerHTML = inputs[2].value;
		});
		btnCerrar.addEventListener('click', () => {
			modal.style.display = 'none';
		});
		flex.addEventListener('click', (e) => {
			if ( e.target == flex) {
				modal.style.display = 'none';
			}
		});
	}

	modalEdit() {}

	contenidosQE() {
		var contenidoDescripcion = document.querySelectorAll('.contenido__qe');
		contenidoDescripcion.forEach( contenidos => {
			var quill3 = new Quill(contenidos,{
				readOnly: true,
				theme: 'bubble'
			});
		});
	}

	previewQE() {
		let descripcionQE = new Quill('#preview__descripcion',{
			readOnly: true,
			theme: 'bubble'
		});
	}

	addQE() {
		const toolbarOptions = [
			[{ 'font': [] },{'size':['small',false,'large','huge']}],
			[{'header': [1, 2, 3, 4, 5, 6, false]}],
			['bold','italic','underline','strike'],
			[{ 'color': [] }, { 'background': [] }],
			[{ 'align': [] },{'indent':'-1'},{'indent':'+1'}],
			['blockquote',{'list':'ordered'},{'list':'bullet'}],
			[{'script':'sub'},{'script':'super'}],
			['link','video'],
			['code-block','clean']
		];
		const quill = new Quill('#add__descripcion__qe',{
			modules:{
				toolbar: toolbarOptions
			},
			theme: 'snow'
		});
		quill.on('text-change', function() {
			// let prueba =  document.querySelector('#preview__descripcion div');
			let foro =  document.getElementById('add__descripcion');
			foro.innerHTML = quill.container.firstChild.innerHTML;
			// prueba.innerHTML = quill.container.firstChild.innerHTML;
		});

		const limit = 50000;

		quill.on('text-change', function (delta, old, source) {
			if ( (quill.getLength()-1) > limit) {
				quill.deleteText(limit, quill.getLength());
			}else{
				document.getElementById('add__caracteres').innerHTML = quill.getLength() - 1;
			}
		});
	}

	editQE() {
		const toolbarOptions = [
			[{ 'font': [] },{'size':['small',false,'large','huge']}],
			[{'header': [1, 2, 3, 4, 5, 6, false]}],
			['bold','italic','underline','strike'],
			[{ 'color': [] }, { 'background': [] }],
			[{ 'align': [] },{'indent':'-1'},{'indent':'+1'}],
			['blockquote',{'list':'ordered'},{'list':'bullet'}],
			[{'script':'sub'},{'script':'super'}],
			['link','video'],
			['code-block','clean']
		];
		const limit = 50000;
		const quill4 = new Quill('#edit__descripcion__qe',{
			modules:{
				toolbar: toolbarOptions
			},
			theme: 'snow'
		});
		quill4.on('text-change', function (delta, old, source) {
			if ( (quill4.getLength()-1) > limit) {
				quill4.deleteText(limit, quill4.getLength());
			}else{
				document.getElementById('edit__caracteres').innerHTML = quill4.getLength() - 1;
			}
		});
	}
}



const ui = new UI();

const editFormulario = document.getElementById('edit__foro');
const validarFormularioEditar = new ValidarFormularioEditar(editFormulario);

const addFormulario = document.getElementById('add__foro');
const foros = document.getElementById('foros');


validarFormulario = new ValidarFormulario(addFormulario);


ui.modalPreview(validarFormulario.inputs);
foros.addEventListener('click', (event) => {
	switch (event.target.classList[0]) {
		case 'btnEliminar':
			ui.deleteContenido(event);
			break;
		case 'btnModalEditar':
			ui.editContenido(event);
			break;
	}
})