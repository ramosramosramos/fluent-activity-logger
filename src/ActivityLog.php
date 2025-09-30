<?php

declare(strict_types=1);

namespace KentJerone\ActivityLogger;

use Illuminate\Database\Eloquent\Model;

final class ActivityLog extends Model
{
    public function __construct(array $attributes = [])
    {

        if (!isset($this->table)) {
            $this->setTable(config()->string('activitylogger.table_name'));
        }

        parent::__construct($attributes);
    }
    protected $fillable = [
        'made_by_model_id',
        'made_by_model_type',

        // json
        'human_message',
        'human_extra_message',

        'application_message',
        'application_extra_message',

        'developer_message',
        'developer_extra_message',

    ];

    protected $casts = [
        // json
        'human_message' => 'array',
        'human_extra_message' => 'array',

        'developer_message' => 'array',
        'developer_extra_message' => 'array',

        'application_message' => 'array',
        'application_extra_message' => 'array',
    ];


}
