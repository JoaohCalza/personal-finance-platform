<?php

namespace Tests\Feature\Filament;

use Filament\Facades\Filament;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    public function test_guests_are_redirected_to_the_admin_login_page(): void
    {
        $response = $this->get(route('filament.admin.pages.dashboard'));

        $response->assertRedirect(route('filament.admin.auth.login'));
    }

    public function test_admin_dashboard_does_not_show_filament_information_widget(): void
    {
        $widgets = Filament::getPanel('admin')->getWidgets();

        $this->assertContains(AccountWidget::class, $widgets);
        $this->assertNotContains(FilamentInfoWidget::class, $widgets);
    }
}
