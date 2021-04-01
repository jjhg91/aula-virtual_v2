import ValidarFormulario from "./class/validarFormulario.js";
import ValidarFormularioEditar from "./class/validarFormularioEditar.js";


class ValidarFormulario2 {
	constructor(formulario){
		this.formulario = formulario;
		this.inputs = this.formulario.querySelectorAll(`
			#add_plan input,
			#add_plan textarea,
			#add_plan > div > select,
			#add_plan select#lapso_form
		`);
			
		this.expresiones = {
			tipo: /^\d{1,6}$/,
			otros: /^[\s\S]{0,500}$/,
			valor: /^\d{1,3}$/,
			semana: /^\d{1,3}$/,
			descripcion: /^[\s\S]{1,100000}$/,
			lapso_form: /^(1|2|3)$/i
		}
		this.campos = {
			tipo: false,
			otros: true,
			valor: true,
			semana: false,
			descripcion: true,
			lapso_form: true,
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
			case "tipo":
				this.validarCampo(this.expresiones.tipo, e.target, 'tipo', parseInt(e.target.value));
				break;
			case "otros":
				this.validarCampo(this.expresiones.otros, e.target, 'otros', e.target.value);
				break;
			case "valor":
				this.validarCampo(this.expresiones.valor, e.target, 'valor', parseInt(e.target.value));
				break;
			case "semana":
				this.validarCampo(this.expresiones.semana, e.target, 'semana', parseInt(e.target.value));
				break;
			case "descripcion":
				this.validarCampo(this.expresiones.descripcion, e.target, 'descripcion', e.target.value);
				break;
			case "lapso_form":
				this.validarCampo(this.expresiones.lapso_form, e.target, 'lapso_form', e.target.value);
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


	sendFormulario(){
		const formulario = this.formulario;
		formulario.addEventListener('submit', (e) => {
			e.preventDefault();
			if (this.campos.tipo && this.campos.otros && this.campos.valor && this.campos.semana && this.campos.descripcion ) {
				let btnSubmit = formulario.querySelector('#btnSubmit');
				btnSubmit.disabled = true;

				let editarDescripcion = formulario.querySelector('#editor .ql-editor');
				let descripcion = formulario.querySelector('#descripcion_evaluacion');
				descripcion.innerHTML = editarDescripcion.innerHTML;

				const formData = new FormData(e.currentTarget);
				let direccion = URL+'plan/add/'+formData.get('mat');
				let xmlhttp = new XMLHttpRequest();

				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
						// TODO FUE CORRECTO

						let datos = JSON.parse(xmlhttp.response);
						console.log(datos);
						
						if ( datos.status == true ) {
							let planes = document.querySelector(`#planes .lapso-${formData.get('lapso_form')} .box-contenidos-lapso`);
							// let planes = document.getElementById('planes');

							let tipo = formulario.querySelector('.tipo').options[formulario.querySelector('.tipo').selectedIndex].text;
							let otros = formulario.querySelector('.otros').value;
							let valor = formulario.querySelector('.valor') != null ? formulario.querySelector('.valor').options[formulario.querySelector('.valor').selectedIndex].text : null ;
							console.log(`valor es igual a: ${valor}`);
							let tit = (tipo === 'otros') ? otros: tipo;
							
							planes.innerHTML += `
								<section class="plan_evaluacion" data-plan="${datos.idPlan}">
									<div class="titulo">
										<div class="titulo_izq">
											<h4>${tit}</h4>
										</div>
										<div class="titulo_der">
											<div class="enlaces">
												<button
													title="Editar"
													class="btnModalEditar item icon-pencil btnInfo"
													type="button"
													data-plan="${datos.idPlan}"></button>
												<button
													title="Eliminar"
													class="btnEliminar icon-bin btnInfo"
													data-materia="${datos.materia}"
													data-plan="${datos.idPlan}"
													type="button"></button>
											</div>
										</div>
									</div>
									<div class="contenido">
										<span class="semana"><small>Semana 2</small></span>
										<br/>
										<span class="valor"><small><strong>Valor: </strong><span>20pts</span></small></span>
										<br/>
										<br/>
										<p><strong>Descripcion: </strong><p>
										<div class="descripcion">${formData.get('descripcion')}</div>
									</div>
								</section>
							`;

						
							let aa = planes.querySelector(`section.plan_evaluacion[data-plan="${datos.idPlan}"] .descripcion`);
							let quill = new Quill(aa, {
								readOnly: true,
								theme: 'bubble'
							});
							
							var mensajeError = formulario.querySelector('.mensaje__exito');
							mensajeError.innerHTML = '<p>'+datos.respuesta+'</p>';
							mensajeError.classList.add('mensaje__exito-activo');
							mensajeError.scrollIntoView({behavior:'auto',block:'center'});
						} else {
							console.log('hola');
							let mensajeError = formulario.querySelector('.mensaje__error');
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

class ValidarFormularioEditar2  extends ValidarFormulario2{
	constructor(formulario) {
		super(formulario)
		this.inputs = this.formulario.querySelectorAll('#edit__plan input , #edit__plan textarea , #edit__plan > div > select');
		this.campos = {
			tipo: true,
			otros: true,
			valor: true,
			semana: true,
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

			if (this.campos.tipo && this.campos.otros && this.campos.valor && this.campos.semana && this.campos.descripcion ) {
				let btnSubmit = formulario.querySelector('#btnSubmit__edit');
				btnSubmit.disabled = true;

				let editarDescripcion = formulario.querySelector('#edit__qe > .ql-editor').innerHTML;

				let descripcion = formulario.querySelector('#edit__descripcion');
				descripcion.innerHTML = editarDescripcion;

				const formData = new FormData(e.currentTarget);
				let direccion = `${URL}plan/edit/${formData.get('materia')}`;
				let xmlhttp = new XMLHttpRequest();

				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
						// TODO FUE CORRECTO
						let datos = JSON.parse(xmlhttp.response);
						if ( datos.status == true ) {
							let editado = document.querySelector('section.plan_evaluacion[data-plan="'+formData.get('plan')+'"]');
							let titulo = document.createElement('div');

							let tipoo = formulario.querySelector('select[name="tipo"]').options[formData.get('tipo') - 1 ].innerHTML;
							

							titulo.classList.add('titulo');
							titulo.innerHTML = `
								<div class="titulo_izq">
									<h4>${(formData.get('tipo') == 8)? formData.get('otros'):tipoo}</h4>
								</div>
									<div class="titulo_der">
									<div class="enlaces">
										<button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-plan="${formData.get('plan')}"></button>
										<button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="${formData.get('materia')}" data-plan="${formData.get('plan')}" type="button"></button>
									</div>
								</div>
							`;
							let conten = document.createElement('div');
							conten.classList.add('contenido');
							conten.innerHTML = `
								<span class="semana"><small>Semana ${formData.get('semana')}</small></span>
								<br>
								<span class="valor"><small><strong>Valor: </strong><span>20pts</span></small></span>
								<br>
								<br>
								<p><strong>Descripcion: </strong></p>
								<div class="descripcion">${formData.get('descripcion')}</div>
							`;



							editado.innerHTML = "";
							editado.appendChild(titulo);
							editado.appendChild(conten);
							
							let refrescar = editado.querySelector('.contenido > .descripcion');
							let quill3 = new Quill(refrescar,{
								readOnly: true,
								theme: 'bubble'
							});

							let mensajeError = formulario.querySelector('.mensaje__exito');
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
	constructor(materia){
		this.materia = materia;
		this.showData();
		this.contenidosQE();
		this.previewQE();
		this.addQE();
		this.editQE();
		
	}

	showData() {
		let contenidosQE = () => {
		    var contenidoDescripcion = document.querySelectorAll('.descripcion__qe');
		    contenidoDescripcion.forEach( contenidos => {
			    var quill3 = new Quill(contenidos,{
				    readOnly: true,
				    theme: 'bubble'
			    });
		    });
	    }

		let direccion = `${URL}plan/getPlanes/${materia}`;
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
					var botones = "";

					if(datos.user === 'profesor'){
						botones = `
						<div class="enlaces">
							<button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-plan="${dato.id_plan_evaluacion}"></button>
							<button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="${dato.id_profesorcursogrupo}" data-plan="${dato.id_plan_evaluacion}" type="button" ></button>
						</div>
						`;
					}
					let html = `
						<section class="plan_evaluacion" data-plan="${dato.id_plan_evaluacion}">
							<div class="titulo">
								<div class="titulo_izq">
									<h4>${dato.tipo_evaluacion !== 'otros' ? dato.tipo_evaluacion : dato.otros }</h4>
								</div>
			
								<?php if($_SESSION['user'] == 'profesor'): ?>
								<div class="titulo_der">
									${botones}
								</div>
								<?php endif; ?>
							</div>
							<div class="contenido">
								<span class="semana"><small>${dato.semana}</small></span>
								<br>
							
								
			
								<br>
								<br>
								<p><strong>Descripcion: </strong></p>
								<div class="descripcion__qe">
									${dato.descripcion}
								</div>
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

		const tipo = section.querySelector('.titulo > .titulo_izq > h4').innerHTML;
		// const valor = section.querySelector('.valor > small > span').innerHTML;
		const semana = section.querySelector('.semana > small').innerHTML;
		const descripcion = section.querySelector('.contenido > .descripcion__qe > .ql-editor').innerHTML;
		
		const qEditor = document.querySelector('#editar__descripcion .ql-editor');
		
		validarFormularioEditar.inputs.forEach( input => {
			switch (input.name) {
				case 'tipo':
					let otros = true;
					for ( let option of input.options ) { 
						// console.log(option.text);
						// console.log(tipo);
						if ( option.text == tipo ){
							option.selected = true;
							otros = false;
						}
					}
					if (otros == true){
						input.options[7].selected = true;
						validarFormularioEditar.inputs[1].parentNode.classList.remove('oculto');
						validarFormularioEditar.inputs[1].value = tipo;
					}else{
						validarFormularioEditar.inputs[1].parentNode.classList.add('oculto');
						validarFormularioEditar.inputs[1].value = "";
					}
					
					break;
				// case 'valor':
				// 	for ( let option of input.options ) {
				// 		if ( option.text == valor ){
				// 			option.selected = true;
				// 		}
				// 	}
				// 	break;
				case 'semana':
					for ( let option of input.options ) {
						if ( option.text == semana ){
							option.selected = true;
						}
					}
					break;
				case 'descripcion':
					qEditor.innerHTML = descripcion;
					break;
				case 'plan':
					input.value = section.dataset.plan;
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
		let plan = e.target.dataset.plan;

		let objetivos = e.target.parentNode.parentNode.parentNode.parentNode;
		let tipo = objetivos.querySelector('div.titulo div.titulo_izq h4').innerHTML;
		let semana = objetivos.querySelector('div.contenido span.semana small').innerHTML;

		let eliminar = confirm(`Deseas eliminar del plan de evaluacion la evaluacion: ${tipo} de la ${semana}` );

		let showData = this.showData;

		if( eliminar ) {
			let planEliminar = e.target.parentNode.parentNode.parentNode.parentNode;
			let direccion = `${URL}plan/delete/${materia}/${plan}`;
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

		const previewTipo = document.getElementById('preview__tipo');
		const previewSemana = document.getElementById('preview__semana');
		const previewValor = document.getElementById('preview__valor');
		const previewPuntos = document.getElementById('preview__puntos');
		const previewDescripcion = document.getElementById('preview__descripcion2');

		btnModalPreview.addEventListener('click', () => {
			let tipo = inputs[0].options[inputs[0].selectedIndex].text;
			let otros = inputs[1].value;
			let semana = inputs[3].options[inputs[3].selectedIndex].text;
			let valor = inputs[2].options[inputs[2].selectedIndex].text;
			let puntos = ((inputs[2].selectedIndex+1) * 1);
			
			modal.style.display = 'block';
			previewTipo.innerHTML = `<p><strong>Tipo evaluacion: </strong> ${(tipo === 'otros')? otros : tipo}</p>`;
			previewSemana.innerHTML = `<p><small> ${semana}</small></p>`;
			previewValor.innerHTML = `<p><small><strong>Valor:</strong> ${valor}</small></p>`;
			previewPuntos.innerHTML = `<p><small><strong>Puntos:</strong> ${puntos}pts</small></p>`;
			previewDescripcion.innerHTML = `<br/><p><strong>Descripcion :</p></strong>`;

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
		var contenidoDescripcion = document.querySelectorAll('.descripcion');
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
			console.log('Text change!');
			let prueba =  document.querySelector('#preview__descripcion > div');
			let descripcion =  document.getElementById('descripcion');
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
				document.getElementById('edit_caracteres').innerHTML = quill4.getLength() - 1;
			}
		});
	}

	addOtros(inputs){
		inputs[0].addEventListener('change', (e) => {
			let tipo = inputs[0].options[inputs[0].selectedIndex].text;
			if (tipo === 'otros') {
				inputs[1].parentNode.classList.remove('oculto');
			}else {
				inputs[1].parentNode.classList.add('oculto');
			}
		});
	}
}



var url = window.location;
url = url.pathname.split('/');
var materia = url[url.length - 1];

const ui = new UI(materia);

const editFormulario = document.getElementById('edit__plan');
let urlEdit = `${URL}plan/edit/${materia}`;
let camposEdit = {
	tipo: true,
	otros: true,
	valor: true,
	semana: true,
	descripcion: true,
	lapso_form: true,
}
const validarFormularioEditar = new ValidarFormularioEditar(editFormulario,ui.showData,camposEdit,urlEdit);

const addFormulario = document.getElementById('add_plan');
const planes = document.getElementById('planes');


let urlAdd = `${URL}plan/add/${materia}`;
let camposAdd = {
	tipo: false,
	otros: true,
	valor: true,
	semana: false,
	descripcion: true,
	lapso_form: true,

}
const validarFormulario = new ValidarFormulario(addFormulario,ui.showData,camposAdd,urlAdd);




ui.modalPreview(validarFormulario.inputs);

ui.addOtros(validarFormulario.inputs);
ui.addOtros(validarFormularioEditar.inputs);

planes.addEventListener('click', (event) => {
	switch (event.target.classList[0]) {
		case 'btnEliminar':
			ui.deleteContenido(event);
			break;
		case 'btnModalEditar':
			ui.editContenido(event,validarFormularioEditar);
			break;
		default:
			break;
	}
})