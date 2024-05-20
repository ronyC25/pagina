
//------------------------- 2do intento POR EL MOMENTO ESTE ESTA BIEN

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('userForm');
    const userTableBody = document.querySelector('#userTable tbody');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const name = document.getElementById('name').value;
        const apell = document.getElementById('apell').value;
        const email = document.getElementById('email').value;
        const numero = document.getElementById('numero').value;
        const fecha = document.getElementById('fecha').value;

        fetch('controller.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name: name, apell: apell, email: email, numero: numero, fecha: fecha })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchUsers();
                form.reset();
            } else {
                alert('Error al agregar usuario.');
            }
        });
    });

    // Function to fetch users
    function fetchUsers() {
        fetch('controller.php')
        .then(response => response.json())
        .then(data => {
            userTableBody.innerHTML = '';
            data.forEach(user => {
                const row = createUserRow(user);
                userTableBody.appendChild(row);
            });
        });
    }

    // Function to create a table row for a user
    function createUserRow(user) {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${user.name}</td>
            <td>${user.apell}</td>
            <td>${user.email}</td>
            <td>${user.numero}</td>
            <td>${user.fecha}</td>
            <td>
                <button class="btn btn-primary edit-btn" data-id="${user.id}"><i class="bi bi-pencil-square"></i></button>
                <button class="btn btn-danger delete-btn" data-id="${user.id}"><i class="bi bi-trash3-fill"></i></button>
            </td>
        `;
        return row;
    }

    // Event delegation for delete button
    userTableBody.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-btn')) {
            const userId = e.target.dataset.id;
            if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
                fetch(`controller.php?id=${userId}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fetchUsers();
                    } else {
                        alert('Error al eliminar usuario.');
                    }
                });
            }
        }
    });

    // Event delegation for edit button
    userTableBody.addEventListener('click', function(e) {
        if (e.target.classList.contains('edit-btn')) {
            const userId = e.target.dataset.id;
            // Aquí puedes implementar la lógica para editar el usuario, como abrir un modal con los datos del usuario para editar.
            alert(`Editar usuario con ID ${userId}`);
        }
    });

    //Evento para actualizar los datos
    userTableBody.addEventListener('click', function(e) {
        if (e.target.classList.contains('edit-btn')) {
            const userId = e.target.dataset.id;
            // Aquí puedes implementar la lógica para cargar los datos del usuario en la ventana emergente y abrir la ventana
            const user = getUserById(userId);
            openEditModal(user);
        }
    });
    
    // Function to get user by ID from the fetched users data
    function getUserById(userId) {
        return fetchedUsers.find(user => user.id === userId);
    }
    
    // Function to open the edit modal and populate with user data
    function openEditModal(user) {
        document.getElementById('editUserId').value = user.id;
        document.getElementById('editName').value = user.name;
        document.getElementById('editApell').value = user.apell;
        document.getElementById('editEmail').value = user.email;
        document.getElementById('editNumero').value = user.numero;
        document.getElementById('editFecha').value = user.fecha;
    
        document.getElementById('editModal').style.display = 'block';
    }

    fetchUsers();
});
