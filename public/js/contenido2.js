const formulario = document.getElementById('add_contenido');
const formularioEditar = document.getElementById('editar_contenido');

inputs = document.querySelectorAll('#add_contenido input , #add_contenido textarea');
inputsEditar = document.querySelectorAll('#editar_contenido input , #editar_contenido textarea');
const addInputArchivo = document.getElementById('add_input_archivo');
const editarInputArchivo = document.getElementById('editar_input_archivo');


const expresiones = {
	numero: /^\d{1,4}$/, // 7 a 14 numeros.
	message: /^[\s\S]{1,100000}$/, // cualquier caracter de tamaño 1 a 20
	archivo: /(.pdf|.doc|.docx|.xlsx|.xls|.txt|.pptx|.ppt|.pub|.jpg|.jpeg|.gif|.png|.ai|.svg|.git|.psd|.raw|.mp4|.m4v|.mov|.mpg|.mpeg|.swf|.zip|.rar|.mp3|.wav|.opus|.PDF|.DOC|.DOCX|.XLSX|.XLS|.TXT|.PPTX|.PPT|.PUB|.JPG|.JPEG|.GIF|.PNG|.AI|.SVG|.GIT|.PSD|.RAW|.MP4|.M4V|.MOV|.MPG|.MPEG|.SWF|.ZIP|.RAR|.MP3|.WAV|.OPUS|.Pdf|.Doc|.Docx|.Xlsx|.Xls|.Txt|.Pptx|.Ppt|.Pub|.Jpg|.Jpeg|.Gif|.Png|.Ai|.Svg|.Git|.Psd|.Raw|.Mp4|.M4V|.Mov|.Mpg|.Mpeg|.Swf|.Zip|.Rar|.Mp3|.Wav|.Opus)$/i
}

const campos = {
	numero: false,
	message: true,
	file1: true,
	file2: true,
	file3: true,
	file4: true,
}

const camposEditar = {
	numero: true,
	message: true,
	file1: true,
	file2: true,
	file3: true,
	file4: true,
}

const validarFormulario = (e) => {
	switch (e.target.name) {
		case "numero":
			validarCampo(expresiones.numero, e.target, 'numero');
			break;
		case "message":
			validarCampo(expresiones.message, e.target, 'message');
			break;
	}
}

const validarArchivo = (e) => {
	switch (e.target.classList[0]) {
		case "file1":
			validarCampoArchivo(expresiones.archivo, e.target, 'file1', (e.target.files[0])?e.target.files[0].size : null );
			break;
		case "file2":
			validarCampoArchivo(expresiones.archivo, e.target, 'file2', (e.target.files[0])?e.target.files[0].size : null);
			break;
		case "file3":
			validarCampoArchivo(expresiones.archivo, e.target, 'file3', (e.target.files[0])?e.target.files[0].size : null);
			break;
		case "file4":
			validarCampoArchivo(expresiones.archivo, e.target, 'file4', (e.target.files[0])?e.target.files[0].size : null);
			break;
	}
}

const validarCampo = (expresion, input, campo) => {
	if ( expresion.test(input.value) ) {
		// document.getElementById(`${campo}`).classList.remove('incorrecto');
		// document.getElementById(`${campo}`).classList.add('correcto');
		input.classList.remove('incorrecto');
		input.classList.add('correcto');
		
		if (input.parentNode.parentNode.id == 'add_contenido') {
			campos[campo] = true;
		}else{
			camposEditar[campo] = true;
		}
		//campos[campo] = true;
		// grupo = document.getElementById(`${campo}`).parentNode;
		grupo = input.parentNode;
		grupo.querySelector('.formulario__input-error').classList.remove('formulario__input-error-activo');
	}else{
		// document.getElementById(`${campo}`).classList.remove('correcto');
		// document.getElementById(`${campo}`).classList.add('incorrecto');
		input.classList.remove('correcto');
		input.classList.add('incorrecto');

		if (input.parentNode.parentNode.id == 'add_contenido') {
			campos[campo] = false;
		}else{
			camposEditar[campo] = false;
		}
		//campos[campo] = false;
		// grupo = document.getElementById(`${campo}`).parentNode;
		grupo = input.parentNode;
		grupo.querySelector('.formulario__input-error').classList.add('formulario__input-error-activo');
	}
}


