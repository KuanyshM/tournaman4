@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="justify-content-center">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Opps!</strong> Something went wrong, please check below errors.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-header">Settings
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">{{__("Menu")}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td> <a  href="{{ route('users.index') }}">{{__("Users")}}</a></td>
                        </tr>
                        <tr>
                            <td> <a  href="{{ route('organizations.index') }}">{{__("Organizations")}}</a></td>
                        </tr>
                        <tr>
                            <td> <a  href="{{ route('roles.index') }}">{{__("Roles")}}</a></td>
                        </tr>
                        <tr>
                            <td> <a  href="{{ route('permissions.index') }}">{{__("Permissions")}}</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
