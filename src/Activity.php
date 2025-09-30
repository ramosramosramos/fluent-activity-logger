<?php

declare(strict_types=1);

namespace KentJerone\ActivityLogger;

use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class Activity
{
    /**
     * @var Model|null
     */
    protected ?Model $made_by_model = null;

    /**
     * @var string|null
     */
    protected ?string $human_message = null;

    /**
     * @var string[]|null
     */
    protected ?array $human_extra_message = null;

    /**
     * @var string|null
     */
    protected ?string $developer_message = null;

    /**
     * @var string[]|null
     */
    protected ?array $developer_extra_message = null;

    /**
     * @var string[]|null
     */
    protected ?array $application_extra_message = null;

    public static function make(): self
    {

        return new self();
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return Activity
     */
    public function madeByModel(Model $model): self
    {
        if ($model->getKey()) {
            $this->made_by_model = $model;
        }

        return $this;
    }

    /**
     * @param  string  $message
     * @return Activity
     */
    public function humanMessage(string $message): self
    {
        $this->human_message = $message;

        return $this;
    }

    /**
     * @param  string[]  $message
     * @return Activity
     */
    public function humanExtraMessage(array $message): self
    {
        $this->human_extra_message = $message;

        return $this;
    }

    public function developerMessage(string $message): self
    {
        $this->developer_message = $message;

        return $this;
    }

    /**
     * @param  string[]  $message
     * @return Activity
     */
    public function developerExtraMessage(array $message): self
    {
        $this->developer_extra_message = $message;

        return $this;
    }

    /**
     * @param  string[]  $message
     * @return Activity
     */
    public function applicationExtraMessage(array $message): self
    {
        $this->application_extra_message = $message;

        return $this;
    }

    /**
     * @return ActivityLog|null
     */
    public function create(): ?ActivityLog
    {

        if (
            empty($this->human_message) &&
            empty($this->human_extra_message) &&
            empty($this->developer_message) &&
            empty($this->developer_extra_message) &&
            empty($this->application_extra_message)
        ) {
            throw new RuntimeException(
                'At least one or more fields (humanMessage, humanExtraMessage, developerMessage, developerExtraMessage, applicationExtraMessage) must be set before calling create().'
            );
        }

        return createActivityLog(
            made_by_model: $this->made_by_model ?? auth()->user(),
            human_message: $this->human_message,
            human_extra_message: $this->human_extra_message,
            developer_message: $this->developer_message,
            developer_extra_message: $this->developer_extra_message,
            application_extra_message: $this->application_extra_message
        );
    }
}
