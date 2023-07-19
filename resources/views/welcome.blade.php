<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Admin System</title>
    <!-- import jquery from their website -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- import bootstrap from their website -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

    <!--  custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/mystyle.css') }}">
</head>

<body>
    <div class="wrapper">
        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Admin System</a>
            <!-- additional navbar items or dropdown menus -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">All Tasks</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownMenu" data-toggle="dropdown">Tasks</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                        <a class="dropdown-item" href="#">Cretae Task</a>
                    </div>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown">
                        <i class="fas fa-user"></i> Username
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="container mt-4">
            <h1>Welcome to the Admin System</h1>
            <p>
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis explicabo, laudantium placeat sed,
                quaerat,
                voluptatem qui saepe facilis consequuntur numquam voluptate ab exercitationem! Eaque debitis doloremque,
                similique tempore magnam veritatis.
            </p>

            <!-- Create Task  -->
            <section class="pb-5">
                <h2>Create a Task</h2>
                    @csrf
                    <div class="form-group">
                        <label for="title">Task Name</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Task Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" id="create-task">Create Task</button>
            </section>

            <!-- List Tasks -->
            <section>
                <h2>List of Tasks</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Task Name</th>
                            <th scope="col">Task Description</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="task-items">
                        <!-- Task items will be dynamically updated here -->
                    </tbody>
                </table>
            </section>

            <!-- Edit Task Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Task</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="edit_task_name">Task Name</label>
                                <input type="text" class="form-control" id="edit_task_name" name="edit_task_name" required>
                            </div>

                            <div class="form-group">
                                <label for="edit_task_description">Task Description</label>
                                <textarea class="form-control" id="edit_task_description" name="edit_task_description" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" id="update-task">Update Task</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Delete Task Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Delete Task</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this task?</p>
                            <button type="submit" class="btn btn-danger" id="delete-task">Delete Task</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light py-3 text-center">
        <div class="container">
            <p>Laravel Admin System &copy; 2023. All rights reserved.</p>
        </div>
    </footer>

    <script>
        var csrfToken = '{{ csrf_token() }}';
        function fetchTasks() {
            $.ajax({
                url: '/tasks',
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
                url: '/tasks/' + taskId,
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

        // Function to create a new task
        function createTask() {
            var title = $('#title').val();
            var description = $('#description').val();

            $.ajax({
            url: '/tasks',
            method: 'POST',
            data: {
                _token: csrfToken,
                title: title,
                description: description
            },
            success: function(response) {
                // Handle success response
                console.log('Task created successfully:', response);

                // Reset inputs
                $('#title').val('');
                $('#description').val('');

                // Fetch updated task list
                fetchTasks();
            },
            error: function(error) {
                // error response
                console.log('Error:', error);
            }
            });
        }

        function updateTask() {
            var title = $('#edit_task_name').val();
            var description = $('#edit_task_description').val();

            $.ajax({
                url: '/tasks/' + selectedTaskId,
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

                    // Fetch updated task list
                    fetchTasks();
                },
                error: function(error) {
                    // Handle error response
                    console.log('Error from update task:', error);
                }
            });
        }

        function deleteTask() {
            $.ajax({
                url: '/tasks/' + selectedTaskId,
                method: 'DELETE',
                data: {
                    _token: csrfToken
                },
                success: function(response) {
                    // Handle success response
                    console.log('Task deleted successfully');

                    // Close the modal
                    $('#deleteModal').modal('hide');

                    // Fetch updated task list
                    fetchTasks();
                },
                error: function(error) {
                    // Handle error response
                    console.log('Error:', error);
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
    </script>
</body>

</html>
