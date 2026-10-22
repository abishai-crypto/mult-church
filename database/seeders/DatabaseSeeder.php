<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Asset;
use App\Models\Attendance;
use App\Models\AuditLog;
use App\Models\Church;
use App\Models\ChurchNotification;
use App\Models\Department;
use App\Models\DepartmentFinance;
use App\Models\DepartmentMember;
use App\Models\Document;
use App\Models\Event;
use App\Models\Expense;
use App\Models\FinancialTransaction;
use App\Models\Member;
use App\Models\PastoralVisit;
use App\Models\PrayerRequest;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use App\Models\YoutubeVideo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kanisa Kuu: EVANGELIST ASSEMBLIES OF GOD TANZANIA (EAGT) - GOLANI
        $church1 = Church::create([
            'name' => 'EVANGELIST ASSEMBLIES OF GOD TANZANIA (EAGT)',
            'slug' => 'eagt-golani',
            'code' => 'EAGT-GLN',
            'tagline' => 'Golani, Kimara-Suka - Dar es Salaam | Neno la Msalaba ni Nguvu ya Mungu',
            'email' => 'golani@eagt.org',
            'phone' => '+255 754 123 456',
            'address' => 'Mtaa wa Golani, Kimara-Suka, Manispaa ya Ubungo, Dar es Salaam, Tanzania',
            'currency' => 'TZS',
            'currency_symbol' => 'Tsh',
            'timezone' => 'Africa/Dar_es_Salaam',
            'primary_color' => '#1e3a8a', // Bluu ya Kifalme
            'secondary_color' => '#d97706', // Dhahabu
            'modules' => ['members', 'finances', 'attendance', 'departments', 'pastoral_care', 'documents', 'media', 'projects', 'assets', 'events'],
            'subscription_status' => 'active',
            'subscription_expires_at' => now()->addYear(),
            'is_active' => true,
        ]);

        // Kanisa la Pili la Mfano (Kanda ya Pwani)
        $church2 = Church::create([
            'name' => 'EAGT KINONDONI REVIVAL TEMPLE',
            'slug' => 'eagt-kinondoni',
            'code' => 'EAGT-KND',
            'tagline' => 'Kinondoni, Dar es Salaam | Kanisa Linaloongozwa na Roho Mtakatifu',
            'email' => 'kinondoni@eagt.org',
            'phone' => '+255 784 987 654',
            'address' => 'Kinondoni Mkwajuni, Dar es Salaam, Tanzania',
            'currency' => 'TZS',
            'currency_symbol' => 'Tsh',
            'timezone' => 'Africa/Dar_es_Salaam',
            'primary_color' => '#065f46',
            'secondary_color' => '#0284c7',
            'modules' => ['members', 'finances', 'attendance', 'departments', 'pastoral_care', 'documents', 'media', 'projects', 'assets', 'events'],
            'subscription_status' => 'active',
            'subscription_expires_at' => now()->addMonths(6),
            'is_active' => true,
        ]);

        // 2. Watumiaji wa Mfumo (Viongozi na Watendaji kwa Lugha ya Kiswahili)
        $superAdmin = User::create([
            'church_id' => null,
            'name' => 'Msimamizi Mkuu wa Mfumo (Super Admin)',
            'email' => 'superadmin@multichurch.org',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'phone' => '+255 713 000 001',
            'status' => 'active',
        ]);

        $churchAdmin = User::create([
            'church_id' => $church1->id,
            'name' => 'Mchungaji Msaidizi / Admin',
            'email' => 'admin@eagt.org',
            'password' => Hash::make('password'),
            'role' => 'church_admin',
            'phone' => '+255 754 111 001',
            'status' => 'active',
        ]);

        $pastor = User::create([
            'church_id' => $church1->id,
            'name' => 'Mchungaji Kiongozi (Senior Pastor)',
            'email' => 'pastor@eagt.org',
            'password' => Hash::make('password'),
            'role' => 'pastor',
            'phone' => '+255 754 111 002',
            'status' => 'active',
        ]);

        $elder = User::create([
            'church_id' => $church1->id,
            'name' => 'Mzee wa Kanisa (Kiongozi wa Wazee)',
            'email' => 'elder@eagt.org',
            'password' => Hash::make('password'),
            'role' => 'elder',
            'phone' => '+255 754 111 003',
            'status' => 'active',
        ]);

        $treasurer = User::create([
            'church_id' => $church1->id,
            'name' => 'Mhazini Mkuu (Mtunza Hazina)',
            'email' => 'treasurer@eagt.org',
            'password' => Hash::make('password'),
            'role' => 'treasurer',
            'phone' => '+255 754 111 004',
            'status' => 'active',
        ]);

        $secretary = User::create([
            'church_id' => $church1->id,
            'name' => 'Katibu wa Kanisa',
            'email' => 'secretary@eagt.org',
            'password' => Hash::make('password'),
            'role' => 'secretary',
            'phone' => '+255 754 111 005',
            'status' => 'active',
        ]);

        // 3. Idara za Kanisa (EAGT Pentecostal Departments)
        // 3.1 Idara ya Vijana: CGM (CHRIST GOSPEL MESSENGERS)
        $youthDept = Department::create([
            'church_id' => $church1->id,
            'name' => 'CGM (CHRIST GOSPEL MESSENGERS) - Vijana EAGT Golani',
            'slug' => 'cgm-vijana',
            'description' => 'Kulea vijana kiroho, uinjilisti wa nguvu, kambi za vijana, na kufanya kazi ya Mungu kwa moto wa Roho Mtakatifu.',
            'leader_name' => 'Kaka Baraka Mwakyoma',
            'leader_phone' => '+255 765 222 333',
            'meeting_day' => 'Jumamosi',
            'meeting_time' => '10:00 Jioni',
            'banner_color' => '#8b5cf6',
            'is_active' => true,
        ]);

        // 3.2 Idara ya Watoto: CWI (CHILDREN WITH INTEGRITY)
        $childrenDept = Department::create([
            'church_id' => $church1->id,
            'name' => 'CWI - Idara ya Watoto EAGT Golani (Sunday School)',
            'slug' => 'cwi-watoto',
            'description' => 'Kulea watoto katika misingi ya wokovu, Neno la Mungu, kualika watoto kwa Kristo na mafundisho ya tabia njema.',
            'leader_name' => 'Mwalimu Zawadi Mollel',
            'leader_phone' => '+255 786 554 433',
            'meeting_day' => 'Jumapili Asubuhi',
            'meeting_time' => '08:30 Asubuhi',
            'banner_color' => '#10b981',
            'is_active' => true,
        ]);

        // 3.3 Idara ya Ujenzi na Maendeleo ya Kanisa
        $buildingDept = Department::create([
            'church_id' => $church1->id,
            'name' => 'Idara ya Ujenzi na Maendeleo ya Kanisa',
            'slug' => 'ujenzi-na-maendeleo',
            'description' => 'Kusimamia miradi yote ya ununuzi wa viwanja, ujenzi wa Hekalu jipya la kisasa na uboreshaji wa miundombinu ya kanisa.',
            'leader_name' => 'Mhandisi Amani Kavishe & Mzee Daudi Makundi',
            'leader_phone' => '+255 754 777 888',
            'meeting_day' => 'Jumapili Baada ya Ibada',
            'meeting_time' => '01:00 Mchana',
            'banner_color' => '#d97706',
            'is_active' => true,
        ]);

        // 3.4 WWK - Wanawake wa Kristo
        $womenDept = Department::create([
            'church_id' => $church1->id,
            'name' => 'WWK - Wanawake wa Kristo EAGT Golani',
            'slug' => 'wwk-wanawake',
            'description' => 'Kujenga wanawake wa maombi, wacha Mungu, malezi ya watoto na familia, na kusaidia wahitaji.',
            'leader_name' => 'Mama Mchungaji Neema Mwambungu',
            'leader_phone' => '+255 755 333 444',
            'meeting_day' => 'Jumanne',
            'meeting_time' => '09:00 Alasiri',
            'banner_color' => '#ec4899',
            'is_active' => true,
        ]);

        // 3.5 Wanaume wa Imani
        $menDept = Department::create([
            'church_id' => $church1->id,
            'name' => 'Umoja wa Wanaume wa Imani (Men Fellowship)',
            'slug' => 'wanaume-wa-imani',
            'description' => 'Kusimika wanaume wanyofu, viongozi wa familia na nguzo dhabiti za kanisa la Pentekoste.',
            'leader_name' => 'Mzee Daudi Makundi',
            'leader_phone' => '+255 712 444 555',
            'meeting_day' => 'Jumamosi ya Kwanza ya Mwezi',
            'meeting_time' => '01:00 Asubuhi',
            'banner_color' => '#0284c7',
            'is_active' => true,
        ]);

        // 3.6 Kwaya Kuu ya Uinjilisti
        $choirDept = Department::create([
            'church_id' => $church1->id,
            'name' => 'Kwaya Kuu ya Uinjilisti na Sifa (EAGT Choir)',
            'slug' => 'kwaya-kuu',
            'description' => 'Kuinua sifa na kuabudu, mikutano ya injili na huduma ya uimbaji wenye mguso na uwepo wa Roho Mtakatifu.',
            'leader_name' => 'Mwl. Emmanuel Lyimo',
            'leader_phone' => '+255 768 555 666',
            'meeting_day' => 'Alhamisi & Jumamosi',
            'meeting_time' => '10:30 Jioni',
            'banner_color' => '#f59e0b',
            'is_active' => true,
        ]);

        // 3.7 Mashemasi na Itifaki
        $ushersDept = Department::create([
            'church_id' => $church1->id,
            'name' => 'Mashemasi, Itifaki na Ukaribisho',
            'slug' => 'mashemasi-ushers',
            'description' => 'Kupokea wageni, utulivu wa ibada, kukusanya sadaka, na huduma ya Meza ya Bwana.',
            'leader_name' => 'Kaka Juma Mrema',
            'leader_phone' => '+255 714 666 777',
            'meeting_day' => 'Jumamosi',
            'meeting_time' => '11:00 Jioni',
            'banner_color' => '#14b8a6',
            'is_active' => true,
        ]);

        // Kiongozi wa Idara ya Vijana (CGM)
        $youthLeaderUser = User::create([
            'church_id' => $church1->id,
            'name' => 'Kaka Baraka Mwakyoma (Kiongozi CGM)',
            'email' => 'youthleader@eagt.org',
            'password' => Hash::make('password'),
            'role' => 'department_leader',
            'department_id' => $youthDept->id,
            'phone' => '+255 765 222 333',
            'status' => 'active',
        ]);

        // Muumini wa Kawaida
        $memberUser = User::create([
            'church_id' => $church1->id,
            'name' => 'Dada Rehema Swai',
            'email' => 'member@eagt.org',
            'password' => Hash::make('password'),
            'role' => 'member',
            'phone' => '+255 715 888 999',
            'status' => 'active',
        ]);

        // 4. Waumini / Washirika wa Kanisa EAGT Golani
        $membersData = [
            ['first_name' => 'Rehema', 'last_name' => 'Swai', 'gender' => 'Female', 'date_of_birth' => '1994-06-12', 'marital_status' => 'Married', 'phone' => '+255 715 888 999', 'email' => 'rehema.swai@gmail.com', 'occupation' => 'Mwalimu wa Sekondari', 'baptism_status' => 'Baptized', 'membership_status' => 'Active', 'joined_date' => '2021-02-10'],
            ['first_name' => 'Baraka', 'last_name' => 'Mwakyoma', 'gender' => 'Male', 'date_of_birth' => '1992-09-18', 'marital_status' => 'Single', 'phone' => '+255 765 222 333', 'email' => 'baraka.mwakyoma@yahoo.com', 'occupation' => 'Mhandisi wa TEHAMA', 'baptism_status' => 'Baptized', 'membership_status' => 'Active', 'joined_date' => '2020-05-15'],
            ['first_name' => 'Daudi', 'last_name' => 'Makundi', 'gender' => 'Male', 'date_of_birth' => '1978-04-20', 'marital_status' => 'Married', 'phone' => '+255 712 444 555', 'email' => 'daudi.makundi@gmail.com', 'occupation' => 'Mfanyabiashara', 'baptism_status' => 'Baptized', 'membership_status' => 'Active', 'joined_date' => '2018-01-20'],
            ['first_name' => 'Neema', 'last_name' => 'Mwambungu', 'gender' => 'Female', 'date_of_birth' => '1982-11-05', 'marital_status' => 'Married', 'phone' => '+255 755 333 444', 'email' => 'neema.m@hotmail.com', 'occupation' => 'Mhasibu', 'baptism_status' => 'Baptized', 'membership_status' => 'Active', 'joined_date' => '2019-07-14'],
            ['first_name' => 'Emmanuel', 'last_name' => 'Lyimo', 'gender' => 'Male', 'date_of_birth' => '1988-03-25', 'marital_status' => 'Married', 'phone' => '+255 768 555 666', 'email' => 'emmanuel.lyimo@gmail.com', 'occupation' => 'Mwalimu wa Muziki', 'baptism_status' => 'Baptized', 'membership_status' => 'Active', 'joined_date' => '2020-03-01'],
            ['first_name' => 'Amani', 'last_name' => 'Kavishe', 'gender' => 'Male', 'date_of_birth' => '1996-08-30', 'marital_status' => 'Single', 'phone' => '+255 754 777 888', 'email' => 'amani.k@outlook.com', 'occupation' => 'Fundi Sanifu Ujenzi', 'baptism_status' => 'Baptized', 'membership_status' => 'Active', 'joined_date' => '2022-04-12'],
            ['first_name' => 'Joyce', 'last_name' => 'Massawe', 'gender' => 'Female', 'date_of_birth' => '1990-12-14', 'marital_status' => 'Married', 'phone' => '+255 784 112 233', 'email' => 'joyce.massawe@gmail.com', 'occupation' => 'Afisa Afya', 'baptism_status' => 'Baptized', 'membership_status' => 'Active', 'joined_date' => '2021-09-08'],
            ['first_name' => 'Ezekiel', 'last_name' => 'Mshana', 'gender' => 'Male', 'date_of_birth' => '1985-05-19', 'marital_status' => 'Married', 'phone' => '+255 713 990 011', 'email' => 'ezekiel.mshana@yahoo.com', 'occupation' => 'Afisa Benki', 'baptism_status' => 'Baptized', 'membership_status' => 'Active', 'joined_date' => '2019-11-25'],
            ['first_name' => 'Grace', 'last_name' => 'Tarimo', 'gender' => 'Female', 'date_of_birth' => '2000-02-11', 'marital_status' => 'Single', 'phone' => '+255 762 334 455', 'email' => 'grace.t@chuo.ac.tz', 'occupation' => 'Mwanafunzi wa Chuo', 'baptism_status' => 'Not Baptized', 'membership_status' => 'Active', 'joined_date' => '2024-01-14'],
            ['first_name' => 'Juma', 'last_name' => 'Mrema', 'gender' => 'Male', 'date_of_birth' => '1980-07-09', 'marital_status' => 'Married', 'phone' => '+255 714 666 777', 'email' => 'juma.mrema@gmail.com', 'occupation' => 'Meneja Usafirishaji', 'baptism_status' => 'Baptized', 'membership_status' => 'Active', 'joined_date' => '2018-08-30'],
            ['first_name' => 'Zawadi', 'last_name' => 'Mollel', 'gender' => 'Female', 'date_of_birth' => '1997-10-22', 'marital_status' => 'Single', 'phone' => '+255 786 554 433', 'email' => 'zawadi.m@gmail.com', 'occupation' => 'Mjasiriamali', 'baptism_status' => 'Baptized', 'membership_status' => 'Active', 'joined_date' => '2023-05-20'],
            ['first_name' => 'Khadija (Hellen)', 'last_name' => 'Shirima', 'gender' => 'Female', 'date_of_birth' => '1993-01-15', 'marital_status' => 'Married', 'phone' => '+255 758 998 877', 'email' => 'hellen.shirima@gmail.com', 'occupation' => 'Mfamasia', 'baptism_status' => 'Baptized', 'membership_status' => 'Active', 'joined_date' => '2022-08-10'],
        ];

        $createdMembers = [];
        foreach ($membersData as $idx => $m) {
            $createdMembers[] = Member::create(array_merge($m, [
                'church_id' => $church1->id,
                'member_number' => 'EAGT-MBR-' . str_pad($idx + 1, 4, '0', STR_PAD_LEFT),
                'residential_address' => 'Kimara-Suka, Mtaa wa Golani Nyumba No. ' . (15 + $idx * 3) . ', Dar es Salaam',
                'emergency_contact_name' => 'Mwanafamilia wa Karibu',
                'emergency_contact_phone' => '+255 754 000 ' . str_pad($idx, 3, '0', STR_PAD_LEFT),
            ]));
        }

        $memberUser->update(['member_id' => $createdMembers[0]->id]);

        // Kugawa waumini katika idara
        DepartmentMember::create(['church_id' => $church1->id, 'department_id' => $youthDept->id, 'member_id' => $createdMembers[1]->id, 'role_in_department' => 'Kiongozi Mkuu', 'joined_at' => '2020-05-15', 'is_active' => true]);
        DepartmentMember::create(['church_id' => $church1->id, 'department_id' => $youthDept->id, 'member_id' => $createdMembers[5]->id, 'role_in_department' => 'Katibu', 'joined_at' => '2022-04-12', 'is_active' => true]);
        DepartmentMember::create(['church_id' => $church1->id, 'department_id' => $youthDept->id, 'member_id' => $createdMembers[8]->id, 'role_in_department' => 'Mjumbe', 'joined_at' => '2024-01-14', 'is_active' => true]);

        DepartmentMember::create(['church_id' => $church1->id, 'department_id' => $womenDept->id, 'member_id' => $createdMembers[3]->id, 'role_in_department' => 'Mwenyekiti WWK', 'joined_at' => '2019-07-14', 'is_active' => true]);
        DepartmentMember::create(['church_id' => $church1->id, 'department_id' => $womenDept->id, 'member_id' => $createdMembers[0]->id, 'role_in_department' => 'Katibu Msaidizi', 'joined_at' => '2021-02-10', 'is_active' => true]);
        DepartmentMember::create(['church_id' => $church1->id, 'department_id' => $womenDept->id, 'member_id' => $createdMembers[6]->id, 'role_in_department' => 'Mtunza Hazina', 'joined_at' => '2021-09-08', 'is_active' => true]);

        DepartmentMember::create(['church_id' => $church1->id, 'department_id' => $choirDept->id, 'member_id' => $createdMembers[4]->id, 'role_in_department' => 'Mwalimu wa Kwaya', 'joined_at' => '2020-03-01', 'is_active' => true]);
        DepartmentMember::create(['church_id' => $church1->id, 'department_id' => $choirDept->id, 'member_id' => $createdMembers[0]->id, 'role_in_department' => 'Mwimbaji', 'joined_at' => '2021-03-01', 'is_active' => true]);

        DepartmentMember::create(['church_id' => $church1->id, 'department_id' => $childrenDept->id, 'member_id' => $createdMembers[10]->id, 'role_in_department' => 'Mwalimu wa Watoto CWI', 'joined_at' => '2023-05-20', 'is_active' => true]);
        DepartmentMember::create(['church_id' => $church1->id, 'department_id' => $buildingDept->id, 'member_id' => $createdMembers[5]->id, 'role_in_department' => 'Mhandisi wa Mradi', 'joined_at' => '2022-04-12', 'is_active' => true]);
        DepartmentMember::create(['church_id' => $church1->id, 'department_id' => $buildingDept->id, 'member_id' => $createdMembers[2]->id, 'role_in_department' => 'Mwenyekiti Kamati ya Ujenzi', 'joined_at' => '2018-01-20', 'is_active' => true]);

        // 5. Ratiba za Ibada
        $sundayWorship = Service::create([
            'church_id' => $church1->id,
            'title' => 'Ibada Kuu ya Jumapili (Sifa, Kuabudu na Neno)',
            'service_type' => 'Sunday Worship',
            'day_of_week' => 'Jumapili',
            'start_time' => '08:30:00',
            'end_time' => '12:30:00',
            'location' => 'Hekalu Kuu la Ibada - Golani',
            'description' => 'Ibada kuu ya kila Jumapili, uimbaji, Meza ya Bwana, neno la ukombozi na maombezi.',
            'is_active' => true,
        ]);

        $midweekService = Service::create([
            'church_id' => $church1->id,
            'title' => 'Ibada ya Katikati ya Wiki (Mafundisho na Maombi)',
            'service_type' => 'Midweek Prayer',
            'day_of_week' => 'Jumatano',
            'start_time' => '17:00:00',
            'end_time' => '19:00:00',
            'location' => 'Hekalu Kuu - Golani',
            'description' => 'Kujifunza Neno la Mungu mstari kwa mstari na maombi ya nguvu ya kuvunja nira.',
            'is_active' => true,
        ]);

        $youthService = Service::create([
            'church_id' => $church1->id,
            'title' => 'Mkesha Mkuu wa Ijumaa (Ijumaa ya Miujiza)',
            'service_type' => 'All-Night Vigil',
            'day_of_week' => 'Ijumaa',
            'start_time' => '21:30:00',
            'end_time' => '05:00:00',
            'location' => 'Hekalu Kuu - Golani',
            'description' => 'Mkesha wa maombi mazito, uponyaji na kufunguliwa vifungo.',
            'is_active' => true,
        ]);

        // 6. Mahudhurio ya Ibada (Past 6 services)
        $sundayDates = [
            now()->subWeeks(5)->startOfWeek()->addDays(6),
            now()->subWeeks(4)->startOfWeek()->addDays(6),
            now()->subWeeks(3)->startOfWeek()->addDays(6),
            now()->subWeeks(2)->startOfWeek()->addDays(6),
            now()->subWeeks(1)->startOfWeek()->addDays(6),
            now()->subDays(now()->dayOfWeek === 0 ? 0 : now()->dayOfWeek),
        ];

        foreach ($sundayDates as $idx => $date) {
            $men = 110 + ($idx * 8);
            $women = 185 + ($idx * 12);
            $kids = 90 + ($idx * 6);
            Attendance::create([
                'church_id' => $church1->id,
                'service_id' => $sundayWorship->id,
                'attendance_date' => $date->format('Y-m-d'),
                'men_count' => $men,
                'women_count' => $women,
                'children_count' => $kids,
                'total_count' => $men + $women + $kids,
                'first_timers_count' => 14 + ($idx % 4),
                'new_converts_count' => 6 + ($idx % 3),
                'notes' => 'Ibada ilikuwa na uwepo mkuu wa Mungu. Mahubiri mazito kutoka kwa Mchungaji Kiongozi.',
                'recorded_by' => $secretary->id,
            ]);
        }

        // 7. Fedha za Kanisa (Katika Shilingi za Tanzania - Tsh)
        // SHERIA MUHIMU: Zaka zikithibitishwa na Wazee wa Kanisa hazihifadhiwi bali zinapelekwa moja kwa moja kwa Mchungaji.
        // Hapa tunaweka mifano ya zaka zilizothibitishwa (Confirmed -> Moja kwa moja kwa Mchungaji) na zaka pending
        FinancialTransaction::create([
            'church_id' => $church1->id,
            'transaction_code' => 'TXN-ZAKA-001',
            'member_id' => $createdMembers[2]->id, // Mzee Daudi Makundi
            'service_id' => $sundayWorship->id,
            'category' => 'tithe', // Zaka
            'amount' => 450000.00, // Tsh 450,000
            'currency' => 'TZS',
            'payment_method' => 'mobile_money',
            'reference_number' => 'MPESA-QRT89211',
            'transaction_date' => now()->subDays(6)->format('Y-m-d'),
            'notes' => 'Zaka ya Mwezi Oktoba - Imethibitishwa na kukabidhiwa kwa Mchungaji Kiongozi',
            'status' => 'confirmed',
            'entered_by' => $secretary->id,
            'approved_by' => $elder->id, // Imethibitishwa na Mzee wa Kanisa
            'approved_at' => now()->subDays(5),
        ]);

        FinancialTransaction::create([
            'church_id' => $church1->id,
            'transaction_code' => 'TXN-ZAKA-002',
            'member_id' => $createdMembers[7]->id, // Ezekiel Mshana
            'service_id' => $sundayWorship->id,
            'category' => 'tithe',
            'amount' => 600000.00, // Tsh 600,000
            'currency' => 'TZS',
            'payment_method' => 'bank_transfer',
            'reference_number' => 'CRDB-TX-771290',
            'transaction_date' => now()->subDays(6)->format('Y-m-d'),
            'notes' => 'Bahasha ya Zaka - Imethibitishwa na kuwasilishwa moja kwa moja kwa Mchungaji',
            'status' => 'confirmed',
            'entered_by' => $secretary->id,
            'approved_by' => $elder->id,
            'approved_at' => now()->subDays(5),
        ]);

        // Sadaka za Kawaida (Hizi ndizo zinazobaki kwenye hazina ya kanisa)
        FinancialTransaction::create([
            'church_id' => $church1->id,
            'transaction_code' => 'TXN-SADAKA-003',
            'member_id' => null,
            'donor_name' => 'Usharika Mzima wa EAGT Golani',
            'service_id' => $sundayWorship->id,
            'category' => 'regular_offering',
            'amount' => 1850000.00, // Tsh 1,850,000
            'currency' => 'TZS',
            'payment_method' => 'cash',
            'transaction_date' => now()->subDays(6)->format('Y-m-d'),
            'notes' => 'Sadaka ya Jumapili Kuu - Kuhesabiwa na Mashemasi',
            'status' => 'confirmed',
            'entered_by' => $treasurer->id,
            'approved_by' => $pastor->id,
            'approved_at' => now()->subDays(5),
        ]);

        FinancialTransaction::create([
            'church_id' => $church1->id,
            'transaction_code' => 'TXN-UJENZI-004',
            'member_id' => $createdMembers[2]->id,
            'service_id' => $sundayWorship->id,
            'category' => 'building_offering',
            'amount' => 2000000.00, // Tsh 2,000,000
            'currency' => 'TZS',
            'payment_method' => 'bank_transfer',
            'reference_number' => 'NMB-TRAN-881204',
            'transaction_date' => now()->subDays(9)->format('Y-m-d'),
            'notes' => 'Ahadi ya ujenzi wa ghorofa ya Hekalu jipya Golani',
            'status' => 'confirmed',
            'entered_by' => $treasurer->id,
            'approved_by' => $elder->id,
            'approved_at' => now()->subDays(8),
        ]);

        // Miamala Inayosubiri Uthibitisho (Pending Dual-Control)
        FinancialTransaction::create([
            'church_id' => $church1->id,
            'transaction_code' => 'TXN-PEND-005',
            'member_id' => $createdMembers[3]->id, // Mama Neema Mwambungu
            'service_id' => $sundayWorship->id,
            'category' => 'thanksgiving',
            'amount' => 500000.00, // Tsh 500,000
            'currency' => 'TZS',
            'payment_method' => 'cash',
            'transaction_date' => now()->subDays(1)->format('Y-m-d'),
            'notes' => 'Sadaka ya Shukrani kwa mtoto kufaulu vizuri mtihani wa kidato cha sita',
            'status' => 'pending',
            'entered_by' => $treasurer->id,
        ]);

        FinancialTransaction::create([
            'church_id' => $church1->id,
            'transaction_code' => 'TXN-PEND-006',
            'member_id' => $createdMembers[4]->id, // Emmanuel Lyimo
            'service_id' => $sundayWorship->id,
            'category' => 'tithe',
            'amount' => 350000.00, // Tsh 350,000 Zaka inayosubiri kuthibitishwa na Wazee ili iende kwa Mchungaji
            'currency' => 'TZS',
            'payment_method' => 'mobile_money',
            'reference_number' => 'TIGOPESA-98124',
            'transaction_date' => now()->subDays(1)->format('Y-m-d'),
            'notes' => 'Zaka ya Mwezi - Inasubiri Wazee wa Kanisa wathibitishe na kuikabidhi kwa Mchungaji',
            'status' => 'pending',
            'entered_by' => $secretary->id,
        ]);

        // 8. Matumizi ya Kanisa (Expenses)
        Expense::create([
            'church_id' => $church1->id,
            'expense_code' => 'EXP-UMEME-001',
            'title' => 'Malipo ya Umeme wa TANESCO (LUKU)',
            'category' => 'Utilities',
            'amount' => 380000.00, // Tsh 380,000
            'currency' => 'TZS',
            'expense_date' => now()->subDays(4)->format('Y-m-d'),
            'payment_method' => 'mobile_money',
            'recipient_name' => 'TANESCO Ubungo/Kimara',
            'description' => 'Ununuzi wa umeme wa LUKU wa mwezi kwa ajili ya Hekalu Kuu na ofisi za kanisa.',
            'status' => 'approved',
            'entered_by' => $treasurer->id,
            'approved_by' => $churchAdmin->id,
            'approved_at' => now()->subDays(3),
        ]);

        Expense::create([
            'church_id' => $church1->id,
            'expense_code' => 'EXP-MAJI-002',
            'title' => 'Bili ya Maji ya DAWASA',
            'category' => 'Utilities',
            'amount' => 125000.00, // Tsh 125,000
            'currency' => 'TZS',
            'expense_date' => now()->subDays(7)->format('Y-m-d'),
            'payment_method' => 'mobile_money',
            'recipient_name' => 'DAWASA Kimara',
            'description' => 'Bili ya maji safi ya kanisa na matumizi ya vyoo vya waumini.',
            'status' => 'approved',
            'entered_by' => $treasurer->id,
            'approved_by' => $churchAdmin->id,
            'approved_at' => now()->subDays(6),
        ]);

        Expense::create([
            'church_id' => $church1->id,
            'expense_code' => 'EXP-MAAFAT-003',
            'title' => 'Mfuko wa Huruma na Faraja (Wajane na Yatima)',
            'category' => 'Welfare',
            'amount' => 450000.00, // Tsh 450,000
            'currency' => 'TZS',
            'expense_date' => now()->subDays(10)->format('Y-m-d'),
            'payment_method' => 'cash',
            'recipient_name' => 'Kamati ya Ustawi wa Jamii EAGT Golani',
            'description' => 'Msaada wa unga, mchele na mafuta kwa wajane 8 na familia zenye uhitaji maalum Golani.',
            'status' => 'approved',
            'entered_by' => $treasurer->id,
            'approved_by' => $pastor->id,
            'approved_at' => now()->subDays(9),
        ]);

        // 9. Miradi ya Kanisa EAGT Golani
        $project1 = Project::create([
            'church_id' => $church1->id,
            'title' => 'Ujenzi wa Hekalu Jipya la Ghorofa - EAGT Golani',
            'project_type' => 'building',
            'estimated_cost' => 150000000.00, // Tsh Milioni 150
            'raised_amount' => 84500000.00,  // Tsh Milioni 84.5
            'spent_amount' => 62000000.00,   // Tsh Milioni 62
            'start_date' => '2025-03-01',
            'target_completion_date' => '2027-12-31',
            'status' => 'in_progress',
            'location' => 'Kiwanja cha Kanisa, Mtaa wa Golani, Kimara-Suka',
            'leader_name' => 'Mzee Daudi Makundi & Mhandisi Amani Kavishe',
            'description' => 'Ujenzi wa Hekalu la kisasa lenye uwezo wa kuchukua waumini 1,200, vyumba vya mafundisho ya watoto na ofisi za wachungaji.',
            'created_by' => $churchAdmin->id,
        ]);

        $project2 = Project::create([
            'church_id' => $church1->id,
            'title' => 'Mfumo wa Kisasa wa Vyombo vya Sauti na Matangazo (Media)',
            'project_type' => 'equipment',
            'estimated_cost' => 18000000.00, // Tsh Milioni 18
            'raised_amount' => 18000000.00,
            'spent_amount' => 17400000.00,
            'start_date' => '2026-01-15',
            'target_completion_date' => '2026-03-20',
            'status' => 'completed',
            'location' => 'Chumba cha Sauti na Matangazo (Media Control Room)',
            'leader_name' => 'Mwl. Emmanuel Lyimo & Kaka Baraka Mwakyoma',
            'description' => 'Ununuzi wa Digital Audio Console, vipaza sauti visivyo na waya (Shure Wireless), na kamera za kurusha ibada Mubashara (Live).',
            'created_by' => $churchAdmin->id,
        ]);

        // 10. Mali za Kanisa (Assets)
        Asset::create([
            'church_id' => $church1->id,
            'project_id' => $project1->id,
            'name' => 'Hati Halisi ya Umiliki wa Kiwanja cha Kanisa Golani (Eka 2.5)',
            'asset_code' => 'EAGT-LND-001',
            'category' => 'Land',
            'purchase_date' => '2016-08-10',
            'purchase_price' => 120000000.00,
            'current_value' => 280000000.00,
            'condition' => 'good',
            'location' => 'Golani, Kimara-Suka, Dar es Salaam',
            'serial_number' => 'HATI-WIZARA-DAR/GLN/44120',
            'warranty_info' => 'Hati miliki ya kudumu (Title Deed) imehifadhiwa salama kwenye sanduku la benki ya NMB.',
            'maintenance_notes' => 'Mipaka imewekwa mawe na uzio wa ukuta umekamilika.',
        ]);

        Asset::create([
            'church_id' => $church1->id,
            'project_id' => $project2->id,
            'name' => 'Digital Audio Mixer Behringer X32 (32 Channels)',
            'asset_code' => 'EAGT-AV-002',
            'category' => 'Audio/Visual',
            'purchase_date' => '2026-02-10',
            'purchase_price' => 9500000.00,
            'current_value' => 9500000.00,
            'condition' => 'new',
            'location' => 'Meza Kuu ya Vyombo - Hekalu la Golani',
            'serial_number' => 'BHR-X32-TZ-992144',
            'warranty_info' => 'Waranti ya miaka 2 kutoka kwa mawakala wa Yamaha/Behringer Dar es Salaam.',
        ]);

        Asset::create([
            'church_id' => $church1->id,
            'project_id' => null,
            'name' => 'Basi la Kanisa Toyota Coaster (Viti 30)',
            'asset_code' => 'EAGT-VEH-003',
            'category' => 'Vehicle',
            'purchase_date' => '2023-04-18',
            'purchase_price' => 65000000.00,
            'current_value' => 55000000.00,
            'condition' => 'good',
            'location' => 'Maegesho ya Kanisa Golani',
            'serial_number' => 'USAJILI: T 418 DXA',
            'warranty_info' => 'Bima kubwa ya mwaka mzima (Comprehensive Insurance) na ukaguzi wa LATRA.',
            'maintenance_notes' => 'Huduma ya kubadili oil na breki inafanyika kila baada ya kilomita 5,000.',
        ]);

        // 11. Maombi ya Siri na ya Kawaida
        PrayerRequest::create([
            'church_id' => $church1->id,
            'member_id' => $createdMembers[0]->id,
            'requester_name' => 'Dada Rehema Swai',
            'requester_phone' => '+255 715 888 999',
            'category' => 'Healing',
            'request_text' => 'Tafadhali tunaomba maombi ya uponyaji kwa ajili ya mama mzazi aliyelazwa Hospitali ya Taifa Muhimbili akisumbuliwa na shinikizo la damu.',
            'is_confidential' => false,
            'status' => 'praying',
            'pastoral_notes' => 'Mchungaji alifanya ziara ya kumwombea wodini na hali yake inazidi kuimarika kwa utukufu wa Mungu.',
        ]);

        PrayerRequest::create([
            'church_id' => $church1->id,
            'member_id' => $createdMembers[6]->id,
            'requester_name' => 'Dada Joyce Massawe',
            'requester_phone' => '+255 784 112 233',
            'category' => 'Family',
            'request_text' => 'Ombi la siri: Maombi na ushauri wa kichungaji kuhusu amani ya ndoa na changamoto za kiroho katika familia.',
            'is_confidential' => true, // YA SIRI KABISA - Wachungaji na Wazee pekee!
            'status' => 'praying',
            'pastoral_notes' => 'Kikao cha kwanza cha ushauri na maombi kilifanyika ofisi ya Mchungaji. Kikao cha pili kimepangwa Jumanne ijayo.',
        ]);

        PrayerRequest::create([
            'church_id' => $church1->id,
            'member_id' => $createdMembers[1]->id,
            'requester_name' => 'Kaka Baraka Mwakyoma',
            'requester_phone' => '+255 765 222 333',
            'category' => 'Thanksgiving',
            'request_text' => 'Namshukuru Mungu sana kwa kupata kibali na mkataba mpya wa ajira wa miaka mitatu.',
            'is_confidential' => false,
            'status' => 'answered',
            'testimony' => 'Baada ya maombi ya kufunga na kuomba ya siku tatu kanisani, Mungu alifungua mlango usiotazamiwa!',
        ]);

        // 12. Matangazo na Matukio ya Kanisa
        Announcement::create([
            'church_id' => $church1->id,
            'title' => 'Mkutano Mkubwa wa Injili na Uamsho wa Kimara-Suka 2026',
            'content' => 'Uongozi wa Kanisa EAGT Golani unawatangazia waumini wote na jamii nzima kuwa kuanzia tarehe 10 hadi 16 mwezi ujao, kutakuwa na Mkutano Mkuu wa Injili uwanja wa Kimara-Suka. Waimbaji mbalimbali na wahudumu wa kitaifa watahudumu.',
            'priority' => 'urgent',
            'audience' => 'all',
            'publish_date' => now()->subDays(2)->format('Y-m-d'),
            'expires_at' => now()->addDays(30)->format('Y-m-d'),
            'is_pinned' => true,
            'posted_by' => $pastor->id,
        ]);

        Event::create([
            'church_id' => $church1->id,
            'title' => 'Mkesha Mkuu wa Shukrani na Kuinua Sifa - EAGT Golani',
            'description' => 'Mkesha wa sifa zisizo na kikomo, uimbaji wa kwaya zote za kanisa, na maombezi ya pekee kwa ajili ya taifa na familia.',
            'location' => 'Hekalu Kuu la EAGT Golani, Kimara-Suka',
            'start_time' => now()->addDays(5)->setTime(21, 30),
            'end_time' => now()->addDays(6)->setTime(5, 0),
            'color' => '#1e3a8a',
            'is_public' => true,
            'created_by' => $pastor->id,
        ]);

        // 13. YouTube Sermons - Mahubiri ya EAGT Golani
        YoutubeVideo::create([
            'church_id' => $church1->id,
            'title' => 'Somo: Je, Umegeuzwa Kuwa Mtu Mwingine? | Mchungaji Lukas J. Kittu',
            'video_url' => 'https://www.youtube.com/watch?v=DGN4B4CFn3g',
            'youtube_id' => 'DGN4B4CFn3g',
            'is_live' => false,
            'preacher_name' => 'Mchungaji Lukas J. Kittu',
            'sermon_series' => 'Kugeuzwa na Roho Mtakatifu (1 Samweli 10:6)',
            'sermon_date' => now()->subDays(3)->format('Y-m-d'),
            'description' => 'Mahubiri ya Neno la Mungu kutoka kwa Mchungaji Kiongozi Lukas J. Kittu katika Hekalu Kuu la EAGT Golani, Kimara-Suka Dar es Salaam: "Naye Roho wa BWANA atakujilia kwa nguvu, nawe utatabiri pamoja nao, nawe UTAGEUZWA kuwa mtu mwingine." (1 Samweli 10:6). Sikiliza ujumbe huu upokee upako na mpenyo wa maisha yako.',
            'added_by' => $secretary->id,
        ]);

        // 14. Kumbukumbu za Ukaguzi (Audit Log)
        AuditLog::create([
            'church_id' => $church1->id,
            'user_id' => $superAdmin->id,
            'user_name' => 'Msimamizi Mkuu',
            'action' => 'created',
            'entity_type' => 'Church',
            'entity_id' => $church1->id,
            'description' => 'Usajili na uanzishwaji rasmi wa mfumo wa EVANJELIST ASSEMBLIES OF GOD TANZANIA (EAGT) - Golani, Kimara-Suka.',
            'ip_address' => '127.0.0.1',
            'created_at' => now()->subDays(30),
        ]);
    }
}
