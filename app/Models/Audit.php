<?php

namespace App\Models;

use App\Http\Filters\AuditFilter;
use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends \OwenIt\Auditing\Models\Audit
{
    use HasFactory;
    use Filterable;

    protected $filter = AuditFilter::class;

    public function getPerPage()
    {
        return request('perPage', parent::getPerPage());
    }
    /**
     * {@inheritdoc}
     */
    public function order()
    {
        return $this->morphTo();
    }
    /**
     * {@inheritdoc}
     */
    public function offer()
    {
        return $this->morphTo();
    }
    /**
     * {@builder}
     */
    public function scopeEvent($event)
    {
        dd($event);
        switch ($event)
        {
            case 'create':
                return trans("audits.events.create");
                break;
            case 'update':
                return trans("audits.events.update");
                break;
            case 'delete':
                return trans("audits.events.delete");
                break;
            default:
                return 'حدث';
        }
    }
}
