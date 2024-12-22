<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            ["Clean up your office space", "Organize your desk and remove any clutter to create a more productive environment."],
            ["Prepare a presentation for tomorrow", "Create and finalize the slides for your upcoming presentation, ensuring clarity and relevance."],
            ["Write a report from the last meeting", "Summarize key points and action items from the recent meeting in a clear report."],
            ["Update the data in the spreadsheet", "Ensure all data is current, accurate, and properly organized in the spreadsheet."],
            ["Call the client about their order", "Reach out to the client to provide updates or clarify any questions about their order."],
            ["Update the database", "Make sure the database is up-to-date with the latest information and entries."],
            ["Prepare a to-do list", "Create a list of tasks to be completed for the day or week to stay organized."],
            ["Install the new software on your computer", "Download and set up the latest version of the software required for your work."],
            ["Make a backup of important files", "Create a backup of your crucial files to avoid data loss in case of system failure."],
            ["Check your emails and respond to urgent ones", "Go through your inbox, prioritize important messages, and reply to urgent ones."],
            ["Organize a team meeting", "Schedule and prepare the agenda for an upcoming team meeting to discuss important topics."],
            ["Update the project schedule", "Review and adjust the timeline of the project to ensure deadlines are met."],
            ["Clean up your workspace", "Tidy up your physical and digital workspace to maintain focus and productivity."],
            ["Read the report you received", "Go through the report you received and highlight the main takeaways."],
            ["Check inventory levels in the warehouse", "Ensure stock levels are correct and report any discrepancies."],
            ["Update the project documentation", "Review and add new details to the project documentation to keep it current."],
            ["Update the passwords for company accounts", "Ensure all company accounts have secure and updated passwords."],
            ["Plan your work for the next week", "Organize tasks and priorities for the upcoming week to stay ahead of deadlines."],
            ["Do research on new tools", "Investigate new software or tools that could improve your workflow."],
            ["Start working on the new project", "Begin the initial steps for the new project, including planning and task assignment."],
            ["Run tests on the new software", "Test the new software to identify any bugs or issues before its official rollout."],
            ["Share your research findings with the team", "Present your research results to the team and discuss next steps."],
            ["Prepare a proposal for a new client", "Create a detailed proposal outlining services and costs for a potential new client."],
            ["Update the contact information in the CRM system", "Ensure all client and prospect contact details are current in the CRM system."],
            ["Organize a training session for new employees", "Plan and deliver a training session for new hires to ensure they are onboarded smoothly."],
            ["Sort out your documents", "Organize your physical and digital documents into appropriate folders."],
            ["Contact IT about the system outage", "Reach out to the IT department to report and resolve any system or network issues."],
            ["Check the project budget status", "Review the current project budget and ensure expenses are in line with projections."],
            ["Prepare marketing materials", "Design or update marketing materials such as flyers, brochures, or social media content."],
            ["Conduct a competitor analysis", "Research and analyze competitors' products, services, and strategies to inform your own work."]
        ];

        $userIds = DB::table('users')->pluck('id');
        $priorityIds = DB::table('task_priorities')->pluck('id');
        $statusIds = DB::table('task_statuses')->pluck('id');
        for ($i = 0; $i < 25; $i++) {
            DB::table('tasks')->insert([
                'id' => Str::uuid()->toString(),
                'name' => $tasks[$i][0],
                'description' => $tasks[$i][1],
                'user_id' => $userIds->random(),
                'task_priorities_id' => $priorityIds->random(),
                'task_statuses_id' => $statusIds->random(),
                'completion_date' => Carbon::now()->addDays(rand(1, 30)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        };
    }
}
