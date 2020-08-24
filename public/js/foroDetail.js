class ValidarFormulario {
	constructor(formulario){
		this.formulario = formulario;
		this.inputs = this.formulario.querySelectorAll('input , textarea');
		this.expresiones = {
			message: /^[\s\S]{1,100000}$/ // cualquier caracter de tamaño 1 a 100 mil
		}
		this.campos = {
			message: true,
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
			case "message":
				this.validarCampo(this.expresiones.message, e.target, 'message');
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
			debugger
			e.preventDefault();
			if ( this.campos.message ) {
				let btnSubmit = formulario.querySelector('#btnSubmit');
				btnSubmit.disabled = true;

				let editarDescripcion = formulario.querySelector('#add__message-qe > .ql-editor');
				let message = formulario.querySelector('#message__add');
				message.innerHTML = editarDescripcion.innerHTML;

				const formData = new FormData(e.currentTarget);
				let direccion = `${URL}foro/addPost/${formData.get('materia')}`;
				let xmlhttp = new XMLHttpRequest();

				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
						// TODO FUE CORRECTO
						let datos = JSON.parse(xmlhttp.response);
						if ( datos.status == true ) {
							let nombre = document.getElementById('nombre__usuario').innerHTML;
							let posts = document.getElementById('posts');
							posts.innerHTML += `
								<section class="post" data-post="${datos.idPost}" data-foro="${formData.get('foro')}">
									<div class="titulo">
										<div class="titulo_izq">
											<h3>${nombre}</h3>
											<span><small>Fecha: ${datos.fecha}</small></span>
										</div>
								
										<div class="titulo_der">
											<div class="enlaces">
												<button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="${formData.get('materia')}" data-foro="${formData.get('foro')}" data-post="${datos.idPost}" type="button" ></button>
											</div>
										</div>
								
									</div>
									<div class="contenido">
									<div class="message__qe">${formData.get('message')}</div>
									</div>
								</section>
							`;


							
							let aa = posts.querySelector(`section.post[data-post="${datos.idPost}"] > div.contenido >  .message__qe`);
							var quill3 = new Quill(aa,{
								readOnly: true,
								theme: 'bubble'
							});
							var mensajeError = formulario.querySelector('.mensaje__exito');
							mensajeError.innerHTML = '<p>'+datos.respuesta+'</p>';
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

class ValidarFormularioResponder  extends ValidarFormulario{
	constructor(formulario) {
		super(formulario)
		this.inputs = this.formulario.querySelectorAll(' input , textarea');
		this.campos = {
			message: true
		}
	}

	

	sendFormulario() {
		const formulario = this.formulario;
		const section = formulario.parentNode.parentNode.parentNode;

		formulario.addEventListener('submit', (e) => {
			e.preventDefault();
			if ( this.campos.message ) {
				let btnSubmit = formulario.querySelector('.formResponder');
				btnSubmit.disabled = true;

				let editarMessage = formulario.querySelector('.responder__message-qe > .ql-editor').innerHTML;
				let message = formulario.querySelector('.message__responder');
				message.innerHTML = editarMessage;

				const formData = new FormData(e.currentTarget);
				let direccion = `${URL}foro/addRespuestaPost/${formData.get('materia')}`;
				let xmlhttp = new XMLHttpRequest();

				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
				// 		// TODO FUE CORRECTO
						let datos = JSON.parse(xmlhttp.response);
						if ( datos.status == true ) {
							let nombre = document.getElementById('nombre__usuario').innerHTML;
							let respuestas = section.querySelector('.respuestas > .mensaje__qe');
							respuestas.innerHTML += `
								<div class="respuesta">
									<p class="nombreHora"><b>${nombre} <small>(${datos.fecha})</small>:</b></p>
									<div class="mensaje__qe">${formData.get('message')}</div>
									<br>
								</div>
							`;

							
							let aa = section.querySelector('.respuestas').lastElementChild;

							var quill3 = new Quill(aa,{
								readOnly: true,
								theme: 'bubble'
							});

							var mensajeError = formulario.querySelector('.mensaje__exito');
							mensajeError.innerHTML = '<p>'+datos.respuesta+'</p>';
							mensajeError.classList.add('mensaje__exito-activo');
							mensajeError.scrollIntoView({behavior:'auto',block:'center'});

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
		// this.previewQE();
		this.addQE();
		this.responderQE();
	}

	addContenido() {}

	responderPost(e) {
		let cerrarResponder = document.querySelectorAll('.Modal-active');
		cerrarResponder.forEach( element => {
			element.classList.remove('Modal-active');
		});
		let responder = e.target.nextElementSibling;
		responder.classList.add('Modal-active');


	}

	cancelarResponder(e) {
		let cancelar = e.target.parentNode.parentNode.parentNode;
		cancelar.classList.remove('Modal-active');
	}

	deleteContenido(e) {
		let materia = e.target.dataset.materia;
		let foro = e.target.dataset.foro;
		let post = e.target.dataset.post;

		let eliminar = confirm('Deseas eliminar el foro?');
		if( eliminar ) {
			
			let direccion = `${URL}foro/deletePost/${materia}/${foro}/${post}`;
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
						alert('El contendio no se pudo eliminar, Compruebe su conexion a internet');
					}
				}
			}

			xmlhttp.open('GET', direccion);
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
		var contenidoDescripcion = document.querySelectorAll('.mensaje__qe, .message__qe');
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
		const quill = new Quill('#add__message-qe',{
			modules:{
				toolbar: toolbarOptions
			},
			theme: 'snow'
		});
		quill.on('text-change', function() {
			// let prueba =  document.querySelector('#preview__descripcion div');
			let post =  document.getElementById('message__add');
			post.innerHTML = quill.container.firstChild.innerHTML;
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

	responderQE() {
		var responderDescripcion = document.querySelectorAll('.responder__message-qe');
		responderDescripcion.forEach( contenidos => {
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

			const quill4 = new Quill(contenidos,{
				modules:{
					toolbar: toolbarOptions
				},
				theme: 'snow'
			});
			quill4.on('text-change', function (delta, old, source) {
				if ( (quill4.getLength()-1) > limit) {
					quill4.deleteText(limit, quill4.getLength());
				}else{
					let contar =   contenidos.nextElementSibling; 
					contar.querySelector('.responder__caracteres').innerHTML = quill4.getLength() - 1;
				}
			});
		});
		
	}
}



const ui = new UI();

const editFormulario = document.getElementById('edit__foro');
// const 

const addFormulario = document.getElementById('add__post');
const posts = document.getElementById('posts');


validarFormulario = new ValidarFormulario(addFormulario);


posts.addEventListener('click', (event) => {
	
	switch (event.target.classList[0]) {
		case 'btnEliminar':
			ui.deleteContenido(event);
			break;
		case 'btnResponder':
			ui.responderPost(event);
			break;
		case 'btnCancelar':
			ui.cancelarResponder(event);
			break;
		case 'formResponder':
			// ui.formResponder(event);
			let add__responder = event.target.parentNode.parentNode;
			let validarFormularioResponder = new ValidarFormularioResponder(add__responder);
			break;
			
	}
})