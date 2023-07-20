<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Bootstrap Ajax Admin System</title>
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownMenu" data-toggle="dropdown">Tasks</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                        <a class="dropdown-item" href="#">Create Task</a>
                    </div>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link d-flex" href="#" id="userDropdown" data-toggle="dropdown">
                        <div class="user-avatar">
                            <img src="{{ asset('images/profile.png') }}" alt="User Image">
                        </div>
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

        <!-- Pass the CSRF token to the JavaScript file using a data attribute -->
        <div id="csrf-token" data-token="{{ csrf_token() }}"></div>

        <div class="container mt-4">
            <h1>Welcome to the Laravel Bootstrap Ajax Admin System</h1>
            <p>
                Laravel Bootstrap Ajax-based admin system a user-friendly interface with a navbar that allows administrators to efficiently
                manage tasks asynchronously. Through Ajax interactions, administrators can create, read, update, and delete tasks
                dynamically without page reloads. The system utilizes Bootstrap for responsive design, while error handling ensures
                a stable and secure environment. The admin system comprises sections for creating tasks, listing existing tasks,
                editing tasks through modals, and deleting tasks with confirmation.
            </p>

            <!-- Success and Error Messages -->
            <div class="mt-4">
                <div id="success-alert" class="alert alert-success d-none" role="alert">
                    Task operation successful!
                </div>
                <div id="error-alert" class="alert alert-danger d-none" role="alert">
                    Oops! Something went wrong. Please try again.
                </div>
            </div>

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
                            <!-- Update Task Error Message -->
                            <div class="alert alert-danger d-none" id="update-error-alert" role="alert">
                                Oops! Something went wrong. Please try again.
                            </div>

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
            <p>Designed by <a href="https://github.com/mosesket">Moses  Ketuojo</a> &copy; 2023. All rights reserved.</p>
        </div>
    </footer>

    <script>
        var base_url = '{{ url('/') }}';
    </script>

    <script src="{{ asset('js/task_management.js') }}"></script>
</body>

</html>
