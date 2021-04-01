import UI from "./class/ui.js";
import ValidarFormulario from "./class/validarFormulario.js";
import ValidarFormularioEditar from "./class/validarFormularioEditar.js";


var url = window.location;
url = url.pathname.split('/');
var materia = url[url.length - 1];

const ui = new UI(materia);

let urlEdit = `${URL}contenido/edit/${materia}`;
let camposEdit = {
	numero: true,
	message: true,
	lapso_form: true,
	file1: true,
	file2: true,
	file3: true,
	file4: true
}
const editFormulario = document.getElementById('editar_contenido');
const validarFormularioEditar = new ValidarFormularioEditar(editFormulario,ui.showData,camposEdit,urlEdit);

const addFormulario = document.getElementById('add_contenido');
const contendios = document.getElementById('contenido');

let camposAdd = {
	numero: false,
	message: true,
	lapso_form: true,
	file1: true,
	file2: true,
	file3: true,
	file4: true
}
let urlAdd = `${URL}contenido/add/${materia}`;
const validarFormulario = new ValidarFormulario(addFormulario,ui.showData,camposAdd,urlAdd);
validarFormulario.addInputArchivo();



ui.modalPreview(validarFormulario.inputs);
contendios.addEventListener('click', (event) => {
	
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