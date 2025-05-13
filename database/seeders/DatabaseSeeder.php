<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Job;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $recruiterRole = Role::firstOrCreate(['name' => 'Recruiter']);
        $managerRole = Role::firstOrCreate(['name' => 'Manager']);

        // Create permissions
        $permissions = [
            'manage_users' => Permission::firstOrCreate(['name' => 'manage_users']),
            'manage_roles' => Permission::firstOrCreate(['name' => 'manage_roles']),
            'manage_jobs' => Permission::firstOrCreate(['name' => 'manage_jobs']),
            'view_applications' => Permission::firstOrCreate(['name' => 'view_applications']),
        ];

        // Assign permissions to roles
        $adminRole->permissions()->sync($permissions);
        $recruiterRole->permissions()->sync([
            $permissions['manage_jobs'],
            $permissions['view_applications'],
        ]);
        $managerRole->permissions()->sync([
            $permissions['view_applications'],
        ]);

        // Assign admin role to admin user
        $admin->roles()->sync([$adminRole->id]);

        // Create sample jobs
        $jobs = [
            [
                'title' => 'Senior Software Engineer',
                'department' => 'engineering',
                'type' => 'full-time',
                'experience_level' => 'senior',
                'location' => 'New York, NY',
                'is_remote' => true,
                'salary_range' => '$120,000 - $150,000',
                'application_deadline' => now()->addDays(30),
                'description' => 'We are looking for a Senior Software Engineer to join our team...',
                'requirements' => '5+ years of experience in software development...',
                'skills_required' => ['PHP', 'Laravel', 'JavaScript', 'Vue.js'],
                'benefits' => ['Health Insurance', '401k', 'Remote Work', 'Flexible Hours'],
                'status' => 'open',
            ],
            [
                'title' => 'Marketing Manager',
                'department' => 'marketing',
                'type' => 'full-time',
                'experience_level' => 'mid',
                'location' => 'San Francisco, CA',
                'is_remote' => false,
                'salary_range' => '$90,000 - $110,000',
                'application_deadline' => now()->addDays(20),
                'description' => 'Join our marketing team as a Marketing Manager...',
                'requirements' => '3+ years of marketing experience...',
                'skills_required' => ['Digital Marketing', 'SEO', 'Social Media', 'Analytics'],
                'benefits' => ['Health Insurance', '401k', 'Gym Membership', 'Professional Development'],
                'status' => 'open',
            ],
            [
                'title' => 'Sales Representative',
                'department' => 'sales',
                'type' => 'full-time',
                'experience_level' => 'entry',
                'location' => 'Chicago, IL',
                'is_remote' => false,
                'salary_range' => '$60,000 - $80,000',
                'application_deadline' => now()->addDays(15),
                'description' => 'We are seeking a motivated Sales Representative...',
                'requirements' => '1+ years of sales experience...',
                'skills_required' => ['Sales', 'Communication', 'Negotiation', 'CRM'],
                'benefits' => ['Health Insurance', 'Commission', 'Car Allowance', 'Training'],
                'status' => 'open',
            ],
        ];

        foreach ($jobs as $job) {
            Job::firstOrCreate(
                ['title' => $job['title']],
                $job
            );
        }

        // Create additional users
        $users = [
            [
                'name' => 'John Recruiter',
                'email' => 'recruiter@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Sarah Manager',
                'email' => 'manager@example.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $index => $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
            $user->roles()->sync([$index === 0 ? $recruiterRole->id : $managerRole->id]);
        }
    }
}
