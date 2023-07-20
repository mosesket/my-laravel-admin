// Function to show success message
function showSuccessMessage(message) {
    $('#success-alert').text(message).removeClass('d-none').show();
    setTimeout(function () {
        $('#success-alert').fadeOut('slow').addClass('d-none');
    }, 3000);
}

// Function to show error message
function showErrorMessage(message) {
    $('#error-alert').text(message).removeClass('d-none').show();
    setTimeout(function () {
        $('#error-alert').fadeOut('slow').addClass('d-none');
    }, 3000);
}

// Function to show error in the modal
function showErrorInModal(message, modalId) {
    var errorAlertId = modalId === 'update' ? 'update-error-alert' : 'error-alert';
    $('#' + errorAlertId).text(message).removeClass('d-none').show();
    setTimeout(function () {
        $('#' + errorAlertId).fadeOut('slow').addClass('d-none');
    }, 3000);
}

var csrfToken = document.getElementById('csrf-token').getAttribute('data-token');

// Function to create a new task
function createTask() {
    var title = $('#title').val().trim();
    var description = $('#description').val().trim();

    // Validation for empty fields
    if (title === '' || description === '') {
        showErrorMessage('Title and Description cannot be empty.');
        return;
    }

    $.ajax({
    url: base_url + '/tasks',
    method: 'POST',
    data: {
        _token: csrfToken,
        title: title,
        description: description
    },
    success: function(response) {
        // Handle success response
        console.log('Task created successfully:', response);
        // Show success message
        showSuccessMessage('Task created successfully!');

        // Reset inputs
        $('#title').val('');
        $('#description').val('');

        // Fetch updated task list
        fetchTasks();
    },
    error: function(error) {
        // error response
        console.log('Error:', error);

        // Show error message
        showErrorMessage('Oops! Something went wrong. Please try again.');
    }
    });
}

function fetchTasks() {
    $.ajax({
        url: base_url + '/tasks',
        method: 'GET',
        success: function(response) {
            // Update the task table in the UI
            var tasks = response;
            var taskItems = $('#task-items');
            taskItems.empty();

            $.each(tasks, function(index, task) {
                var row = '<tr>' +
                    '<td>' + task.title + '</td>' +
                    '<td>' + task.description + '</td>' +
                    '<td>' +
                    '<button type="button" class="btn btn-primary edit-btn" data-task-id="' + task.id + '" data-toggle="modal" data-target="#editModal">Edit</button>' +
                    '<button type="button" class="btn btn-danger delete-btn" data-task-id="' + task.id + '" data-toggle="modal" data-target="#deleteModal">Delete</button>' +
                    '</td>' +
                    '</tr>';
                taskItems.append(row);
            });

            // Bind edit button events
            $('.edit-btn').click(function() {
                selectedTaskId = $(this).data('task-id');
                // Fetch task details and populate the edit modal
                fetchTaskDetails(selectedTaskId);
            });

            // Bind delete button events
            $('.delete-btn').click(function() {
                selectedTaskId = $(this).data('task-id');
            });
        },

        error: function(error) {
            // Handle error response
            console.log('Error:', error);
        }
    });
}

function fetchTaskDetails(taskId) {
    $.ajax({
        url: base_url + '/tasks/' + taskId,
        method: 'GET',
        success: function(response) {
            // Populate the edit modal with task details
            $('#edit_task_name').val(response.title);
            $('#edit_task_description').val(response.description);
        },
        error: function(error) {
            // Handle error response
            console.log(taskId);
            console.log('Error from fetch task:', error);
        }
    });
}

function updateTask() {
    var title = $('#edit_task_name').val().trim();
    var description = $('#edit_task_description').val().trim();

    // Validation for empty fields
    if (title === '' || description === '') {
        showErrorInModal('Title and Description cannot be empty.', 'update');
        return;
    }

    $.ajax({
        url: base_url + '/tasks/' + selectedTaskId,
        method: 'PUT',
        data: {
            _token: csrfToken,
            title: title,
            description: description
        },
        success: function(response) {
            // Handle success response
            console.log('Task updated successfully:', response);

            // Reset inputs
            $('#edit_task_name').val('');
            $('#edit_task_description').val('');

            // Close the modal
            $('#editModal').modal('hide');

            // Show success message
            showSuccessMessage('Task updated successfully!');

            // Fetch updated task list
            fetchTasks();
        },
        error: function(error) {
            // Handle error response
            console.log('Error from update task:', error);
            // Show error message
            showErrorMessage('Oops! Something went wrong. Please try again.');
        }
    });
}

function deleteTask() {
    $.ajax({
        url: base_url + '/tasks/' + selectedTaskId,
        method: 'DELETE',
        data: {
            _token: csrfToken
        },
        success: function(response) {
            // Handle success response
            console.log('Task deleted successfully');

            // Close the modal
            $('#deleteModal').modal('hide');

            // Show success message
            showSuccessMessage('Task deleted successfully!');

            // Fetch updated task list
            fetchTasks();
        },
        error: function(error) {
            // Handle error response
            console.log('Error:', error);
            // Show error message
            showErrorMessage('Oops! Something went wrong. Please try again.');
        }
    });
}

// Bind event listener to update task button in edit modal
$('#editModal').on('click', '#update-task', function() {
    updateTask();
});

// Bind event listener to delete task button in delete modal
$('#deleteModal').on('click', '#delete-task', function() {
    deleteTask();
});

// Bind event listener to create task button
$('#create-task').click(function() {
    createTask();
});

// Fetch tasks on page load
$(document).ready(function() {
    fetchTasks();
});
