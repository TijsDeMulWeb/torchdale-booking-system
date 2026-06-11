<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['customer_id', 'coupon_id', 'total', 'subtotal', 'discount', 'vat_rate', 'vat_amount', 'status', 'payment_method', 'invoice_number', 'privacy_policy_legal_document_id', 'terms_conditions_legal_document_id'])]
class Order extends Model
{
    use SoftDeletes;
    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function orderedItems()
    {
        return $this->hasMany(OrderedItem::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function privacyPolicyDocument()
    {
        return $this->belongsTo(LegalDocument::class, 'privacy_policy_legal_document_id');
    }

    public function termsConditionsDocument()
    {
        return $this->belongsTo(LegalDocument::class, 'terms_conditions_legal_document_id');
    }
}
