
/**
 * Abrimos la ventana modal para crear un nuevo elemento.
 * We open a modal window to create a new element.
 * @returns {undefined}
 */
function newCbCliente(){                 
    openCbCliente('new', null, null, null,null);
}
/**
 * Abrimos la ventana modal teniendo en cuenta la acción (action) para 
 * utilizarla como creación (Create), lectura (Read) o actualización (Update).
 * We opened the modal window considering the action (action) to use 
 * as creation (Create), reading (Read) or upgrade (Update).
 * @param {type} action las acciones que utilizamos son : new para Create, see para Read y edit para Update.
 *      Actions we use are :  new for Create, see for Read and edit for Update.
 */
function openCbCliente(action, id, nombre, apellido, tel){    
    document.formCliente.modo.value = action;
    document.formCliente.id.value = id;
    document.formCliente.nombre.value = nombre;
    document.formCliente.apellido.value = apellido;
    document.formCliente.tel.value = tel;
     
    document.formCliente.nombre.disabled = (action === 'see')?true:false;
    document.formCliente.apellido.disabled = (action === 'see')?true:false; 
    document.formCliente.tel.disabled = (action === 'see')?true:false; 
     
    $('#myModal').on('shown.bs.modal', function () {
        var modal = $(this);
        if (action === 'new'){                            
            modal.find('.modal-title').text('Creación de Cliente');  
            $('#save-cliente').show();
            $('#update-cliente').hide();             
        }else if (action === 'edit'){
            modal.find('.modal-title').text('Actualizar Cliente');
            $('#save-cliente').show();                    
            $('#update-cliente').hide();
        }else if (action === 'see'){
            modal.find('.modal-title').text('Ver Cliente');
            $('#save-cliente').hide();   
            $('#update-cliente').hide(); 
        }
        $('#nombre').focus()
     
    });
} 

function deleteCbCliente(id, nombre){     
    document.formDeleteCliente.iddelete.value = id;
    document.formDeleteCliente.nombre.value = nombre;                
     
    $('#myModalDelete').on('shown.bs.modal', function () {
        $('#myInput').focus()
    });
} 