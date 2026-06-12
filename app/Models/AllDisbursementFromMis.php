<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllDisbursementFromMis extends Model
{
    use HasFactory;


    protected $fillable = [
        "ActivityID",
        "Date",
        "nepali_year",
        "nepali_month",
        "nepali_day",
        "Amount",
        "TransactionTypeID",
        "PaymentType",
        "Balance",
        "IsDisbursement",
        "IsRepayment",
        "IsIntCap",
        "MicrobankTransactionType",
        "SN",
        "Code",
        "ProjectName",
        "Name",
        "TownName",
    ];
}
