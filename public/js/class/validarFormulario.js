class ValidarFormulario {
	constructor(formulario){
		this.formulario = formulario;
		this.inputs = this.formulario.querySelectorAll('#add_contenido input , #add_contenido textarea');
		this.expresiones = {
			numero: /^\d{1,4}$/, // 7 a 14 numeros.
			message: /^[\s\S]{1,100000}$/, // cualquier caracter de tamaño 1 a 20
			archivo: /(.pdf|.doc|.docx|.xlsx|.xls|.txt|.pptx|.ppt|.pub|.jpg|.jpeg|.gif|.png|.ai|.svg|.git|.psd|.raw|.mp4|.m4v|.mov|.mpg|.mpeg|.swf|.zip|.rar|.mp3|.wav|.opus|.PDF|.DOC|.DOCX|.XLSX|.XLS|.TXT|.PPTX|.PPT|.PUB|.JPG|.JPEG|.GIF|.PNG|.AI|.SVG|.GIT|.PSD|.RAW|.MP4|.M4V|.MOV|.MPG|.MPEG|.SWF|.ZIP|.RAR|.MP3|.WAV|.OPUS|.Pdf|.Doc|.Docx|.Xlsx|.Xls|.Txt|.Pptx|.Ppt|.Pub|.Jpg|.Jpeg|.Gif|.Png|.Ai|.Svg|.Git|.Psd|.Raw|.Mp4|.M4V|.Mov|.Mpg|.Mpeg|.Swf|.Zip|.Rar|.Mp3|.Wav|.Opus)$/i,
			size: ( 20 * 1024 ) * 1024
		}
		this.campos = {
			numero: false,
			message: true,
			file1: true,
			file2: true,
			file3: true,
			file4: true
		}

		

		this.recorreInputs();
		this.sendFormulario();
	}

	recorreInputs() {
		this.inputs.forEach( (input) => {
			input.addEventListener('keyup', event => { this.validarFormulario(event) } );
			input.addEventListener('blur', event => { this.validarFormulario(event) } );
			input.addEventListener('change', event => { this.validarFormulario(event) } );
			if (input.name === 'file[]') {
				input.addEventListener('change', event => { this.validarArchivo(event) } );
			}
		});
	}

	validarFormulario(e) {
		switch (e.target.name) {
			case "numero":
				this.validarCampo(this.expresiones.numero, e.target, 'numero');
				break;
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

	validarArchivo(e) {
		switch (e.target.classList[0]) {
			case "file1":
				this.validarCampoArchivo(this.expresiones.archivo, e.target, 'file1', (e.target.files[0])?e.target.files[0].size : null );
				break;
			case "file2":
				this.validarCampoArchivo(this.expresiones.archivo, e.target, 'file2', (e.target.files[0])?e.target.files[0].size : null);
				break;
			case "file3":
				this.validarCampoArchivo(this.expresiones.archivo, e.target, 'file3', (e.target.files[0])?e.target.files[0].size : null);
				break;
			case "file4":
				this.validarCampoArchivo(this.expresiones.archivo, e.target, 'file4', (e.target.files[0])?e.target.files[0].size : null);
				break;
		}
	}

	validarCampoArchivo(expresion, input, campo, size) {
		if ( expresion.test(input.value) || input.value == "" ) {
			if( size < this.expresiones.size || size == null){
				input.classList.remove('incorrecto');
				input.classList.add('correcto');
	
				this.campos[campo] = true;
			
				let error = input.nextElementSibling;
				error.classList.remove('formulario__input-error-activo');
			}else{
				input.classList.remove('correcto');
				input.classList.add('incorrecto');
	
				let error = input.nextElementSibling;
				error.innerHTML = '<span>* El archivo excede el tamaño permitido 20mb.</span><br>';
				error.classList.add('formulario__input-error-activo');
				
				this.campos[campo] = false;
				
			}
		}else{
			input.classList.remove('correcto');
			input.classList.add('incorrecto');
			
			let error = input.nextElementSibling;
			error.innerHTML = '<span>* Formato de archivo No valido.</span><br>';
			error.classList.add('formulario__input-error-activo');
			
			this.campos[campo] = false;
			
		}
	}

	addInputArchivo(){

		var countInputs = 1;
		const grupoInputs = document.getElementById('add_input_archivo');
		grupoInputs.addEventListener('click', (e) => {
			if ( countInputs < 4 ) {
				countInputs++;
				document.getElementById('grupo_archivos').innerHTML += '<input type="file" name="file[]" id="file'+countInputs+'" class="file'+countInputs+'"> <p class="formulario__input-error"></p>';
				this.inputs = this.formulario.querySelectorAll('#add_contenido input , #add_contenido textarea');
				this.recorreInputs(this.inputs);
			}else {
				grupoInputs.disabled = true;
			}
		});
	}

	sendFormulario(){
		const formulario = this.formulario;
		formulario.addEventListener('submit', (e) => {
			
			e.preventDefault();
			if (this.campos.numero && this.campos.message && this.campos.file1 && this.campos.file2 && this.campos.file2 && this.campos.file4 ) {
				let btnSubmit = formulario.querySelector('#btnSubmit');
				btnSubmit.disabled = true;

				let editarDescripcion = formulario.querySelector('#editor .ql-editor');
				let message = formulario.querySelector('#message');
				message.innerHTML = editarDescripcion.innerHTML;

				const formData = new FormData(e.currentTarget);
				let direccion = URL+'contenido/add/'+formData.get('materia');
				let xmlhttp = new XMLHttpRequest();

				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
						// TODO FUE CORRECTO
						let datos = JSON.parse(xmlhttp.response);
						if ( datos.status == true ) {
							let divArchivos = '<div class="trabajos mostrar_archivos">'
							let pp = formulario.querySelectorAll('input[type="file"]');
							pp.forEach(element => {
								if ( element.value ) {

									switch (element.classList[0]) {
										case 'file1':
														divArchivos += `
															<a class="link1" href="${window.URL.createObjectURL(element.files[0])}" download>Material 1</a>
															<br>
															<br>
														`;
											break;
										case 'file2':
											divArchivos += `
													<a class="link2" href="${window.URL.createObjectURL(element.files[0])}" download>Material 2</a>
													<br>
													<br>
												`;
											break;
										case 'file3':
											divArchivos += `
													<a class="link3" href="${window.URL.createObjectURL(element.files[0])}" download>Material 3</a>
													<br>
													<br>
												`;
											break;
										case 'file4':
											divArchivos += `
													<a class="link4" href="${window.URL.createObjectURL(element.files[0])}" download>Material 4</a>
													<br>
													<br>
												`;
											break;
									}
								}
							});

							divArchivos += '</div>'
						

							//let contenidos = document.getElementById('contenido').innerHTML += datos.html;
							let contenidos = document.getElementById('contenido');
							contenidos.innerHTML += `
							<section class="contenido" data-contenido=${datos.idContenido}>
								<div class="titulo">
									<div class="titulo_izq">
										<h4>Objetivo  <span class="objetivo__numero">${formData.get('numero')}</span></h4>
									</div>
									<div class="titulo_der ">
										<div class="enlaces">
											<button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-contenido="${datos.idContenido}"></button>
											<button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="${formData.get('materia')}" data-contenido="${datos.idContenido}" data-objetivo="${formData.get('numero')}" type="button" ></button>
										</div>
									</div>
								</div>
								<div class="contenido">
									<div class="contenido__descripcion">${formData.get('message')}</div>
									${divArchivos}
								</div>
							</section>
							`;


							
							let aa = contenidos.querySelector(`section.contenido[data-contenido="${datos.idContenido}"] .contenido__descripcion`);
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

export default ValidarFormulario;