<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Program;


class ProgramDisbursementSummary extends Model
{

    use HasFactory;


    protected $table = "program_disbursement_summary";

    public $incrementing = false;


    protected $fillable = [
        "id",
        "program_id",
        "program_name",
        "total_disbursement_amount",
        "total_principal_amount",
        "total_interest_amount"
    ];


    public function program()
    {
        return $this->belongsTo(Program::class, "program_id");
    }
}
