class ValidarFormulario {
	constructor(formulario){
		this.formulario = formulario;
		this.inputs = this.formulario.querySelectorAll('#add__blog input , #add__blog textarea');
		this.expresiones = {
			title: /^[\s\S]{1,1000}$/, // cualquier caracter de 1 a 1 mil 
			descripcion: /^[\s\S]{1,100000}$/, // cualquier caracter de tamaño 1 a 100 mil
			archivo: /(.pdf|.doc|.docx|.xlsx|.xls|.txt|.pptx|.ppt|.pub|.jpg|.jpeg|.gif|.png|.ai|.svg|.git|.psd|.raw|.mp4|.m4v|.mov|.mpg|.mpeg|.swf|.zip|.rar|.mp3|.wav|.opus|.PDF|.DOC|.DOCX|.XLSX|.XLS|.TXT|.PPTX|.PPT|.PUB|.JPG|.JPEG|.GIF|.PNG|.AI|.SVG|.GIT|.PSD|.RAW|.MP4|.M4V|.MOV|.MPG|.MPEG|.SWF|.ZIP|.RAR|.MP3|.WAV|.OPUS|.Pdf|.Doc|.Docx|.Xlsx|.Xls|.Txt|.Pptx|.Ppt|.Pub|.Jpg|.Jpeg|.Gif|.Png|.Ai|.Svg|.Git|.Psd|.Raw|.Mp4|.M4V|.Mov|.Mpg|.Mpeg|.Swf|.Zip|.Rar|.Mp3|.Wav|.Opus)$/i,
			size: ( 20 * 1024 ) * 1024
		}
		this.campos = {
			title: false,
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
			case "title":
				this.validarCampo(this.expresiones.title, e.target, 'title');
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
				this.inputs = this.formulario.querySelectorAll('#add__blog input , #add__blog textarea');
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
			if (this.campos.title && this.campos.descripcion && this.campos.file1 && this.campos.file2 && this.campos.file2 && this.campos.file4 ) {
				let btnSubmit = formulario.querySelector('#btnSubmit');
				btnSubmit.disabled = true;

				let editarDescripcion = formulario.querySelector('#editor .ql-editor');
				let descripcion = formulario.querySelector('#descripcion');
				descripcion.innerHTML = editarDescripcion.innerHTML;

				const formData = new FormData(e.currentTarget);
				let direccion = `${URL}blog/add/${formData.get('materia')}`;
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


							let f = new Date();
							let fecha = f.getDate() + "-" + (f.getMonth() +1) + "-" + f.getFullYear();
							let blogs = document.getElementById('blogs');
							blogs.innerHTML += `
							<section class="blog" data-blog=${datos.idBlog}>
								<div class="titulo">
									<div class="titulo_izq">
										<h4>${formData.get('title')}</h4>
										<span><small><small>Fecha: ${fecha}</small></small></span>
									</div>
									<div class="titulo_der">
										<div class="enlaces">
											<button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-blog="${datos.idBlog}"></button>
											<button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="${formData.get('materia')}" data-blog="${datos.idBlog}" type="button" ></button>
										</div>
									</div>
								</div>
								<div class="contenido">
									<div class="descripcion__qe">${formData.get('descripcion')}</div>
									${divArchivos}
								</div>
							</section>
							`;

							let aa = blogs.querySelector(`section.blog[data-blog="${datos.idBlog}"] .descripcion__qe`);
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

class ValidarFormularioEditar  extends ValidarFormulario{
	constructor(formulario) {
		super(formulario)
		this.inputs = this.formulario.querySelectorAll('#edit__blog input , #edit__blog textarea');
		this.campos = {
			title: true,
			descripcion: true,
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
			if (this.campos.title && this.campos.descripcion && this.campos.file1 && this.campos.file2 && this.campos.file2 && this.campos.file4 ) {
				let btnSubmit = formulario.querySelector('#btnSubmit__edit');
				btnSubmit.disabled = true;

				let editarDescripcion = formulario.querySelector('#editor__edit > .ql-editor').innerHTML;
				let descripcion = formulario.querySelector('#descripcion__edit');
				descripcion.value = editarDescripcion;

				const formData = new FormData(e.currentTarget);
				let direccion = `${URL}blog/edit/${formData.get('materia')}`;
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


							let editado = document.querySelector('section.blog[data-blog="'+datos.idBlog+'"]');
							let fecha = editado.querySelector('.titulo > .titulo_izq > span > small').innerHTML;
							let titulo = document.createElement('div');
							titulo.classList.add('titulo');
							titulo.innerHTML = `
								<div class="titulo_izq">
									<h4>${formData.get('title')}</h4>
									<span><small><small>${fecha}</small></small></span>
								</div>
								<div class="titulo_der">
									<div class="enlaces">
										<button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-blog="${datos.idBlog}"></button>
										<button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="${formData.get('materia')}" data-blog="${datos.idBlog}" type="button" ></button>
									</div>
								</div>
							`;
							let conten = document.createElement('div');
							conten.classList.add('contendio');
							conten.innerHTML = `
								<div class="descripcion__qe">${formData.get('descripcion')}</div>
								${divArchivos}
							`;
							console.log(document.querySelectorAll('section.contenido'));
							console.log('arriba');

							editado.innerHTML = "";
							editado.appendChild(titulo);
							editado.appendChild(conten);

							let mensajeError = formulario.querySelector('.mensaje__exito');
							mensajeError.innerHTML = '<p>'+datos.respuesta+'</p>';
							mensajeError.classList.add('mensaje__exito-activo');

							mensajeError.scrollIntoView({behavior:'auto',block:'center'});

							let refrescar = editado.querySelector('.descripcion__qe');
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
		const titulo = section.querySelector('.titulo > .titulo_izq > h4').innerHTML;
		const descripcion = section.querySelector('.contenido > .descripcion__qe > div.ql-editor').innerHTML;
		
		
		validarFormularioEditar.inputs.forEach( input => {
			switch (input.name) {
				case 'title':
					input.value = titulo;
					break;
				case 'descripcion':
					let editarDescripcion = document.querySelector('#editor__edit > .ql-editor');
					editarDescripcion.innerHTML = descripcion;
					input.value = descripcion;
					break;
				case 'blog':
					input.value = e.target.dataset.blog;
					break;
				case 'file[]':
					let n = input.classList[0];


					if ( n == 'file1' ) {
						let link = section.querySelector('.link1');
						if ( link != null ) {
							document.getElementById('link1').innerHTML = `<a href="${link.href}" download>Material 1</a>`;
						}else{
							document.getElementById('link1').innerHTML = 'NO HAY ARCHIVO CARGADO';
						}
					}else if( n == 'file2' ){
						let link = section.querySelector('.link2');
						if ( link != null ) {
							document.getElementById('link2').innerHTML = `<a href="${link.href}" download>Material 2</a>`;
						}else{
							document.getElementById('link2').innerHTML = 'NO HAY ARCHIVO CARGADO';
						}
					}else if( n == 'file3' ){
						let link = section.querySelector('.link3');
						if ( link != null ) {
							document.getElementById('link3').innerHTML = `<a href="${link.href}" download>Material 3</a>`;
						}else{
							document.getElementById('link3').innerHTML = 'NO HAY ARCHIVO CARGADO';
						}
					} else if( n == 'file4'){
						let link = section.querySelector('.link4');
						if ( link != null ) {
							document.getElementById('link4').innerHTML = `<a href="${link.href}" download>Material 4</a>`;
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
		let blog = e.target.dataset.blog;

		let eliminar = confirm('Deseas eliminar el post del blog?');
		if( eliminar ) {
			let direccion = `${URL}blog/delete/${materia}/${blog}`;
			let xmlhttp = new XMLHttpRequest();

			xmlhttp.onreadystatechange = function() {
				if ( this.readyState == 4 && this.status == 200 ) {
					// TODO FUE CORRECTO
					let datos = JSON.parse(xmlhttp.response);
					if ( datos.status == true ) {
						let sectionBlog = e.target.parentNode.parentNode.parentNode.parentNode;
						let sectionesBlogs = e.target.parentNode.parentNode.parentNode.parentNode.parentNode;
						sectionesBlogs.removeChild(sectionBlog);

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

		const previewTitle = document.getElementById('preview__title');
		const previewDescripcion = document.querySelector('#preview__descripcion > .ql-editor');
		const previewArchivos = document.getElementById('preview__archivos');

		btnModalPreview.addEventListener('click', () => {
			modal.style.display = 'block';
			previewTitle.innerHTML = `<h4>${inputs[0].value}<h4><br/>`;
			previewDescripcion.innerHTML = document.querySelector('#editor > .ql-editor').innerHTML;
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
		let contenidoDescripcion = document.querySelectorAll('.descripcion__qe');
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
			let descripcion =  document.getElementById('descripcion');
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
		const quill4 = new Quill('#editor__edit',{
			modules:{
				toolbar: toolbarOptions
			},
			theme: 'snow'
		});
		quill4.on('text-change', function (delta, old, source) {
			if ( (quill4.getLength()-1) > limit) {
				quill4.deleteText(limit, quill4.getLength());
			}else{
				document.getElementById('editor_caracteres__edit').innerHTML = quill4.getLength() - 1;
			}
		});
	}
}



const ui = new UI();

const editFormulario = document.getElementById('edit__blog');
const validarFormularioEditar = new ValidarFormularioEditar(editFormulario);

const addFormulario = document.getElementById('add__blog');
const blogs = document.getElementById('blogs');

validarFormulario = new ValidarFormulario(addFormulario);
validarFormulario.addInputArchivo();



ui.modalPreview(validarFormulario.inputs);
blogs.addEventListener('click', (event) => {
	switch (event.target.classList[0]) {
		case 'btnEliminar':
			ui.deleteContenido(event);
			break;
		case 'btnModalEditar':
			ui.editContenido(event);
			break;
	}
})