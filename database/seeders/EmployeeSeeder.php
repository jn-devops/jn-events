<?php

namespace Database\Seeders;

use App\Models\Employees;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the path to the Excel file in the storage/app directory
        $filePath = storage_path('app/Employee_Master_List.xlsm'); // File stored in storage/app

        // Extract data from the Excel file
        $excelData = Excel::toArray([], $filePath)[0]; // Load the first sheet of the Excel file
        $data = [];

        foreach ($excelData as $index => $row) {
            // Skip the header row
            if ($index === 0) {
                continue;
            }

            $data[] = [
                'employee_id'  => $row[0],
                'company'      => $row[1],
                'last_name'    => $row[2],
                'first_name'   => $row[3],
                'middle_name'  => $row[4] ?? null,
                'department'   => $row[5] ?? null,
                'floor'        => $row[6] ?? null,
                'unit_group'   => $row[7] ?? null,
                'code'         => $row[8] ?? null,
                'unit'         => $row[9] ?? null,
                'code_1'       => $row[10] ?? null,
            ];
        }

        // Insert or update the data in the database
        foreach ($data as $employeeData) {
            Employees::updateOrCreate(
                ['employee_id' => $employeeData['employee_id']], // Match on employee_id
                $employeeData // Update with this data
            );
        }

    }
}