const validarCampoArchivo = (expresion, input, campo, size) => {
	mb = ( 20 * 1024 ) * 1024;
	if ( expresion.test(input.value) || input.value == "" ) {
		if( size < mb || size == null){
			// document.getElementById(`${campo}`).classList.remove('incorrecto');
			// document.getElementById(`${campo}`).classList.add('correcto');
			input.classList.remove('incorrecto');
			input.classList.add('correcto');

			if (input.parentNode.parentNode.parentNode.id == 'add_contenido') {
				campos[campo] = true;
			}else{
				camposEditar[campo] = true;
			}
			//campos[campo] = true;
			// error = document.getElementById(`${campo}`).nextElementSibling;
			error = input.nextElementSibling;
			error.classList.remove('formulario__input-error-activo');
		}else{
			// document.getElementById(`${campo}`).classList.remove('correcto');
			// document.getElementById(`${campo}`).classList.add('incorrecto');
			input.classList.remove('correcto');
			input.classList.add('incorrecto');

			// error = document.getElementById(`${campo}`).nextElementSibling;
			error = input.nextElementSibling;
			error.innerHTML = '<span>* El archivo excede el tamaño permitido 20mb.</span><br>';
			error.classList.add('formulario__input-error-activo');
			
			if (input.parentNode.parentNode.parentNode.id == 'add_contenido') {
				campos[campo] = false;
			}else{
				camposEditar[campo] = false;
			}
			//campos[campo] = false;
		}
		
	}else{
		// document.getElementById(`${campo}`).classList.remove('correcto');
		// document.getElementById(`${campo}`).classList.add('incorrecto');
		input.classList.remove('correcto');
		input.classList.add('incorrecto');
		// error = document.getElementById(`${campo}`).nextElementSibling;
		error = input.nextElementSibling;
		error.innerHTML = '<span>* Formato de archivo No valido.</span><br>';
		error.classList.add('formulario__input-error-activo');
		
		if (input.parentNode.parentNode.parentNode.id == 'add_contenido') {
			campos[campo] = false;
		}else{
			camposEditar[campo] = false;
		}
		//campos[campo] = false;
	}
}


function recorreInputs(inputs) {
	inputs.forEach( (input) => {
		input.addEventListener('keyup', validarFormulario);
		input.addEventListener('blur', validarFormulario);
		input.addEventListener('change', validarFormulario);
		if (input.name === 'file[]') {
			input.addEventListener('change', validarArchivo);
		}
	});
}
recorreInputs(inputs);
recorreInputs(inputsEditar);


inputArchivos = 1;
addInputArchivo.addEventListener('click', (e) => {
	if ( inputArchivos < 4 ) {
		inputArchivos++;
		document.getElementById('grupo_archivos').innerHTML += '<input type="file" name="file[]" id="file'+inputArchivos+'" class="file'+inputArchivos+'"> <p class="formulario__input-error"></p>';
		inputs = document.querySelectorAll('#add_contenido input , #add_contenido textarea');
		recorreInputs(inputs);
	}else {
		addInputArchivo.disabled = true;
	}
});



