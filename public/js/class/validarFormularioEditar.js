import ValidarFormulario from "./validarFormulario.js";

class ValidarFormularioEditar  extends ValidarFormulario{
	constructor(formulario) {
		super(formulario)
		this.inputs = this.formulario.querySelectorAll('#editar_contenido input , #editar_contenido textarea');
		this.campos = {
			numero: true,
			message: true,
			file1: true,
			file2: true,
			file3: true,
			file4: true
		}
		this.setiarFormulario();
	}

	setiarFormulario(){
		let mensajeError = this.formulario.querySelector('.mensaje__error');
		let mensajeExito = this.formulario.querySelector('.mensaje__exito');
		mensajeError.classList.remove('mensaje__error-activo');
		mensajeExito.classList.remove('mensaje__exito-activo');
		const btnSubmit = document.getElementById('btnSubmitEditar');
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
			if (this.campos.numero && this.campos.message && this.campos.file1 && this.campos.file2 && this.campos.file2 && this.campos.file4 ) {
				let btnSubmit = formulario.querySelector('#btnSubmitEditar');
				btnSubmit.disabled = true;

				let editarDescripcion = formulario.querySelector('#editar__descripcion .ql-editor');
				let message = formulario.querySelector('#message__editar');
				message.innerHTML = editarDescripcion.innerHTML;

				const formData = new FormData(e.currentTarget);
				let direccion = URL+'contenido/edit/'+formData.get('materia');
				let xmlhttp = new XMLHttpRequest();

				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
						// TODO FUE CORRECTO
						let datos = JSON.parse(xmlhttp.response);
						if ( datos.status == true ) {
							
							let editado = document.querySelector('section.contenido[data-contenido="'+formData.get('contenido')+'"]');
							editado.querySelector('.objetivo__numero').innerHTML = formData.get('numero');
							editado.querySelector('.contenido__descripcion').innerHTML = formData.get('message');
							
							let pp = formulario.querySelectorAll('#grupo_archivos_editar > input');
							pp.forEach(element => {
								if ( element.value ) {

									switch (element.classList[0]) {
										case 'file1':
													if ( editado.querySelector('.link1') ) {
														console.log(element.files[0]);
														console.log();
														editado.querySelector('.link1').href = window.URL.createObjectURL(element.files[0]);
													}else {
														editado.querySelector('.mostrar_archivos').innerHTML += `
															<a class="link1" href="${window.URL.createObjectURL(element.files[0])}" download>Material 1</a>
															<br>
															<br>
														`;
													}

											break;
										case 'file2':
											if ( editado.querySelector('.link2') ) {
												console.log(element.files[0]);
												console.log();
												editado.querySelector('.link2').href = window.URL.createObjectURL(element.files[0]);
											}else {
												editado.querySelector('.mostrar_archivos').innerHTML += `
													<a class="link2" href="${window.URL.createObjectURL(element.files[0])}" download>Material 2</a>
													<br>
													<br>
												`;
											}
											break;
										case 'file3':
											if ( editado.querySelector('.link3') ) {
												console.log(element.files[0]);
												console.log();
												editado.querySelector('.link3').href = window.URL.createObjectURL(element.files[0]);
											}else {
												editado.querySelector('.mostrar_archivos').innerHTML += `
													<a class="link3" href="${window.URL.createObjectURL(element.files[0])}" download>Material 3</a>
													<br>
													<br>
												`;
											}
											break;
										case 'file4':
											if ( editado.querySelector('.link4') ) {
												console.log(element.files[0]);
												console.log();
												editado.querySelector('.link4').href = window.URL.createObjectURL(element.files[0]);
											}else {
												editado.querySelector('.mostrar_archivos').innerHTML += `
													<a class="link4" href="${window.URL.createObjectURL(element.files[0])}" download>Material 4</a>
													<br>
													<br>
												`;
											}
											break;
									
									}
								}
							});
							
							let mensajeError = formulario.querySelector('.mensaje__exito');
							mensajeError.innerHTML = '<p>'+datos.respuesta+'</p>';
							mensajeError.classList.add('mensaje__exito-activo');

							mensajeError.scrollIntoView({behavior:'auto',block:'center'});

							let refrescar = editado.querySelector('.contenido__descripcion');
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

export default ValidarFormularioEditar;