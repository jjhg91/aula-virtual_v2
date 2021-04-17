class ValidarFormulario {
	constructor(formulario, showData, campos, url){
		this.formulario = formulario;
		this.showData = showData;
		this.campos = campos;
		this.url = url; 
		this.inputs = this.formulario.querySelectorAll(`
			input,
			textarea,
			div > select, 
			select#lapso_form
		`);
		
		this.expresiones = {
			numero: /^\d{1,4}$/, // 7 a 14 numeros.
			// message: /^[\s\S]{1,100000}$/, // cualquier caracter de tamaño 1 a 100 mil
			archivo: /(.pdf|.doc|.docx|.xlsx|.xls|.txt|.pptx|.ppt|.pub|.jpg|.jpeg|.gif|.png|.ai|.svg|.git|.psd|.raw|.mp4|.m4v|.mov|.mpg|.mpeg|.swf|.zip|.rar|.mp3|.wav|.opus|.PDF|.DOC|.DOCX|.XLSX|.XLS|.TXT|.PPTX|.PPT|.PUB|.JPG|.JPEG|.GIF|.PNG|.AI|.SVG|.GIT|.PSD|.RAW|.MP4|.M4V|.MOV|.MPG|.MPEG|.SWF|.ZIP|.RAR|.MP3|.WAV|.OPUS|.Pdf|.Doc|.Docx|.Xlsx|.Xls|.Txt|.Pptx|.Ppt|.Pub|.Jpg|.Jpeg|.Gif|.Png|.Ai|.Svg|.Git|.Psd|.Raw|.Mp4|.M4V|.Mov|.Mpg|.Mpeg|.Swf|.Zip|.Rar|.Mp3|.Wav|.Opus)$/i,
			size: ( 20 * 1024 ) * 1024,
			lapso_form: /^(1|2|3)$/i,

			title: /^[\s\S]{1,1000}$/, // cualquier caracter de 1 a 1 mil 
			descripcion: /^[\s\S]{1,100000}$/, // cualquier caracter de tamaño 1 a 100 mil
			tipo: /^\d{1,6}$/,
			otros: /^[\s\S]{0,500}$/,
			valor: /^\d{1,3}$/,
			semana: /^\d{1,3}$/,
			
			plan: /^\d{1,10}$/, // 7 a 14 numeros.
			fecha: /^(\d{4})\-(\d{2})\-(\d{2})$/,

			nota: /^[\w ]{1,10}$/, // 7 a 14 numeros.
			observacion: /^[\s\S]{1,100000}$/ // cualquier caracter de tamaño 1 a 20
		}
		this.campos = campos;
		// this.campos = {
		// 	numero: false,
		// 	message: true,
		// 	lapso_form: true,
		// 	file1: true,
		// 	file2: true,
		// 	file3: true,
		// 	file4: true
		// }
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
		for( const campo in this.campos) {
			if(e.target.name === campo){
				this.validarCampo(this.expresiones[campo], e.target, campo);
			} 
		}
		// switch (e.target.name) {
		// 	case "numero":
		// 		this.validarCampo(this.expresiones.numero, e.target, 'numero');
		// 		break;
		// 	case "message":
		// 		this.validarCampo(this.expresiones.message, e.target, 'message');
		// 		break;
		// }
	}

	validarCampo(expresion, input, campo) {
		let value = null;
		if(campo == 'semana' ||campo == 'tipo'){
			value = parseInt(input.value);
		}else{
			value = input.value;
		}
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
				document.getElementById('grupo_archivos').innerHTML += '<input type="file" name="file[]" id="file'+countInputs+'" class="file'+countInputs+'"> <p class="formulario__input-error"></p>';
				this.inputs = this.formulario.querySelectorAll('#add_contenido input , #add_contenido textarea');
				this.recorreInputs(this.inputs);
			}else {
				grupoInputs.disabled = true;
			}
		});
	}


	setiarFormulario(){
		var formulario = this.formulario; 
		var inputs = this.inputs; 
		
		let mensajeError = formulario.querySelector('.mensaje__error');
		let mensajeExito = formulario.querySelector('.mensaje__exito');
		mensajeError.classList.remove('mensaje__error-activo');
		mensajeExito.classList.remove('mensaje__exito-activo');
		// const btnSubmit = document.getElementById('btnSubmitEditar');
		// btnSubmit.disabled = false;

		inputs.forEach(input => {
			input.classList.remove('incorrecto');
			input.classList.remove('correcto');
			let grupo = input.parentNode.querySelector('.formulario__input-error');
			if ( grupo ) {
				grupo.classList.remove('formulario__input-error-activo');
			}
		});

		formulario.reset();
		formulario.querySelector('.ql-editor').innerHTML="";
		
	}

	sendFormulario(){
		let showData = this.showData;
		const url = this.url;
		let setiarFormulario = this.setiarFormulario;
		const campos = this.campos;
		const formulario = this.formulario;
		const inputs = this.inputs;



		formulario.addEventListener('submit', (e) => {
			e.preventDefault();
			
			let validar = true;
			for( const campo in this.campos) {
				if(campos[campo] === false){
					validar = false;
				}
			}

			if (validar === true) {
				let btnSubmit = formulario.querySelector('#btnSubmit');
				btnSubmit.disabled = true;

				let editarDescripcion = formulario.querySelector('#editor .ql-editor');
				let descripcion = formulario.querySelector('#descripcion');
				console.log(descripcion);
				if(descripcion != null ){
					descripcion.innerHTML = editarDescripcion.innerHTML;
				}

				const formData = new FormData(e.currentTarget);
				// let direccion = URL+'contenido/add/'+formData.get('materia');
				let direccion = url;
				let xmlhttp = new XMLHttpRequest();

				xmlhttp.onreadystatechange = function() {
					if ( this.readyState == 4 && this.status == 200 ) {
						// TODO FUE CORRECTO
						let datos = JSON.parse(xmlhttp.response);
						if ( datos.status == true ) {
														
							showData(formData.get('materia'));


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
						formulario.reset();
						formulario.querySelector('.ql-editor').innerHTML="";
						// setiarFormulario(formulario,inputs);
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