////////////////// AGREGAR CONTENDIOS A LA BASE DE DATOS Y A LA VISTA //////////////////
formulario.addEventListener('submit', (e) => {
	e.preventDefault();

	if (campos.numero && campos.message && campos.file1 && campos.file2 && campos.file2 && campos.file4 ) {
		const btnSubmit = document.getElementById('btnSubmit');
		btnSubmit.disabled = true;
		
		const formData = new FormData(e.currentTarget);
		
		let xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if ( this.readyState == 4 && this.status == 200 ) {
				// TODO FUE CORRECTO
				let datos = JSON.parse(xmlhttp.response);
				if ( datos.status == true ) {
					let contenidos = document.getElementById('contenido').innerHTML += datos.html;
					EliminarContenido();
					CreateQuillEditorContendio();
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

		let direccion = URL+'contenido/add/'+formData.get('materia')
		xmlhttp.open('POST', direccion);
		xmlhttp.send(formData);
		

	}else{
		let mensajeError = formulario.querySelector('.mensaje__error');
		mensajeError.innerHTML = '<p>No se puedo guardar, por favor revise todo los campos y verifique que no tengan ningun error</p>';
		mensajeError.classList.add('mensaje__error-activo');
	}

});






//////////////////////// ELIMINAR ///////////////////////

function EliminarContenido() {
	const btnsEliminar = document.querySelectorAll('.btnEliminar');
	btnsEliminar.forEach( (btnEliminar) => {
		btnEliminar.addEventListener('click', (e) => {
			let materia = e.target.dataset.materia;
			let contenido = e.target.dataset.contenido;
			let objetivo = e.target.dataset.objetivo;

			eliminar = confirm('Deseas eliminar del contendio el objetivo numero: ' + objetivo );
		
			if ( eliminar )  {
				fetch(URL+'contenido/delete/'+materia+'/'+contenido+'/'+objetivo,{
					method: 'GET'
				}).then( response => {
					if ( response.ok) {
						return response.text();
					}else{
						throw "ERROR EN LA LLAMADA";
					}
					
				}).then( data => {
					let datos = JSON.parse(data);
					if ( datos.status == true ){
						let sectionesContenido = document.getElementById('contenido');
						let sectionContenido = sectionesContenido.querySelector(`section.contenido[data-contenido="${contenido}"]`);
						sectionesContenido.removeChild(sectionContenido);
					}
				}).catch( error => {
					console.log(error);
				})
			}
		});
	});
}
EliminarContenido();

//////// CREAR QUILL EDITOR PARA TODOS LOS CONTENIDOS
const CreateQuillEditorContendio = () =>{
	var contenidoDescripcion = document.querySelectorAll('.contenido__descripcion');
	contenidoDescripcion.forEach( contenidos => {
		var quill3 = new Quill(contenidos,{
			readOnly: true,
			theme: 'bubble'
		});
	});
}
CreateQuillEditorContendio();











const ModalPreview = () => {
	const btnModalPreview = document.getElementById('btnModalPreview');
	const btnCerrar = document.getElementById('btnCerrarPreview');
	const flex = document.getElementById('flexPreview');
	const modalPreview = document.getElementById('modalPreview');

	const previewNumero = document.getElementById('preview__numero');
	const previewArchivos = document.getElementById('preview__archivos');

	btnModalPreview.addEventListener('click', () => {
		modalPreview.style.display = 'block';
		previewNumero.innerHTML = '<p>Objetivo Numero: '+inputs[0].value+'<p>';
	});
	btnCerrar.addEventListener('click', () => {
		modalPreview.style.display = 'none';
	});
	flex.addEventListener('click', (e) => {
		if ( e.target == flex) {
			modalPreview.style.display = 'none';
		}
	});
}
ModalPreview();



const ModalEditar = () => {
	const btnsModalEditar = document.querySelectorAll('.btnModalEditar');
	const btnCerrar = document.getElementById('btnCerrarEditar');
	const flex = document.getElementById('flexEditar');
	const modalEditar = document.getElementById('modalEditar');
	//const editarNumero = formularioEditar.getElementById('editar__numero');
	//const editarMessage = document.getElementById('editar__message');

	const editarArchivos = document.getElementById('editar__archivos');

	let mensajeError = modalEditar.querySelector('.mensaje__error');
	let mensajeExito = modalEditar.querySelector('.mensaje__exito');
	mensajeError.classList.remove('mensaje__error-activo');
	mensajeExito.classList.remove('mensaje__exito-activo');

	camposEditar['numero'] = true;
	camposEditar['message'] = true;
	camposEditar['file1'] = true;
	camposEditar['file2'] = true;
	camposEditar['file3'] = true;
	camposEditar['file4'] = true;

	inputsEditar.forEach(input => {
		input.classList.remove('incorrecto');
		input.classList.remove('correcto');
		let grupo = input.parentNode.querySelector('.formulario__input-error');
		if ( grupo ) {
			grupo.classList.remove('formulario__input-error-activo');
		}
	});

	btnsModalEditar.forEach( btnModalEditar => {
		btnModalEditar.addEventListener('click', (e) => {
			modalEditar.style.display = 'block';
			const btnSubmit = document.getElementById('btnSubmitEditar');
			btnSubmit.disabled = false;

			//PRUEBA 
			const section = e.target.parentNode.parentNode.parentNode.parentNode;
			const numero = section.querySelector('span.objetivo__numero');
			const qlEditor = section.querySelector('.ql-editor');
			
			// let padre = document.getElementById('grupo_archivos_editar');
			// let link1 = padre.querySelector('.link1');
			// padre.removeChild(link1);

			inputsEditar.forEach(input => {
				
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

		});
	});
	
	
	btnCerrar.addEventListener('click', () => {
		modalEditar.style.display = 'none';
		ModalEditar();
	});
	flex.addEventListener('click', (e) => {
		if ( e.target == flex) {
			modalEditar.style.display = 'none';
			ModalEditar();
		}
		
	});
}
ModalEditar();



/////////////////// ENVIAR DATOS DE FORMULARIO EDITAR CONTENDIA VIA XMLHTTPREQUEST A PHP //////////

formularioEditar.addEventListener('submit', (e) => {
	e.preventDefault();

	if (camposEditar.numero && camposEditar.message && camposEditar.file1 && camposEditar.file2 && camposEditar.file2 && camposEditar.file4 ) {
		const btnSubmit = document.getElementById('btnSubmitEditar');
		btnSubmit.disabled = true;



		let editarDescripcion = document.querySelector('#editar__descripcion .ql-editor');

		let message = formularioEditar.querySelector('#message__editar');
		message.innerHTML = editarDescripcion.innerHTML;


		const formData = new FormData(e.currentTarget);
	
		let xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if ( this.readyState == 4 && this.status == 200 ) {
				// TODO FUE CORRECTO
				let datos = JSON.parse(xmlhttp.response);
				debugger
				if ( datos.status == false ) {
					
					let contenidoEditado = document.querySelector('section.contenido[data-contenido="'+formData.get('contenido')+'"]').innerHTML = datos.html;
					
					let mensajeError = formularioEditar.querySelector('.mensaje__exito');
					mensajeError.innerHTML = '<p>'+datos.respuesta+'</p>';
					mensajeError.classList.add('mensaje__exito-activo');

					mensajeError.scrollIntoView({behavior:'auto',block:'center'});

					EliminarContenido();
					CreateQuillEditorContendio();
					console.log('if');
				} else {
					let mensajeError = formularioEditar.querySelector('.mensaje__error');
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

		let direccion = URL+'contenido/edit/'+formData.get('materia')
		xmlhttp.open('POST', direccion);
		xmlhttp.send(formData);
		

	}else{
		let mensajeError = formularioEditar.querySelector('.mensaje__error');
		mensajeError.innerHTML = '<p>No se puedo guardar, por favor revise todo los campos y verifique que no tengan ningun error</p>';
		mensajeError.classList.add('mensaje__error-activo');
	}

});
