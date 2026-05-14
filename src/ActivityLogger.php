<?php

namespace MohitHasan\ActivityLogger;

use MohitHasan\ActivityLogger\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    protected ?string $action = null;
    protected ?string $description = null;
    protected ?Model $loggable = null;
    protected array $metadata = [];
    protected ?int $userId = null;

    public function action(string $action): self
    {
        $this->action = $action;
        return $this;
    }

    public function description(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function on(Model $loggable): self
    {
        $this->loggable = $loggable;
        return $this;
    }

    public function with(array $metadata): self
    {
        $this->metadata = $metadata;
        return $this;
    }

    public function by(?int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function log(): ?ActivityLog
    {
        try {
            $userId = $this->userId ?? optional(auth()->user())->id;
            $ip = null;
            $userAgent = null;

            $captureFields = config('activity-logger.capture_fields', []);
            if (($captureFields['ip_address'] ?? true) && app()->bound('request')) {
                $ip = request()->ip();
            }
            if (($captureFields['user_agent'] ?? true) && app()->bound('request')) {
                $userAgent = request()->userAgent();
            }

            $data = [
                'user_id' => $userId,
                'action' => $this->action ?? 'custom',
                'description' => $this->description,
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'metadata' => !empty($this->metadata) ? $this->metadata : null,
            ];

            if ($this->loggable) {
                $data['loggable_type'] = get_class($this->loggable);
                $data['loggable_id'] = $this->loggable->getKey();
            }

            return ActivityLog::create($data);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function getAll(?string $action = null, ?Model $for = null)
    {
        $query = ActivityLog::query();

        if ($action) {
            $query->where('action', $action);
        }

        if ($for) {
            $query->where('loggable_type', get_class($for))
                  ->where('loggable_id', $for->getKey());
        }

        return $query->latest()->get();
    }
}
