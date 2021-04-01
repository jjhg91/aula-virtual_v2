import ValidarFormulario from "./validarFormulario.js";

class ValidarFormularioEditar  extends ValidarFormulario{
	constructor(formulario, showData, campos, url) {
		super(formulario,showData,campos,url);

		// this.inputs = this.formulario.querySelectorAll(`
		// 	#editar_contenido input,
		// 	#editar_contenido textarea
		// 	#add_contenido select#lapso_form
		// `);
		// this.campos = {
		// 	numero: true,
		// 	message: true,
		// 	file1: true,
		// 	file2: true,
		// 	file3: true,
		// 	file4: true,
		// 	lapso_form: true,
		// }
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
		const url = this.url;
		const showData = this.showData;
		const campos = this.campos; 
		formulario.addEventListener('submit', (e) => {
			e.preventDefault();
			
			let validar = true;
			for( const campo in this.campos) {
				if(campos[campo] === false){
					validar = false;
				}
			}

			if (validar === true) {
				let btnSubmit = formulario.querySelector('#btnSubmitEditar');
				btnSubmit.disabled = true;

				let editarDescripcion = formulario.querySelector('#editar__descripcion .ql-editor');
				let descripcion = formulario.querySelector('#descripcion__editar');
				descripcion.innerHTML = editarDescripcion.innerHTML;
				console.log(editarDescripcion);
				console.log('----aaaa-----');
				console.log(descripcion)

				const formData = new FormData(e.currentTarget);
				console.log(e.currentTarget);

				// let direccion = URL+'contenido/edit/'+formData.get('materia');
				let direccion = url;
				let xmlhttp = new XMLHttpRequest();

				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
						// TODO FUE CORRECTO
						let datos = JSON.parse(xmlhttp.response);
						if ( datos.status == true ) {
							
							showData(formData.get('materia'));
							
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

export default ValidarFormularioEditar;