<?php


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDashboardView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW dashboard_view AS
        SELECT
            companies.id,
            (SELECT COUNT(*) FROM candidates
                WHERE candidates.company_id = companies.id AND candidates.is_active = 'Active'
            ) AS total_candidates,
            (SELECT COUNT(*) FROM users
                WHERE users.company_id = companies.id AND users.is_active = 'Active'
            ) AS total_users,
            (SELECT COUNT(*) FROM candidates
                WHERE candidates.company_id = companies.id AND candidates.is_active = 'Active' AND candidates.created_at >= NOW() - INTERVAL 90 DAY
            ) AS total_last90_days_candidate
        FROM companies WHERE companies.is_active = 'Active'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dashboard_view');
    }

}



