<?php

namespace Tests\Feature;

use App\Models\Application;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    public function test_guest_cannot_create_application()
    {
        $application = Application::factory()->make();

        $this->postJson('/api/applicaitons', [
            $application,
        ])
            ->assertUnauthorized();
    }

    public function test_authenticated_user_can_create_application()
    {
        $this->authenticated();

        $application = Application::factory()->make();

        $this->postJson('/api/applicaitons', [
            $application
        ])
            ->assertStatus(201)
            ->assertJson([
                'message' => 'Applicatoin created successfully'
            ]);

        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'position' => $application->position,
            'link' => $application->link,
            'contact' => $application->contact,
            'applied_date' => $application->applied_date,
            'interview_date' => $application->interview_date,
            'salary' => $application->salary,
            'feedback' => $application->feedback,
            'status_id' => $application->status_id,
            'company_id' => $application->company_id,
            'city_id' => $application->city_id,
            'modality_id' => $application->modality_id,
            'contract_id' => $application->contract_id,
            'category_id' => $application->category_id,
        ]);
    }
}
