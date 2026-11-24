<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    // Menampilkan daftar karyawan
    public function index()
    {
        $pageTitle = 'Employee List';

        // QUERY BUILDER
        $employees = DB::table('employees')
            ->leftJoin(
                'positions',
                'employees.position_id',
                '=',
                'positions.id'
            )
            ->select(
                'employees.*',
                'employees.id as employee_id',
                'positions.name as position_name'
            )
            ->orderBy('employees.id')
            ->get();

        return view('employee.index', [
            'pageTitle' => $pageTitle,
            'employees' => $employees
        ]);
    }

    // Menampilkan formulir Create Employee
    public function create()
    {
        $pageTitle = 'Create Employee';

        // QUERY BUILDER
        $positions = DB::table('positions')->get();

        return view('employee.create',
            compact('pageTitle', 'positions')
        );
    }

    // Menyimpan karyawan baru
    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar.',
            'numeric' => 'Isi :attribute dengan angka.',
            'integer' => 'Isi :attribute dengan bilangan bulat.',
            'email.unique' => 'Email sudah terdaftar, gunakan email lain.',
            'position.exists' => 'Posisi yang dipilih tidak tersedia.'
        ];

        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:employees,email',
            'age' => 'required|numeric|integer',
            'position' => 'required|exists:positions,id'
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // INSERT QUERY
        DB::table('employees')->insert([
            'firstname' => $request->firstName,
            'lastname' => $request->lastName,
            'email' => $request->email,
            'age' => $request->age,
            'position_id' => $request->position
        ]);

        return redirect()->route('employees.index');
    }

    // Menampilkan detail karyawan
    public function show(string $id)
    {
        $pageTitle = 'Employee Detail';

        // QUERY BUILDER
        $employee = DB::table('employees')
            ->leftJoin(
                'positions',
                'employees.position_id',
                '=',
                'positions.id'
            )
            ->select(
                'employees.*',
                'employees.id as employee_id',
                'positions.code as position_code',
                'positions.name as position_name',
                'positions.description as position_description'
            )
            ->where('employees.id', $id)
            ->first();

        if (!$employee) {
            abort(404, 'Employee tidak ditemukan.');
        }

        return view('employee.show',
            compact('pageTitle', 'employee')
        );
    }

    // Menampilkan formulir Edit Employee
    public function edit(string $id)
    {
        $pageTitle = 'Edit Employee';

        $employee = DB::table('employees')
            ->where('id', $id)
            ->first();

        if (!$employee) {
            abort(404, 'Employee tidak ditemukan.');
        }

        $positions = DB::table('positions')->get();

        return view('employee.edit',
            compact('pageTitle', 'employee', 'positions')
        );
    }

    // Memperbarui data karyawan
    public function update(Request $request, string $id)
    {
        $employee = DB::table('employees')
            ->where('id', $id)
            ->first();

        if (!$employee) {
            abort(404, 'Employee tidak ditemukan.');
        }

        $messages = [
            'required' => ':attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar.',
            'numeric' => 'Isi :attribute dengan angka.',
            'integer' => 'Isi :attribute dengan bilangan bulat.',
            'email.unique' => 'Email sudah terdaftar, gunakan email lain.',
            'position.exists' => 'Posisi yang dipilih tidak tersedia.'
        ];

        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')->ignore($id)
            ],
            'age' => 'required|numeric|integer',
            'position' => 'required|exists:positions,id'
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // UPDATE QUERY
        DB::table('employees')
            ->where('id', $id)
            ->update([
                'firstname' => $request->firstName,
                'lastname' => $request->lastName,
                'email' => $request->email,
                'age' => $request->age,
                'position_id' => $request->position
            ]);

        return redirect()->route('employees.index');
    }

    // Menghapus data karyawan
    public function destroy(string $id)
    {
        // QUERY BUILDER
        DB::table('employees')
            ->where('id', $id)
            ->delete();

        return redirect()->route('employees.index');
    }
}
