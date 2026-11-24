<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $pageTitle }}</title>

    @vite('resources/sass/app.scss')
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container">

            <a href="{{ route('home') }}"
               class="navbar-brand mb-0 h1">
                <i class="bi-hexagon-fill me-2"></i>
                Data Master
            </a>

            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse"
                 id="navbarSupportedContent">

                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('home') }}">
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active"
                           href="{{ route('employees.index') }}">
                            Employee List
                        </a>
                    </li>
                </ul>

                <a href="{{ route('profile') }}"
                   class="btn btn-outline-light">
                    <i class="bi-person-circle me-1"></i>
                    My Profile
                </a>
            </div>
        </div>
    </nav>

    <div class="container-sm my-5">
        <div class="row justify-content-center">
            <div class="col-xl-6">

                <div class="p-5 bg-light rounded-3 border">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="text-center mb-3">
                        <i class="bi-person-circle fs-1"></i>
                        <h4>Edit Employee</h4>
                    </div>

                    <hr>

                    <form action="{{ route('employees.update', ['employee' => $employee->id]) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">
                                    First Name
                                </label>

                                <input type="text"
                                       name="firstName"
                                       id="firstName"
                                       class="form-control"
                                       value="{{ old('firstName', $employee->firstname) }}"
                                       placeholder="Enter First Name">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">
                                    Last Name
                                </label>

                                <input type="text"
                                       name="lastName"
                                       id="lastName"
                                       class="form-control"
                                       value="{{ old('lastName', $employee->lastname) }}"
                                       placeholder="Enter Last Name">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    Email
                                </label>

                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="form-control"
                                       value="{{ old('email', $employee->email) }}"
                                       placeholder="Enter Email">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="age" class="form-label">
                                    Age
                                </label>

                                <input type="text"
                                       name="age"
                                       id="age"
                                       class="form-control"
                                       value="{{ old('age', $employee->age) }}"
                                       placeholder="Enter Age">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="position" class="form-label">
                                    Position
                                </label>

                                <select name="position"
                                        id="position"
                                        class="form-select">

                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}"
                                            {{ old('position', $employee->position_id) == $position->id ? 'selected' : '' }}>
                                            {{ $position->code }} - {{ $position->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <hr>

                        <div class="row mt-4">
                            <div class="col-md-6 d-grid mb-2">
                                <a href="{{ route('employees.index') }}"
                                   class="btn btn-outline-dark btn-lg">

                                    <i class="bi-arrow-left-circle me-2"></i>
                                    Cancel
                                </a>
                            </div>

                            <div class="col-md-6 d-grid mb-2">
                                <button type="submit"
                                        class="btn btn-dark btn-lg">

                                    <i class="bi-check-circle me-2"></i>
                                    Update
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')
</body>
</html>
