<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // m_company
        DB::table('m_company')->insert([
            ['kunci' => 'Nama OS', 'nilai' => 'Ayoda CRM', 'created_at' => now(), 'updated_at' => now()],
            ['kunci' => 'Alamat', 'nilai' => 'Jl. Contoh No. 1, Jakarta', 'created_at' => now(), 'updated_at' => now()],
            ['kunci' => 'Telepon', 'nilai' => '021-12345678', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // m_child_company
        DB::table('m_child_company')->insert([
            ['id_company' => 1, 'name' => 'PT Ayoda Utama', 'company_type' => 'PT', 'status' => 'Active'],
            ['id_company' => 2, 'name' => 'PT Mitra Sejahtera', 'company_type' => 'PT', 'status' => 'Active'],
            ['id_company' => 3, 'name' => 'CV Berkah Mandiri', 'company_type' => 'CV', 'status' => 'Active'],
        ]);

        // m_department
        DB::table('m_department')->insert([
            ['name' => 'Sales', 'status' => 'Active'],
            ['name' => 'Finance', 'status' => 'Active'],
            ['name' => 'Human Resources', 'status' => 'Active'],
            ['name' => 'General Affairs', 'status' => 'Active'],
            ['name' => 'IT', 'status' => 'Active'],
            ['name' => 'Production', 'status' => 'Active'],
            ['name' => 'Marketing', 'status' => 'Active'],
        ]);

        // m_division
        DB::table('m_division')->insert([
            ['p_id_division' => 0, 'name' => 'Sales & Marketing', 'status' => 'Active'],
            ['p_id_division' => 0, 'name' => 'Finance & Accounting', 'status' => 'Active'],
            ['p_id_division' => 0, 'name' => 'Human Capital', 'status' => 'Active'],
            ['p_id_division' => 0, 'name' => 'Operations', 'status' => 'Active'],
        ]);

        // m_subdepartment
        DB::table('m_subdepartment')->insert([
            ['p_id_dept' => 1, 'name' => 'Sales Domestic', 'dept_name' => 'Sales', 'status' => 'Active'],
            ['p_id_dept' => 1, 'name' => 'Sales Export', 'dept_name' => 'Sales', 'status' => 'Active'],
            ['p_id_dept' => 3, 'name' => 'Recruitment', 'dept_name' => 'Human Resources', 'status' => 'Active'],
            ['p_id_dept' => 3, 'name' => 'Payroll', 'dept_name' => 'Human Resources', 'status' => 'Active'],
        ]);

        // colors
        DB::table('colors')->insert([
            ['value_color' => '#6366f1'],
            ['value_color' => '#22c55e'],
            ['value_color' => '#f59e0b'],
            ['value_color' => '#ef4444'],
            ['value_color' => '#3b82f6'],
            ['value_color' => '#8b5cf6'],
        ]);

        // calendar_color
        DB::table('calendar_color')->insert([
            ['id_color' => 1, 'color_tag' => 'Meeting', 'add_by' => 1],
            ['id_color' => 2, 'color_tag' => 'Deadline', 'add_by' => 1],
            ['id_color' => 3, 'color_tag' => 'Reminder', 'add_by' => 1],
            ['id_color' => 5, 'color_tag' => 'Training', 'add_by' => 1],
        ]);

        // offering_color
        DB::table('offering_color')->insert([
            ['id_color' => 1, 'color_tag' => 'New Offering', 'add_by' => 1],
            ['id_color' => 5, 'color_tag' => 'Follow Up', 'add_by' => 1],
            ['id_color' => 4, 'color_tag' => 'Urgent', 'add_by' => 1],
        ]);

        // currency
        DB::table('currency')->insert([
            ['code' => 'IDR', 'name' => 'Indonesian Rupiah', 'rate' => 1],
            ['code' => 'USD', 'name' => 'US Dollar', 'rate' => 16000],
            ['code' => 'EUR', 'name' => 'Euro', 'rate' => 17500],
            ['code' => 'SGD', 'name' => 'Singapore Dollar', 'rate' => 12000],
        ]);

        // m_bank
        DB::table('m_bank')->insert([
            ['name' => 'BCA', 'account_number' => '1234567890', 'account_holder' => 'PT Ayoda Utama', 'status' => 'Active'],
            ['name' => 'Mandiri', 'account_number' => '0987654321', 'account_holder' => 'PT Ayoda Utama', 'status' => 'Active'],
            ['name' => 'BNI', 'account_number' => '1122334455', 'account_holder' => 'PT Ayoda Utama', 'status' => 'Active'],
        ]);

        // m_vendors
        DB::table('m_vendors')->insert([
            ['name' => 'PT Supplier Utama', 'city' => 'Jakarta', 'phone' => '021-11111111', 'email' => 'supplier1@example.com', 'status' => 'Active'],
            ['name' => 'CV Bahan Baku Jaya', 'city' => 'Surabaya', 'phone' => '031-22222222', 'email' => 'supplier2@example.com', 'status' => 'Active'],
            ['name' => 'PT Global Material', 'city' => 'Bandung', 'phone' => '022-33333333', 'email' => 'supplier3@example.com', 'status' => 'Active'],
        ]);

        // m_reimbursement_type
        DB::table('m_reimbursement_type')->insert([
            ['reimburse_type' => 'Transport', 'status' => 'Active'],
            ['reimburse_type' => 'Makan', 'status' => 'Active'],
            ['reimburse_type' => 'Akomodasi', 'status' => 'Active'],
            ['reimburse_type' => 'Operasional', 'status' => 'Active'],
        ]);

        // m_vat
        DB::table('m_vat')->insert([
            ['name_vat' => 'PPN 11%', 'value_vat' => 11],
            ['name_vat' => 'PPN 0%', 'value_vat' => 0],
        ]);

        // m_wht
        DB::table('m_wht')->insert([
            ['name_wht' => 'PPh 23 - 2%', 'value_wht' => 2],
            ['name_wht' => 'PPh 23 - 15%', 'value_wht' => 15],
            ['name_wht' => 'Tanpa PPh', 'value_wht' => 0],
        ]);

        // companies (client companies)
        DB::table('companies')->insert([
            ['name' => 'PT Kosmetik Cantik', 'address' => 'Jl. Kecantikan No. 10, Jakarta', 'city' => 'Jakarta', 'phone' => '021-55551111', 'email' => 'info@kosmetik.com', 'status' => 1],
            ['name' => 'PT Farmasi Sehat', 'address' => 'Jl. Kesehatan No. 5, Surabaya', 'city' => 'Surabaya', 'phone' => '031-55552222', 'email' => 'info@farmasi.com', 'status' => 1],
            ['name' => 'PT Perawatan Prima', 'address' => 'Jl. Perawatan No. 20, Bandung', 'city' => 'Bandung', 'phone' => '022-55553333', 'email' => 'info@perawatan.com', 'status' => 1],
            ['name' => 'CV Herbal Nusantara', 'address' => 'Jl. Herbal No. 8, Yogyakarta', 'city' => 'Yogyakarta', 'phone' => '0274-55554444', 'email' => 'info@herbal.com', 'status' => 1],
        ]);

        // company_pics
        DB::table('company_pics')->insert([
            ['company_id' => 1, 'name' => 'Budi Santoso', 'phone_number_1' => '081211112222', 'email' => 'budi@kosmetik.com', 'status' => 1, 'last_updated_by' => 1],
            ['company_id' => 1, 'name' => 'Siti Rahayu', 'phone_number_1' => '081233334444', 'email' => 'siti@kosmetik.com', 'status' => 1, 'last_updated_by' => 1],
            ['company_id' => 2, 'name' => 'Ahmad Fauzi', 'phone_number_1' => '081255556666', 'email' => 'ahmad@farmasi.com', 'status' => 1, 'last_updated_by' => 1],
            ['company_id' => 3, 'name' => 'Dewi Lestari', 'phone_number_1' => '081277778888', 'email' => 'dewi@perawatan.com', 'status' => 1, 'last_updated_by' => 1],
        ]);

        // products
        DB::table('products')->insert([
            ['code' => 'PRD-001', 'name' => 'Face Cream SPF 30', 'unit' => 'pcs', 'price' => 150000, 'category' => 'Skincare', 'status' => 1],
            ['code' => 'PRD-002', 'name' => 'Moisturizing Lotion', 'unit' => 'bottle', 'price' => 85000, 'category' => 'Skincare', 'status' => 1],
            ['code' => 'PRD-003', 'name' => 'Vitamin C Serum', 'unit' => 'bottle', 'price' => 220000, 'category' => 'Skincare', 'status' => 1],
            ['code' => 'PRD-004', 'name' => 'Shampoo Anti-Dandruff', 'unit' => 'bottle', 'price' => 65000, 'category' => 'Haircare', 'status' => 1],
            ['code' => 'PRD-005', 'name' => 'Body Scrub Exfoliating', 'unit' => 'pcs', 'price' => 95000, 'category' => 'Bodycare', 'status' => 1],
            ['code' => 'PRD-006', 'name' => 'Sunscreen SPF 50', 'unit' => 'tube', 'price' => 180000, 'category' => 'Skincare', 'status' => 1],
        ]);

        // task_actions
        DB::table('task_actions')->insert([
            ['name' => 'DOCUMENTATION / SAMPLING & QUOTATION', 'status' => 1],
            ['name' => 'FORMULATION IN PROGRESS', 'status' => 1],
            ['name' => 'STABLE FORMULA & PENDING APPROVAL', 'status' => 1],
            ['name' => 'PILOT', 'status' => 1],
            ['name' => 'MARKETING APPROVED', 'status' => 1],
            ['name' => 'INDUSTRIAL BATCHES', 'status' => 1],
            ['name' => 'LAUNCHING', 'status' => 1],
        ]);

        // users (demo accounts)
        $permissions = array_fill(0, 1, '1');
        $permCols = [
            'kanban','hr','hr_1','hr_2','hr_3','hr_4','hr_5','hr_6','hr_7','hr_8','hr_9','hr_10','hr_11',
            'ga','ga_1','ga_2','ga_3','ga_4','ga_5','ga_6','ga_7','ga_8','ga_9','ga_10',
            'ga_11','ga_12','ga_13','ga_14','ga_15','ga_16','ga_17','ga_18','ga_19','ga_20',
            'ga_21','ga_22','ga_23','ga_24','ga_25','ga_26','ga_27',
            'master_data','md_1','md_2','md_3','md_4','md_5','md_6','md_7','md_8','md_9','md_10',
            'md_11','md_12','md_13','md_14','md_15','md_16','md_17','md_18','md_19','md_20',
            'md_21','md_22','md_23','md_24','md_25','calendar','google','google_calendar',
        ];
        $permData = array_fill_keys($permCols, '1');

        DB::table('users')->insert(array_merge([
            'name'              => 'Demo Admin',
            'username'          => 'demo_admin',
            'email'             => 'demo@ayoda.com',
            'real_email'        => 'demo@ayoda.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('demo1234'),
            'role'              => 100,
            'department'        => 1,
            'role_name'         => 'Administrator',
            'employee_id'       => 'EMP-001',
            'company_id'        => 0,
            'sales_id'          => '1',
            'status'            => 1,
            'image'             => 'No Image',
            'created_at'        => now(),
            'updated_at'        => now(),
        ], $permData));

        DB::table('users')->insert(array_merge([
            'name'              => 'Sales Demo',
            'username'          => 'sales_demo',
            'email'             => 'sales@ayoda.com',
            'real_email'        => 'sales@ayoda.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('demo1234'),
            'role'              => 101,
            'department'        => 1,
            'role_name'         => 'Sales',
            'employee_id'       => 'EMP-002',
            'company_id'        => 1,
            'sales_id'          => '2',
            'status'            => 1,
            'image'             => 'No Image',
            'created_by'        => 1,
            'created_at'        => now(),
            'updated_at'        => now(),
        ], $permData));

        // m_employees
        DB::table('m_employees')->insert([
            [
                'nik' => 'NIK001', 'first_name' => 'Budi', 'last_name' => 'Santoso',
                'DoB' => '1990-05-15', 'gender' => 'M', 'id_company' => 1,
                'department' => 'Sales', 'position' => 'Sales Manager',
                'email' => 'budi.s@ayoda.com', 'phone' => '08111111111',
                'status' => 'ACTIVE', 'joined_date' => '2020-01-01', 'created_by' => 1,
            ],
            [
                'nik' => 'NIK002', 'first_name' => 'Sari', 'last_name' => 'Dewi',
                'DoB' => '1993-08-20', 'gender' => 'F', 'id_company' => 1,
                'department' => 'Finance', 'position' => 'Finance Staff',
                'email' => 'sari.d@ayoda.com', 'phone' => '08122222222',
                'status' => 'ACTIVE', 'joined_date' => '2021-03-15', 'created_by' => 1,
            ],
            [
                'nik' => 'NIK003', 'first_name' => 'Reza', 'last_name' => 'Pratama',
                'DoB' => '1988-12-01', 'gender' => 'M', 'id_company' => 2,
                'department' => 'Human Resources', 'position' => 'HR Manager',
                'email' => 'reza.p@ayoda.com', 'phone' => '08133333333',
                'status' => 'ACTIVE', 'joined_date' => '2019-06-01', 'created_by' => 1,
            ],
        ]);

        // employee_leaves
        DB::table('employee_leaves')->insert([
            [
                'employee_id' => 1, 'category' => 'Cuti Tahunan',
                'periode_from' => '2026-05-10', 'periode_to' => '2026-05-12',
                'description' => 'Liburan keluarga', 'status' => 'Approved',
                'leave_days' => 3, 'approval1_name' => 'Admin', 'approval1_status' => 'Approved',
                'approval2_name' => 'Demo Admin', 'approval2_status' => 'Approved',
            ],
            [
                'employee_id' => 2, 'category' => 'Sakit',
                'periode_from' => '2026-04-28', 'periode_to' => '2026-04-29',
                'description' => 'Demam', 'status' => 'Approved',
                'leave_days' => 2, 'approval1_name' => 'Admin', 'approval1_status' => 'Approved',
                'approval2_name' => 'Demo Admin', 'approval2_status' => 'Approved',
            ],
            [
                'employee_id' => 3, 'category' => 'Cuti Tahunan',
                'periode_from' => '2026-06-01', 'periode_to' => '2026-06-03',
                'description' => 'Urusan pribadi', 'status' => 'Pending',
                'leave_days' => 3, 'approval1_name' => 'Admin', 'approval1_status' => 'Pending',
                'approval2_name' => 'Demo Admin', 'approval2_status' => 'Pending',
            ],
        ]);

        // projects
        DB::table('projects')->insert([
            [
                'name' => 'Pengembangan Face Cream Baru', 'description' => 'Formulasi face cream dengan kandungan niacinamide untuk PT Kosmetik Cantik',
                'company_id' => 1, 'company_pic_id' => 1, 'user_id' => 1,
                'status' => 1, 'date' => '2026-03-01', 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Proyek Serum Vitamin C', 'description' => 'R&D serum vitamin C 20% untuk PT Farmasi Sehat',
                'company_id' => 2, 'company_pic_id' => 3, 'user_id' => 2,
                'status' => 1, 'date' => '2026-02-15', 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Shampoo Herbal Formula', 'description' => 'Pengembangan shampoo herbal untuk CV Herbal Nusantara',
                'company_id' => 4, 'company_pic_id' => 4, 'user_id' => 1,
                'status' => 3, 'date' => '2025-11-01', 'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        // tasks
        DB::table('tasks')->insert([
            ['project_id' => 1, 'product_id' => 1, 'success_rate' => 65, 'created_by' => 1, 'last_updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['project_id' => 2, 'product_id' => 3, 'success_rate' => 40, 'created_by' => 2, 'last_updated_by' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['project_id' => 3, 'product_id' => 4, 'success_rate' => 100, 'created_by' => 1, 'last_updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // task_details
        DB::table('task_details')->insert([
            ['task_id' => 1, 'task_action_id' => 3, 'task_time' => '2026-04-10', 'notes' => 'Formula sudah stabil, menunggu approval marketing', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['task_id' => 2, 'task_action_id' => 2, 'task_time' => '2026-04-20', 'notes' => 'Formulasi sedang dalam proses', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['task_id' => 3, 'task_action_id' => 7, 'task_time' => '2025-12-15', 'notes' => 'Produk sudah launching', 'status' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // task_history
        DB::table('task_history')->insert([
            ['project_id' => 1, 'project_status_id' => 1, 'stage_id' => 1, 'notes' => 'Mulai sampling & quotation', 'success_rate' => 20, 'date' => '2026-03-01'],
            ['project_id' => 1, 'project_status_id' => 1, 'stage_id' => 2, 'notes' => 'Formula dalam pengembangan', 'success_rate' => 40, 'date' => '2026-03-20'],
            ['project_id' => 1, 'project_status_id' => 1, 'stage_id' => 3, 'notes' => 'Formula stabil', 'success_rate' => 65, 'date' => '2026-04-10'],
            ['project_id' => 3, 'project_status_id' => 3, 'stage_id' => 7, 'notes' => 'Produk berhasil launching', 'success_rate' => 100, 'date' => '2025-12-15'],
        ]);

        // kanban_board
        DB::table('kanban_board')->insert([
            ['BoardName' => 'Sprint Q2 2026', 'add_by' => 1],
            ['BoardName' => 'R&D Tasks', 'add_by' => 1],
        ]);

        // kanban
        $kanbanItems = [
            ['KanBanBoard_ID' => 1, 'ToDo' => 'Persiapkan presentasi klien PT Kosmetik', 'ToDoType' => 'personal', 'status' => 'todo', 'ToDoDate' => '2026-05-05', 'ToDoDue' => '2026-05-08', 'created_by' => 1, 'created_date' => '2026-05-01', 'lastupdate' => '2026-05-01'],
            ['KanBanBoard_ID' => 1, 'ToDo' => 'Follow up quotation PT Farmasi Sehat', 'ToDoType' => 'personal', 'status' => 'progress', 'ToDoDate' => '2026-05-03', 'ToDoDue' => '2026-05-06', 'created_by' => 1, 'created_date' => '2026-05-01', 'lastupdate' => '2026-05-03'],
            ['KanBanBoard_ID' => 1, 'ToDo' => 'Kirim sample face cream ke klien', 'ToDoType' => 'group', 'status' => 'done', 'ToDoDate' => '2026-04-28', 'ToDoDue' => '2026-04-30', 'created_by' => 1, 'created_date' => '2026-04-25', 'lastupdate' => '2026-04-30'],
            ['KanBanBoard_ID' => 2, 'ToDo' => 'Review formula serum vitamin C', 'ToDoType' => 'personal', 'status' => 'todo', 'ToDoDate' => '2026-05-07', 'ToDoDue' => '2026-05-10', 'created_by' => 1, 'created_date' => '2026-05-02', 'lastupdate' => '2026-05-02'],
            ['KanBanBoard_ID' => 2, 'ToDo' => 'Uji stabilitas produk baru', 'ToDoType' => 'personal', 'status' => 'progress', 'ToDoDate' => '2026-05-01', 'ToDoDue' => '2026-05-15', 'created_by' => 2, 'created_date' => '2026-05-01', 'lastupdate' => '2026-05-04'],
        ];
        foreach ($kanbanItems as $item) {
            DB::table('kanban')->insert($item);
        }

        // kanban_list
        DB::table('kanban_list')->insert([
            ['kanban_id' => 1, 'ToDoList' => 'Siapkan materi presentasi', 'status' => 1],
            ['kanban_id' => 1, 'ToDoList' => 'Buat slide deck', 'status' => 0],
            ['kanban_id' => 2, 'ToDoList' => 'Hubungi sales manager', 'status' => 1],
            ['kanban_id' => 2, 'ToDoList' => 'Kirim email follow up', 'status' => 0],
        ]);

        // calendar
        DB::table('calendar')->insert([
            ['calendar_name' => 'Meeting Klien PT Kosmetik Cantik', 'calendar_type' => 'group', 'start_time' => '2026-05-07 09:00:00', 'end_time' => '2026-05-07 11:00:00', 'id_calendar_color' => 1, 'add_by' => 1, 'notes' => 'Presentasi proposal produk baru'],
            ['calendar_name' => 'Review Formula Serum', 'calendar_type' => 'personal', 'start_time' => '2026-05-08 13:00:00', 'end_time' => '2026-05-08 15:00:00', 'id_calendar_color' => 3, 'add_by' => 1, 'notes' => 'Review hasil lab formula serum'],
            ['calendar_name' => 'Deadline Quotation PT Farmasi', 'calendar_type' => 'personal', 'start_time' => '2026-05-10 17:00:00', 'end_time' => '2026-05-10 18:00:00', 'id_calendar_color' => 2, 'add_by' => 2, 'notes' => 'Kirim quotation final'],
            ['calendar_name' => 'Training Produk Baru', 'calendar_type' => 'group', 'start_time' => '2026-05-14 08:00:00', 'end_time' => '2026-05-14 17:00:00', 'id_calendar_color' => 4, 'add_by' => 1, 'notes' => 'Training tim sales untuk produk terbaru'],
        ]);

        // purchase_order
        DB::table('purchase_order')->insert([
            [
                'idpo' => '26AYD-PO1', 'datepo' => '2026-04-15', 'deliverydate' => '2026-04-25',
                'idsupplier' => 1, 'idwarehouse' => 1, 'category' => 'AYD',
                'crossrate' => 1, 'currency' => 'IDR', 'subtotal' => 5000000, 'gtotal' => 5550000,
                'pvat' => 11, 'avat' => 550000, 'status' => 'Approved', 'addedby' => 'demo_admin',
            ],
            [
                'idpo' => '26AYD-PO2', 'datepo' => '2026-05-02', 'deliverydate' => '2026-05-12',
                'idsupplier' => 2, 'idwarehouse' => 1, 'category' => 'AYD',
                'crossrate' => 1, 'currency' => 'IDR', 'subtotal' => 8500000, 'gtotal' => 9435000,
                'pvat' => 11, 'avat' => 935000, 'status' => 'Pending', 'addedby' => 'demo_admin',
            ],
        ]);

        // inventory_assets
        DB::table('inventory_assets')->insert([
            ['name' => 'Bahan Baku Niacinamide', 'unit' => 'kg', 'category' => 'Raw Material', 'quantity' => 50, 'status' => 'Available'],
            ['name' => 'Vitamin C Murni', 'unit' => 'kg', 'category' => 'Raw Material', 'quantity' => 25, 'status' => 'Available'],
            ['name' => 'Kemasan Botol 100ml', 'unit' => 'pcs', 'category' => 'Packaging', 'quantity' => 500, 'status' => 'Available'],
            ['name' => 'Label Produk', 'unit' => 'lembar', 'category' => 'Packaging', 'quantity' => 1000, 'status' => 'Available'],
        ]);

        // visiting_report
        DB::table('visiting_report')->insert([
            ['id_report' => '26AYD-VR1', 'id_customer' => 1, 'username' => 'sales_demo', 'date_time' => '2026-04-20 10:00:00', 'stage' => '3', 'notulens' => 'Klien tertarik dengan sampel face cream. Menunggu approval dari manajemen.', 'created_at' => now()],
            ['id_report' => '26AYD-VR2', 'id_customer' => 2, 'username' => 'demo_admin', 'date_time' => '2026-04-25 14:00:00', 'stage' => '2', 'notulens' => 'Diskusi mengenai formula serum vitamin C. Klien meminta penyesuaian packaging.', 'created_at' => now()],
        ]);
    }
}
