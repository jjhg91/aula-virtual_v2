import ValidarFormulario from "./class/validarFormulario.js";

class ValidarFormulario2 {
	constructor(formulario){
		this.formulario = formulario;
		this.inputs = this.formulario.querySelectorAll(' input , textarea, select');
		this.expresiones = {
			nota: /^[\w ]{1,10}$/, // 7 a 14 numeros.
			observacion: /^[\s\S]{1,100000}$/, // cualquier caracter de tamaño 1 a 20
			archivo: /(.pdf|.doc|.docx|.xlsx|.xls|.txt|.pptx|.ppt|.pub|.jpg|.jpeg|.gif|.png|.ai|.svg|.git|.psd|.raw|.mp4|.m4v|.mov|.mpg|.mpeg|.swf|.zip|.rar|.mp3|.wav|.opus|.PDF|.DOC|.DOCX|.XLSX|.XLS|.TXT|.PPTX|.PPT|.PUB|.JPG|.JPEG|.GIF|.PNG|.AI|.SVG|.GIT|.PSD|.RAW|.MP4|.M4V|.MOV|.MPG|.MPEG|.SWF|.ZIP|.RAR|.MP3|.WAV|.OPUS|.Pdf|.Doc|.Docx|.Xlsx|.Xls|.Txt|.Pptx|.Ppt|.Pub|.Jpg|.Jpeg|.Gif|.Png|.Ai|.Svg|.Git|.Psd|.Raw|.Mp4|.M4V|.Mov|.Mpg|.Mpeg|.Swf|.Zip|.Rar|.Mp3|.Wav|.Opus)$/i,
			size: ( 20 * 1024 ) * 1024
		}
		this.campos = {
			nota: false,
			observacion: true,
			file1: true,
			file2: true,
			file3: true,
			file4: true
		}

		this.recorreInputs();
		this.sendFormulario();
		this.setiarFormulario();
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
			case "nota":
				this.validarCampo(this.expresiones.nota, e.target, 'nota');
				break;
			case "observacion":
				this.validarCampo(this.expresiones.observacion, e.target, 'observacion');
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


	setiarFormulario(){
		let mensajeError = this.formulario.querySelector('.mensaje__error');
		let mensajeExito = this.formulario.querySelector('.mensaje__exito');
		mensajeError.classList.remove('mensaje__error-activo');
		mensajeExito.classList.remove('mensaje__exito-activo');
		const btnSubmit = document.getElementById('btnSubmit');
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
	sendFormulario(){
		const formulario = this.formulario;
		formulario.addEventListener('submit', (e) => {

			e.preventDefault();
			if (this.campos.nota && this.campos.observacion && this.campos.file1 && this.campos.file2 && this.campos.file2 && this.campos.file4 ) {
				let btnSubmit = formulario.querySelector('#btnSubmit');
				btnSubmit.disabled = true;

				let editarDescripcion = formulario.querySelector('#editor .ql-editor').innerHTML;
				let observacion = formulario.querySelector('#observacion');
				observacion.innerHTML = editarDescripcion;

				const formData = new FormData(e.currentTarget);
				let direccion = `${URL}nota/addNota/${formData.get('materia')}`;
				let xmlhttp = new XMLHttpRequest();

				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
		// 				// TODO FUE CORRECTO
						let datos = JSON.parse(xmlhttp.response);

						if ( datos.status == true ) {
							let nota = document.querySelector('section.trabajo__cargado[data-alumno="'+formData.get('alumno')+'"]');
							let notaContenido = nota.querySelector('.correciones');
							notaContenido.innerHTML = `
								<span><strong>Estatus: </strong>CORREGIDO</span>
								<br>
								<p><strong>NOTA: </strong><span class="valor__nota">${formData.get('nota')}</span></p>
								<p><strong>OBSERVACION: </strong></p>
								<div class="observacion__qe">${formData.get('observacion')}</div>
							`;

							if ( datos.json['correccion1'] || datos.json['correccion2'] || datos.json['correccion3'] || datos.json['correccion4'] ){
								notaContenido.innerHTML += `
									<br>
									<br>
									<h4>Descargar Correcciones</h4>
									<br>
								`;
							}
							if ( datos.json['correccion1'] ){
								notaContenido.innerHTML += `
									<a class="link1" href="${URL}public/upload/correcciones/${formData.get('materia')}/${formData.get('plan')}/${datos.json['correccion1']}" download>Corrección 1</a>
									<br>
									<br>
								`;
							}
							if ( datos.json['correccion2'] ){
								notaContenido.innerHTML += `
									<a class="link1" href="${URL}public/upload/correcciones/${formData.get('materia')}/${formData.get('plan')}/${datos.json['correccion2']}" download>Corrección 2</a>
									<br>
									<br>
								`;
							}
							if ( datos.json['correccion3'] ){
								notaContenido.innerHTML += `
									<a class="link1" href="${URL}public/upload/correcciones/${formData.get('materia')}/${formData.get('plan')}/${datos.json['correccion3']}" download>Corrección 3</a>
									<br>
									<br>
								`;
							}
							if ( datos.json['correccion4'] ){
								notaContenido.innerHTML += `
									<a class="link1" href="${URL}public/upload/correcciones/${formData.get('materia')}/${formData.get('plan')}/${datos.json['correccion4']}" download>Corrección 4</a>
									<br>
									<br>
								`;
							}



							let aa = notaContenido.querySelector('.observacion__qe');
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



class UI {
	constructor(materia,evaluacion){
		this.materia = materia;
		this.evaluacion = evaluacion;
		this.showData(this.materia,this.evaluacion);
		this.contenidosQE();
		this.addQE();
	}


	showData() {
		let contenidosQE = () => {
		   var contenidoDescripcion = document.querySelectorAll('.observacion__qe');
		   contenidoDescripcion.forEach( contenidos => {
		   var quill3 = new Quill(contenidos,{
			    readOnly: true,
			    theme: 'bubble'
		    });
		   });
	    }

		let direccion = URL+`evaluacion/showEvaluaciones/${materia}/${evaluacion}`;
		let xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if ( this.readyState == 4 && this.status == 200 ) {
				let datos = JSON.parse(xmlhttp.response);
				let trabajos__cargados = document.querySelector('div#trabajos__cargados');
				trabajos__cargados.innerHTML = "";
				
				
				
				datos.data.forEach(dato => {
					var archivos = "";
					var archivo_1 = "";
					var archivo_2 = "";
					var archivo_3 = "";
					var archivo_4 = "";
					
					var links = "";
					var link_1 = "";
					var link_2 = "";
					var link_3 = "";
					var link_4 = "";
					
					var botones = "";
					
					var corregido = "";
					var reviciones = "";
					var revicion_1 = "";
					var revicion_2 = "";
					var revicion_3 = "";
					var revicion_4 = "";

					var editar_evaluacion = "";
					
					if (dato.file1  !== null || dato.file2  !== null || dato.file3  !== null || dato.file4  !== null){
						archivos = `
							<br>
							<br>
							<h4>Descarga de Materiales</h4>
							<br>
						`;
					}
					if (dato.file1 !== null){
						archivo_1 = `
							<a class="link1" href="${URL}public/upload/evaluacion/${dato.id_profesorcursogrupo}/${dato.id_actividades}/${dato.file1}" download>Material 1</a>
							<br>
							<br>
						`;
					}
					if (dato.file2  !== null){
						archivo_2 = `
							<a class="link2" href="${URL}public/upload/evaluacion/${dato.id_profesorcursogrupo}/${dato.id_actividades}/${dato.file2}" download>Material 2</a>
							<br>
							<br>
						`;
					}
					if (dato.file3  !== null){
						archivo_3 = `
							<a class="link3" href="${URL}public/upload/evaluacion/${dato.id_profesorcursogrupo}/${dato.id_actividades}/${dato.file3}" download>Material 3</a>
							<br>
							<br>
						`;
					}
					if (dato.file4  !== null){
						archivo_4 = `
							<a class="link4" href="${URL}public/upload/evaluacion/${dato.id_profesorcursogrupo}/${dato.id_actividades}/${dato.file4}" download>Material 4</a>
							<br>
							<br>
						`;
					}
					if (dato.nlink1 !== null || dato.nlink2 !== null || dato.nlink3 !== null || dato.nlink4 !== null || dato.link1 !== null || dato.link2 !== null || dato.link3 !== null || dato.link4 !== null){
						links = `
							<br>
							<br>
							<h4>Links Enviados por el Alumno</h4>
							<br>
						`;
					}
					if (dato.link1 !== null || dato.nlink1 !== null){
						link_1 = `
							<a href="${dato.link1}">${dato.nlink1}</a>
							<br>
							<br>
						`;
					}
					if (dato.link2 !== null || dato.nlink2 !== null){
						link_2 = `
							<a href="${dato.link2}">${dato.nlink2}</a>
							<br>
							<br>
						`;
					}
					if (dato.link3 !== null || dato.nlink3 !== null){
						link_3 = `
							<a href="${dato.link3}">${dato.nlink3}</a>
							<br>
							<br>
						`;
					}
					if (dato.link4 !== null || dato.nlink4 !== null){
						link_4 = `
							<a href="${dato.link4}">${dato.nlink4}</a>
							<br>
							<br>
						`;
					}
					if(datos.user === 'profesor'){
						botones = `
							<div class="enlaces">
								<button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-alumno="${dato.id_estudiante}"></button>
								<!-- <button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="${dato.id_profesorcursogrupo}" data-blog="${dato.id_blog}" type="button"></button> -->
							</div>
						`;
					}else if(datos.user === 'alumno'){

						if(datos.fecha_limite > datos.fecha){
							botones = `
								<div class="enlaces">
									<button title="Editar" class="btnEditarAlumno icon-pencil" type="button"></button>
									<!-- <a title="Editar" href="#ModalEditarEstudiante" class="btnEditarAlumno">
										<span class="icon-pencil"></span>
									</a> -->
								</div>
							`;
							editar_evaluacion = `
								<!-- MODAL EDITAR EVALUACION ENVIADA POR ALUMNO -->
								<div id="ModalEditarEstudiante" class="editar">
									<form id="FormEditarEstudiante" method="post" enctype="multipart/form-data" action="${URL}
									evaluacion/updateEvaluacionAlumno/${materia}/${evaluacion}">
					
										<div class="grupo">
												<br>
												<br>
												<h3>Descripcion</h3>
											</div>
										<div class="grupo">
												<textarea name="descripcion" id="message" cols="30" rows="10" placeholder="Descripcion">${dato.descripcion}</textarea>
										</div>
					
					
										<!-- CARGAR ARCHIVO -->
											<div class="grupo">
												<br>
												<br>
												<h3>Archivos</h3>
											</div>
											<div class="grupo">
												<div class="grupo">
													${(archivo_1)?'ARCHIVO-1 CARGADO: '+archivo_1:'ARCHIVO-1 SIN CARGAR'}
													<?php endif; ?>
													<input id="file1" name="file[]" type="file">
												</div>
					
												<div class="grupo">
													${(archivo_2)?'ARCHIVO-2 CARGADO: '+archivo_2:'ARCHIVO-2 SIN CARGAR'}
													<input id="file2" name="file[]" type="file">
												</div>
					
												<div class="grupo">
													${(archivo_3)?'ARCHIVO-3 CARGADO: '+archivo_3:'ARCHIVO-3 SIN CARGAR'}
													<input id="file3" name="file[]" type="file">
												</div>
					
												<div class="grupo">
													${(archivo_4)?'ARCHIVO-4 CARGADO: '+archivo_4:'ARCHIVO-4 SIN CARGAR'}
													<input id="file4" name="file[]" type="file">
												</div>
					
											</div>
										<!-- /CARGAR ARCHIVO -->
					
											<div class="form-group row">
												<input type="text" name="materia" value="${materia}" style="display: none;">
												<input type="text" name="evaluacion" value="${evaluacion}" style="display: none;">
												<input type="text" name="evaluacionAlumno" value="${dato.id_actividades_estudiante}" style="display: none;">
											</div>
					
											<div class="botones">
												<button class="item btnTrue" type="submit" >Guardar</button>
												<a class="item close" href="#close" class="cerrar" >Cancelar</a>
											</div>
										</form>
								</div>
							<!-- /MODAL EDITAR EVALUACION ENVIADA POR ALUMNO -->
							`;
						}
					}
					



					if (dato.revision1  !== null || dato.revision2  !== null || dato.revision3  !== null || dato.revision4  !== null){
						reviciones = `
							<br>
							<br>
							<h4>Descargar Correcciones</h4>
							<br>
						`;
					}
					if (dato.revision1 !== null){
						revicion_1 = `
							<a class="link1" href="${URL}public/upload/correcciones/${dato.id_profesorcursogrupo}/${dato.id_plan_evaluacion}/${dato.revision1}" download>Corrección 1</a>
							<br>
							<br>
						`;
					}
					if (dato.revision2  !== null){
						revicion_2 = `
							<a class="link2" href="${URL}public/upload/evaluacion/${dato.id_profesorcursogrupo}/${dato.id_actividades}/${dato.revision2}" download>Corrección 2</a>
							<br>
							<br>
						`;
					}
					if (dato.revision3  !== null){
						revicion_3 = `
							<a class="link3" href="${URL}public/upload/evaluacion/${dato.id_profesorcursogrupo}/${dato.id_actividades}/${dato.revision3}" download>Corrección 3</a>
							<br>
							<br>
						`;
					}
					if (dato.revision4  !== null){
						revicion_4 = `
							<a class="link4" href="${URL}public/upload/evaluacion/${dato.id_profesorcursogrupo}/${dato.id_actividades}/${dato.revision4}" download>Corrección 4</a>
							<br>
							<br>
						`;
					}


					if (dato.nota === null ) {
						corregido = `
							<span><strong>Estatus: </strong>SIN CORREGIR</span>
						`;
					} else {
						corregido = `
							<span><strong>Estatus: </strong>CORREGIDO</span>
							<br>
							<span><strong>Nota: </strong><span class="valor__nota">${dato.nota} </span></span>
							<br>
							<span><strong>Observacion: </strong></span>
							<div class="observacion__qe">${dato.observacion} </div>
							
							<!-- MOSTRAR CORRECIONES -->
							${reviciones}
							${revicion_1}
							${revicion_2}
							${revicion_3}
							${revicion_4}
							<!-- /MOSTRAR CORRECIONES -->
						`;
					}

					let html = `
						<section class="trabajo__cargado" data-alumno="${dato.id_estudiante} ">
							<div class="titulo">
								<div class="titulo_izq">
									<h4 class="nombre">${dato.nombres} ${dato.apellidos} </h4>
								</div>
								<div class="titulo_der">
									${botones}
								</div>
							</div>
							<div class="contenido">

								<span class="cedula"><small><strong>C.I: </strong>${dato.cedula} </small></span>
								<br>
								<span><small><strong>Fecha de Entrega: </strong>${dato.fecha} </small></span>
								<br>
								<br>
								
								<div class="correciones">
									${corregido}
								</div>

							<!-- DESCRIPCION ENTRAGADA POR EL ESTUDIANTE -->
							<div class="Trabajos">
								<br>
								<br>
								<h3>DATOS ENVIADOS POR EL ESTUDIANTE</h3>
								

								<h4>Descripcion:</h4>
								<br>
								<p>${dato.descripcion} </p>

							</div>
							<!-- /DESCRIPCION ENTRAGADA POR EL ESTUDIANTE -->

							<!-- LINKS ENTREGADOS POR EL ESTUDIANE -->
								<div class="trabajos">
									${links}
									${link_1}
									${link_2}
									${link_3}
									${link_4}	
								</div>
							<!-- /LINKS ENTREGADOS POR EL ESTUDIANE -->

							<!-- ARCHIVOS ENTREGADOS POR EL ESTUDIANTE -->
								<div class="trabajos">
									${archivos}
									${archivo_1}
									${archivo_2}
									${archivo_3}
									${archivo_4}
								</div>
							<!-- /ARCHIVOS ENTREGADOS POR EL ESTUDIANTE -->
							${editar_evaluacion}
							</div>
					</section>
						`;
					trabajos__cargados.innerHTML += html;

				});
				if ( datos.user === 'alumno' && (datos.data.length === 0 || datos.data.length === null) ) {
					
					let html = `
					<!-- FORMULARIO PARA QUE EL ALUMNO CARGUE LA EVALUACION -->
					<section class="section_agregar">
						<div class="titulo">
							<h3>Cargar Evaluacion</h3>
						</div>
						<div class="contenido">
							<form method="post" enctype="multipart/form-data" action="${URL}evaluacion/addEvaluacionAlumno/${materia}/${evaluacion} ">

							<div class="grupo">
									<br>
									<br>
									<h3>Descripcion</h3>
								</div>
							<div class="grupo">
									<textarea name="descripcion" id="message" cols="30" rows="10" placeholder="Descripcion"></textarea>
							</div>
							<!-- <div class="grupo">
								<div id="editor" style="height: 375px;"></div>
								<textarea name="descripcion" id="descripcion" cols="20" rows="10" style="display:none;"></textarea>
								<p id="editor_contador">caracteres (<span id="editor_caracteres">0</span>/50000)</p>
							</div> -->

							<!-- SECCION DE AGREGAR LINKS -->

								<!-- <div class="grupo">
									<br>
									<br>
									<h3>Links</h3>
									<br>
									<p><small>
										Para agregar un link tendrás que colocar un nombre en el campo (Nombre link) y luego colocar el link en el campo de abajo (Link) colocar el link. 
										<br>
										<br>
										Ejemplo:

										<br>
										Nombre Link = Pagina Web del Instituto
										<br>
										Url del Link = https://iutjmc.com.ve
										<br>
										<br>
										Aparecerá de esta manera al profesor <a href="https://iutjmc.com.ve">Pagina Web del Instituto</a>
									</small></p>
								</div>

								<div class="grupo">
									<span>Link 1</span>
									<div class="grupo">
										<label for="">Nombre del Link</label>
										<input id="nlink1" name="nlink1"  type="text" placeholder="Nombre del link 1">
									</div>
									<div class="grupo">
										<label for="">Url del Link</label>
										<input id="link1" name="link1" type="text" placeholder="Url del Link 1">
									</div>
								</div>

								<div class="grupo">
									<span>Link 2</span>
									<div class="grupo">
										<label for="">Nombre del Link</label>
										<input id="nlink2" name="nlink2" type="text" placeholder="Nombre del link 2">
									</div>
									<div class="grupo">
										<label for="">Url del Link</label>
										<input id="link2" name="link2" type="text" placeholder="Url del Link 2">
									</div>
								</div>

								<div class="grupo">
									<span>Link 3</span>
									<div class="grupo">
										<label for="">Nombre del Link</label>
										<input id="nlink3" name="nlink3" type="text" placeholder="Nombre del link 3">
									</div>
									<div class="grupo">
										<label for="">Url del Link</label>
										<input id="link3" name="link3" type="text" placeholder="Url del Link 3">
									</div>

								</div>

								<div class="grupo">
									<span>Link 4</span>
									<div class="grupo">
										<label for="">Nombre del Link</label>
										<input id="nlink4" name="nlink4" type="text" placeholder="Nombre del link 4">
									</div>
									<div class="grupo">
										<label for="">Url del Link</label>
										<input id="link4" name="link4" type="text" placeholder="Url del Link 4">
									</div>
								</div> -->

							<!-- /SECCION DE AGREGAR LINKS -->

							<!-- CARGAR ARCHIVO -->
								<div class="grupo">
									<br>
									<br>
									<h3>Archivos</h3>
								</div>
								<div class="grupo">
									<div class="grupo">
										<input id="file1" name="file[]" type="file">
									</div>
									<div class="grupo">
										<input id="file2" name="file[]" type="file">
									</div>
									<div class="grupo">
										<input id="file3" name="file[]" type="file">
									</div>
									<div class="grupo">
										<input id="file4" name="file[]" type="file">
									</div>
								</div>
							<!-- /CARGAR ARCHIVO -->

								<div class="form-group row">
									<input type="text" name="materia" value="${materia} " style="display: none;">
									<input type="text" name="alumno" value="<?= $this->usuario['id'] ?>" style="display: none;">
									<input type="text" name="evaluacion" value="${evaluacion}" style="display: none;">
								</div>

								<button class="btnTrue">Guardar</button>
							</form>
						</div>
					</section>
					`;
				
					if(document.querySelector('.div__agregar_evaluacion') != null ){
						let add_div = document.querySelector('.div__agregar_evaluacion');
						add_div.innerHTML = html;
					}
				}

				contenidosQE();
			}
		}

		xmlhttp.open('GET', direccion);
		xmlhttp.send();



	}


	editContenido(e) {
		validarFormulario.setiarFormulario();
		validarFormulario.recorreInputs();

		const btnCerrar = document.getElementById('btnCerrarEditar');
		const flex = document.getElementById('flexEditar');
		const modalEditar = document.getElementById('modalEditar');

		const section = e.target.parentNode.parentNode.parentNode.parentNode;
		const nombre = section.querySelector('.nombre');
		const cedula = section.querySelector('.cedula');
		const valorNota = (section.querySelector('.valor__nota') && section.querySelector('.valor__nota').innerHTML != 0) ? section.querySelector('.valor__nota').innerHTML : 0;
		const observacion = (section.querySelector('.observacion__qe > .ql-editor')) ? section.querySelector('.observacion__qe > .ql-editor').innerHTML : 0;

		validarFormulario.inputs.forEach( input => {
			switch (input.name) {
				case 'alumno':
					input.value = e.target.dataset.alumno;
					break;
				case 'nota':
					if ( valorNota !== 0) {
						input.querySelector(`option[value="${parseInt(valorNota)}"]`).selected = true;
						validarFormulario.campos.nota = true;
					}
					break;
				case 'observacion':
					if ( observacion !== 0) {
						validarFormulario.formulario.querySelector('#editor > .ql-editor').innerHTML = observacion;
						validarFormulario.campos.observacion = true;
					}
					break;
				case 'contenido':
					input.value = e.target.dataset.contenido;
					break;
				case 'file[]':
					let n = input.classList[0];


					if ( n == 'file1' ) {
						let link = section.querySelector('.link1');
						if ( link != null ) {
							document.getElementById('link1').innerHTML = '<a href="'+link.href+'" download>Material 1</a>';
						}else{
							document.getElementById('link1').innerHTML = 'NO HAY ARCHIVO CARGADO';
						}
					}else if( n == 'file2' ){
						let link = section.querySelector('.link2');
						if ( link != null ) {
							document.getElementById('link2').innerHTML = '<a href="'+link.href+'" download>Material 2</a>';
						}else{
							document.getElementById('link2').innerHTML = 'NO HAY ARCHIVO CARGADO';
						}
					}else if( n == 'file3' ){
						let link = section.querySelector('.link3');
						if ( link != null ) {
							document.getElementById('link3').innerHTML = '<a href="'+link.href+'" download>Material 3</a>';
						}else{
							document.getElementById('link3').innerHTML = 'NO HAY ARCHIVO CARGADO';
						}
					} else if( n == 'file4'){
						let link = section.querySelector('.link4');
						if ( link != null ) {
							document.getElementById('link4').innerHTML = '<a href="'+link.href+'" download>Material 4</a>';
						}else{
							document.getElementById('link4').innerHTML = 'NO HAY ARCHIVO CARGADO';
						}
					}
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



	editContenidoAlumno(e) {
		validarFormularioEditarAlumno.setiarFormulario();
		validarFormularioEditarAlumno.recorreInputs();

		const btnCerrar = document.getElementById('btnCerrarEditar');
		const flex = document.getElementById('flexEditar');
		const modalEditar = document.getElementById('modalEditar');

		const section = e.target.parentNode.parentNode.parentNode.parentNode;
		const nombre = section.querySelector('.nombre');
		const cedula = section.querySelector('.cedula');
		const valorNota = (section.querySelector('.valor__nota') && section.querySelector('.valor__nota').innerHTML != 0) ? section.querySelector('.valor__nota').innerHTML : 0;
		const observacion = (section.querySelector('.observacion__qe > .ql-editor')) ? section.querySelector('.observacion__qe > .ql-editor').innerHTML : 0;

		validarFormularioEditarAlumno.inputs.forEach( input => {
			switch (input.name) {
				case 'alumno':
					input.value = e.target.dataset.alumno;
					break;
				case 'nota':
					if ( valorNota !== 0) {
						input.querySelector('option[value="'+valorNota+'"]').selected = true;
						validarFormularioEditarAlumno.campos.nota = true;
					}
					break;
				case 'observacion':
					if ( observacion !== 0) {
						validarFormularioEditarAlumno.formulario.querySelector('#editor > .ql-editor').innerHTML = observacion;
						validarFormularioEditarAlumno.campos.observacion = true;
					}
					break;
				case 'contenido':
					input.value = e.target.dataset.contenido;
					break;
				case 'file[]':
					let n = input.classList[0];


					if ( n == 'file1' ) {
						let link = section.querySelector('.link1');
						if ( link != null ) {
							document.getElementById('link1').innerHTML = '<a href="'+link.href+'" download>Material 1</a>';
						}else{
							document.getElementById('link1').innerHTML = 'NO HAY ARCHIVO CARGADO';
						}
					}else if( n == 'file2' ){
						let link = section.querySelector('.link2');
						if ( link != null ) {
							document.getElementById('link2').innerHTML = '<a href="'+link.href+'" download>Material 2</a>';
						}else{
							document.getElementById('link2').innerHTML = 'NO HAY ARCHIVO CARGADO';
						}
					}else if( n == 'file3' ){
						let link = section.querySelector('.link3');
						if ( link != null ) {
							document.getElementById('link3').innerHTML = '<a href="'+link.href+'" download>Material 3</a>';
						}else{
							document.getElementById('link3').innerHTML = 'NO HAY ARCHIVO CARGADO';
						}
					} else if( n == 'file4'){
						let link = section.querySelector('.link4');
						if ( link != null ) {
							document.getElementById('link4').innerHTML = '<a href="'+link.href+'" download>Material 4</a>';
						}else{
							document.getElementById('link4').innerHTML = 'NO HAY ARCHIVO CARGADO';
						}
					}
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



	contenidosQE() {
		var contenidoDescripcion = document.querySelectorAll('.observacion__qe');
		contenidoDescripcion.forEach( contenidos => {
			var quill3 = new Quill(contenidos,{
				readOnly: true,
				theme: 'bubble'
			});
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
		const quill = new Quill('#editor',{
			modules:{
				toolbar: toolbarOptions
			},
			theme: 'snow'
		});
		quill.on('text-change', function() {
			let prueba =  document.querySelector('#editor > div.ql-editor').innerHTML;
			let observacion =  document.getElementById('observacion');
			observacion.innerHTML = prueba;
		});

		const limit = 50000;

		quill.on('text-change', function (delta, old, source) {
			if ( (quill.getLength()-1) > limit) {
				quill.deleteText(limit, quill.getLength());
			}else{
				document.getElementById('editor_caracteres').innerHTML = quill.getLength() - 1;
			}
		});
	}

}


var url = window.location;
url = url.pathname.split('/');
var materia = url[url.length - 2];
var evaluacion = url[url.length - 1];

const ui = new UI(materia,evaluacion);

const addFormulario = document.getElementById('set__nota');
const contendios = document.getElementById('trabajos__cargados');

let urlAdd = `${URL}nota/addNota/${materia}`;
let camposAdd = {
	nota: false,
	observacion: true,
	file1: true,
	file2: true,
	file3: true,
	file4: true
}
const validarFormulario = new ValidarFormulario(addFormulario,ui.showData,camposAdd,urlAdd);

// NO USADO AUN 
// const editFormularioAlumno = document.getElementById('FormEditarEstudiante');
// validarFormularioEditarAlumno = new ValidarFormulario(editFormularioAlumno);

contendios.addEventListener('click', (event) => {

	switch (event.target.classList[0]) {
		// case 'btnEliminar':
		// 	ui.deleteContenido(event);
		// 	break;
		case 'btnModalEditar':
			ui.editContenido(event);
			break;
		case 'btnEditarAlumno':
			const elemtento = event.target.parentNode.parentNode.parentNode.parentNode;
			const modal = elemtento.querySelector('#ModalEditarEstudiante');
			modal.style.cssText = 'display:block; opacity:1;pointer-events: auto; height: auto;'
			console.log('hola')
			// ui.editContenidoAlumno(event);
		 	break;
	}
})