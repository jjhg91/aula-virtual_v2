class ValidarFormulario {
	constructor(formulario){
		this.formulario = formulario;
		this.inputs = this.formulario.querySelectorAll('input , textarea, #add_evaluacion > div > select');
		this.expresiones = {
			plan: /^\d{1,10}$/, // 7 a 14 numeros.
			fecha: /^(\d{4})\-(\d{2})\-(\d{2})$/,
			descripcion: /^[\s\S]{1,100000}$/, // cualquier caracter de tamaño 1 a 20
			archivo: /(.pdf|.doc|.docx|.xlsx|.xls|.txt|.pptx|.ppt|.pub|.jpg|.jpeg|.gif|.png|.ai|.svg|.git|.psd|.raw|.mp4|.m4v|.mov|.mpg|.mpeg|.swf|.zip|.rar|.mp3|.wav|.opus|.PDF|.DOC|.DOCX|.XLSX|.XLS|.TXT|.PPTX|.PPT|.PUB|.JPG|.JPEG|.GIF|.PNG|.AI|.SVG|.GIT|.PSD|.RAW|.MP4|.M4V|.MOV|.MPG|.MPEG|.SWF|.ZIP|.RAR|.MP3|.WAV|.OPUS|.Pdf|.Doc|.Docx|.Xlsx|.Xls|.Txt|.Pptx|.Ppt|.Pub|.Jpg|.Jpeg|.Gif|.Png|.Ai|.Svg|.Git|.Psd|.Raw|.Mp4|.M4V|.Mov|.Mpg|.Mpeg|.Swf|.Zip|.Rar|.Mp3|.Wav|.Opus)$/i,
			size: ( 20 * 1024 ) * 1024
		}
		this.campos = {
			plan: false,
			fecha: false,
			descripcion: true,
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
			case "plan":
				this.validarCampo(this.expresiones.plan, e.target, 'plan', parseInt(e.target.value));
				break;
			case "fecha":
				this.validarCampo(this.expresiones.fecha, e.target, 'fecha', e.target.value);
				break;
			case "descripcion":
				// this.validarCampo(this.expresiones.message, e.target, 'message');
				break;
		}
	}

	validarCampo(expresion, input, campo, value) {
		if ( expresion.test(value) ) {
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
				document.getElementById('grupo_archivos').innerHTML += `
					<input type="file" name="file[]" class="file${countInputs}">
					<p class="formulario__input-error"></p>
				`;
				this.inputs = this.formulario.querySelectorAll(' input , textarea, select');
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
			
			if (this.campos.plan && this.campos.fecha && this.campos.descripcion && this.campos.file1 && this.campos.file2 && this.campos.file2 && this.campos.file4 ) {
				let btnSubmit = formulario.querySelector('#btnSubmit');
				btnSubmit.disabled = true;

				let editarDescripcion = formulario.querySelector('#editor .ql-editor');
				let descripcion = formulario.querySelector('#descripcion_evaluacion');
				descripcion.innerHTML = editarDescripcion.innerHTML;

				let plan = this.inputs[0].options[this.inputs[0].selectedIndex].text.split(':');
				let tipo = plan[0];
				let valor = plan[1].split('-')[0];
				


				const formData = new FormData(e.currentTarget);
				let direccion = `${URL}evaluacion/add/${formData.get('materia')}`;
				let xmlhttp = new XMLHttpRequest();

				let date = formData.get('fecha').split('-');
				let fecha = `${date[2]}-${date[1]}-${date[0]}`;

				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
						// TODO FUE CORRECTO
						let datos = JSON.parse(xmlhttp.response);
						if ( datos.status == true ) {
							
							let evaluaciones = document.getElementById('evaluaciones');
							evaluaciones.innerHTML += `
							<section class="evaluacion" data-evaluacion="${datos.idEvaluacion}">
								<div class="titulo">
									<div class="titulo_izq">
										<h4>${tipo}</h4>
									</div>
									<div class="titulo_der">
										<div class="enlaces">
										</div>
									</div>
								</div>
								<div class="contenido">
									<p><strong>Fecha limite: </strong>${fecha}</p>
									<p><strong>Valor: </strong>${valor}</p>
									<br>
									<a href="${URL}evaluacion/detail/${formData.get('materia')}/${datos.idEvaluacion}">Detalles</a>
								</div>
							</section>
							`;


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
							let titulo = document.createElement('div');
							titulo.classList.add('titulo');
							titulo.innerHTML = `
									<div class="titulo_izq">
										<h4>Objetivo  <span class="objetivo__numero">${formData.get('numero')}</span></h4>
									</div>
									<div class="titulo_der ">
										<div class="enlaces">
											<button title="Editar" class="btnModalEditar item icon-pencil" type="button" data-contenido="${formData.get('contenido')}"></button>
											<button title="Eliminar" class="btnEliminar icon-bin" data-materia="${formData.get('materia')}" data-contenido="${formData.get('contenido')}" data-objetivo="${formData.get('numero')}" type="button" ></button>
										</div>
									</div>
							`;
							let conten = document.createElement('div');
							conten.classList.add('contendio');
							conten.innerHTML = `
									<div class="contenido__descripcion">${formData.get('message')}</div>
							`;


							editado.innerHTML = "";
							editado.appendChild(titulo);
							editado.appendChild(conten);

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


class UI {
	constructor(){

		// this.contenidosQE();
		this.previewQE();
		this.addQE();
		// this.editQE();
	}

	addContenido() {}

	editContenido(e) {
		validarFormularioEditar.setiarFormulario();
		validarFormularioEditar.recorreInputs();

		const btnCerrar = document.getElementById('btnCerrarEditar');
		const flex = document.getElementById('flexEditar');
		const modalEditar = document.getElementById('modalEditar');

		const section = e.target.parentNode.parentNode.parentNode.parentNode;
		const numero = section.querySelector('span.objetivo__numero');

		const qlEditor = section.querySelector('.ql-editor');
		
		validarFormularioEditar.inputs.forEach( input => {
			switch (input.name) {
				case 'numero':
					input.value = numero.innerHTML;
					break;
				case 'message':
					let editarDescripcion = document.querySelector('#editar__descripcion .ql-editor');
					editarDescripcion.innerHTML = qlEditor.innerHTML;
					break;
				case 'contenido':
					input.value = e.target.dataset.contenido;
					break;
				case 'file[]':
					let n = input.classList[0];


					if ( n == 'file1' ) {
						let link = section.querySelector('.link1');
						if ( link != null ) {
							document.getElementById('link1').innerHTML = '<a href="'+link.href+'" download>Material 4</a>';
						}else{
							document.getElementById('link1').innerHTML = 'NO HAY ARCHIVO CARGADO';
						}
					}else if( n == 'file2' ){
						let link = section.querySelector('.link2');
						if ( link != null ) {
							document.getElementById('link2').innerHTML = '<a href="'+link.href+'" download>Material 4</a>';
						}else{
							document.getElementById('link2').innerHTML = 'NO HAY ARCHIVO CARGADO';
						}
					}else if( n == 'file3' ){
						let link = section.querySelector('.link3');
						if ( link != null ) {
							document.getElementById('link3').innerHTML = '<a href="'+link.href+'" download>Material 4</a>';
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

	deleteContenido(e) {
		let materia = e.target.dataset.materia;
		let contenido = e.target.dataset.contenido;
		let objetivo = e.target.dataset.objetivo;

		let eliminar = confirm('Deseas eliminar del contendio el objetivo numero: ' + objetivo );
		if( eliminar ) {
			let contenidoEliminar = e.target.parentNode.parentNode.parentNode.parentNode;
			let direccion = URL+'contenido/delete/'+materia+'/'+contenido+'/'+objetivo
			let xmlhttp = new XMLHttpRequest();
			
			xmlhttp.onreadystatechange = function() {
				if ( this.readyState == 4 && this.status == 200 ) {
					// TODO FUE CORRECTO
					let datos = JSON.parse(xmlhttp.response);
					if ( datos.status == true ) {
						let sectionContenido = e.target.parentNode.parentNode.parentNode.parentNode;
						let sectionesContenidos = e.target.parentNode.parentNode.parentNode.parentNode.parentNode;
						sectionesContenidos.removeChild(sectionContenido);

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

		const previewPlan = document.getElementById('preview__plan');
		const previewValor = document.getElementById('preview__valor');
		const previewFecha = document.getElementById('preview__fecha');
		const previewDescripcion = document.querySelector('#preview__descripcion > div');

		const previewArchivos = document.getElementById('preview__archivos');

		btnModalPreview.addEventListener('click', () => {
			
			const plan = inputs[0].options[inputs[0].selectedIndex].text.split(':');
			const tipo = plan[0];
			const valor = plan[1].split('-')[0];
			
			modal.style.display = 'block';
			console.log(tipo,valor);
			previewPlan.innerHTML = `
				<h4>${tipo}<h4>
				<br/>
			`;
			previewValor.innerHTML = `
				<p><b>Valor: </b>${valor}</p>
			`;
			previewFecha.innerHTML = `
				<p><b>Fecha limite: </b>${inputs[1].value}<p>
			`;
			
			previewDescripcion.innerHTML = inputs[3].value;
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
		var contenidoDescripcion = document.querySelectorAll('.contenido__descripcion');
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
		const quill = new Quill('#editor',{
			modules:{
				toolbar: toolbarOptions
			},
			theme: 'snow'
		});
		quill.on('text-change', function() {
			let descripcion =  document.getElementById('descripcion_evaluacion');
			descripcion.innerHTML = quill.container.firstChild.innerHTML;
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
		const quill4 = new Quill('#editar__descripcion',{
			modules:{
				toolbar: toolbarOptions
			},
			theme: 'snow'
		});
		quill4.on('text-change', function (delta, old, source) {
			if ( (quill4.getLength()-1) > limit) {
				quill4.deleteText(limit, quill4.getLength());
			}else{
				document.getElementById('editar_caracteres').innerHTML = quill4.getLength() - 1;
			}
		});
	}
}



const ui = new UI();

const editFormulario = document.getElementById('edit_evaluacion');
const validarFormularioEditar = new ValidarFormularioEditar(editFormulario);

const addFormulario = document.getElementById('add_evaluacion');
const evaluaciones = document.getElementById('evaluaciones');


validarFormulario = new ValidarFormulario(addFormulario);
validarFormulario.addInputArchivo();



ui.modalPreview(validarFormulario.inputs);

// evaluaciones.addEventListener('click', (event) => {
// 	switch (event.target.classList[0]) {
// 		// case 'btnEliminar':
// 		// 	ui.deleteContenido(event);
// 		// 	break;
// 		case 'btnModalEditar':
// 			ui.editContenido(event);
// 			break;
// 	}
// })