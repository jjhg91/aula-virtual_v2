
class UI {
	constructor(materia){
		this.materia = materia;
		this.showData(this.materia);
		this.previewQE();
		this.addQE();
		this.editQE();
	}

	showData(materia) {

		let contenidosQE = () => {
		    var contenidoDescripcion = document.querySelectorAll('.contenido__descripcion');
		    contenidoDescripcion.forEach( contenidos => {
			    var quill3 = new Quill(contenidos,{
				    readOnly: true,
				    theme: 'bubble'
			    });
		    });
	    }

		let direccion = URL+`contenido/getContenidos/${materia}`;
		let xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if ( this.readyState == 4 && this.status == 200 ) {
				let datos = JSON.parse(xmlhttp.response);
				let lapso_1 = document.querySelector('.lapso-1 > .box-contenidos-lapso');
				let lapso_2 = document.querySelector('.lapso-2 > .box-contenidos-lapso');
				let lapso_3 = document.querySelector('.lapso-3 > .box-contenidos-lapso');
				
				lapso_1.innerHTML ="";
				lapso_2.innerHTML ="";
				lapso_3.innerHTML ="";

				datos.data.forEach(dato => {
						var archivos = "";
						var archivo_1 = "";
						var archivo_2 = "";
						var archivo_3 = "";
						var archivo_4 = "";
						var botones = "";
			
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
								<a class="link1" href="${URL}public/upload/contenido/${dato.id_profesorcursogrupo}/${dato.id_contenido}/${dato.file1}" download>Material 1</a>
								<br>
								<br>
							`;
						}
						if (dato.file2  !== null){
							archivo_2 = `
								<a class="link2" href="${URL}public/upload/contenido/${dato.id_profesorcursogrupo}/${dato.id_contenido}/${dato.file2}" download>Material 2</a>
								<br>
								<br>
							`;
						}
						if (dato.file3  !== null){
							archivo_3 = `
								<a class="link3" href="${URL}public/upload/contenido/${dato.id_profesorcursogrupo}/${dato.id_contenido}/${dato.file3}" download>Material 3</a>
								<br>
								<br>
							`;
						}
						if (dato.file4  !== null){
							archivo_4 = `
								<a class="link4" href="${URL}public/upload/contenido/${dato.id_profesorcursogrupo}/${dato.id_contenido}/${dato.file4}" download>Material 4</a>
								<br>
								<br>
							`;
						}

						if(datos.user === 'profesor'){
							botones = `
								<div class="enlaces">
									<button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-contenido="${dato.id_contenido}"></button>
									<button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="${dato.id_profesorcursogrupo}" data-contenido="${dato.id_contenido}" data-objetivo="${dato.numero}" type="button" ></button>
								</div>
							`;
						}

						let html = `
						<section class="contenido" data-contenido="${dato.id_contenido}" data-lapso="${dato.lapso}">
							<div class="titulo">
								<div class="titulo_izq">
									<h4>Objetivo <span class="objetivo__numero">${dato.numero}</span></h4>
								</div>

								<?php if($_SESSION['user'] == 'profesor'): ?>
								<div class="titulo_der ">
									${botones}
								</div>
								<?php endif; ?>

							</div>
							<div class="contenido ">
								<div class="contenido__descripcion">
									${dato.descripcion}
								</div>
							
							<!-- MOSTRAR ARCHIVOS  -->
								<div class="trabajos mostrar_archivos">
									${archivos}
									${archivo_1}
									${archivo_2}
									${archivo_3}
									${archivo_4}
								</div>
							<!-- /MOSTART ARCHIVOS  -->
							</div>
						</section>
						`;

					switch (dato.lapso) {
						case "1":
							lapso_1.innerHTML += html;
							break;
						case "2":
							lapso_2.innerHTML += html;
							break;
						case "3":
							lapso_3.innerHTML += html;
							break;
					}
					
				});
				contenidosQE();
			}
		}

		xmlhttp.open('GET', direccion);
		xmlhttp.send();
	}

	editContenido(e,validarFormularioEditar) {
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
				case 'descripcion':
					let editarDescripcion = document.querySelector('#editar__descripcion > .ql-editor');
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

	deleteContenido(e) {
		let materia = e.target.dataset.materia;
		let contenido = e.target.dataset.contenido;
		let objetivo = e.target.dataset.objetivo;
		let eliminar = confirm('Deseas eliminar del contendio el objetivo numero: ' + objetivo );
		let showData = this.showData;
		
		
		if( eliminar ) {
			let contenidoEliminar = e.target.parentNode.parentNode.parentNode.parentNode;
			let direccion = URL+'contenido/delete/'+materia+'/'+contenido+'/'+objetivo
			let xmlhttp = new XMLHttpRequest();
			
			xmlhttp.onreadystatechange = function() {
				if ( this.readyState == 4 && this.status == 200 ) {
					// TODO FUE CORRECTO
					let datos = JSON.parse(xmlhttp.response);
					if ( datos.status == true ) {
						showData(materia);
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

		const previewNumero = document.getElementById('preview__numero');
		const previewArchivos = document.getElementById('preview__archivos');

		btnModalPreview.addEventListener('click', () => {
			modal.style.display = 'block';
			previewNumero.innerHTML = '<p>Objetivo Numero: '+inputs[0].value+'<p>';
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
			// console.log('Text change!');
			let prueba =  document.querySelector('#preview__descripcion div');
			let descripcion =  document.getElementById('descripcion');
			//descripcion.innerHTML = quill.container.firstChild.innerHTML;
			descripcion.innerHTML = quill.container.firstChild.innerHTML;
			prueba.innerHTML = quill.container.firstChild.innerHTML;
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

export default UI;