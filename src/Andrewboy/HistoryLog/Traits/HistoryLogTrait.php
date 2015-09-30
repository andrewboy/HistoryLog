<?php namespace Andrewboy\HistoryLog\Traits;

use Andrewboy\HistoryLog\Handlers\Events\ModelEventObserver;
use Andrewboy\HistoryLog\Models\HistoryLog;

trait HistoryLogTrait
{

    /**
     * Store the differences between new and old one
     * @var array $attributesHistory
     */
    protected $attributesHistory = [];

    /**
     * Boot up the observer
     */
    public static function bootHistoryLogTrait()
    {
        static::observe(new ModelEventObserver);
    }

    /**
     * Get the previous state of the model
     *
     * @return Collection | null Collection on success
     */
    public function getPrevState()
    {
        return $this->getStates();
    }

    /**
     * Set the attributesHistory
     */
    public function setModifiedAttributes()
    {
        if ($this->isDirty()) {
            $originalAttributes = $this->getOriginal();

            foreach ($this->getDirty() as $key => $val) {
                $this->attributesHistory[$key] = [
                    'old' => array_key_exists($key, $originalAttributes) ? $originalAttributes[$key] : null,
                    'new' => $val
                ];
            }
        }
    }

    /**
     * Get the modified attributes
     * @return array Modified attributes
     */
    public function getModifiedAttributes()
    {
        return $this->attributesHistory;
    }

    /**
     * Clear the attributesHistory
     */
    public function clearModifiedAttributes()
    {
        $this->attributesHistory = [];
    }

    /**
     * Get the Model current version number
     *
     * @return integer | null Integer on success
     */
    public function getCurrentVersion()
    {
        $lastState = $this->getStates();

        return $lastState ? $lastState->version : null;
    }

    /**
     * Get the state of the given version number
     * @param integer $versionNumber
     * @return Collection | null Collection on success
     */
    public function getState($versionNumber = 1)
    {
        return HistoryLog::where('model_id', $this->id)
                ->where('model_type', get_class($this))
                ->where('version', $versionNumber)
                ->orderBy('created_at', 'desc')
                ->first();
    }

    /**
     * Get the Model history states
     * @param integer $limit
     * @param integer $offset
     * @return Collection | null Collection on success
     */
    public function getStates($limit = 1, $offset = 0)
    {
        return HistoryLog::where('model_id', $this->id)
                ->where('model_type', get_class($this))
                ->orderBy('created_at', 'desc')
                ->offset($offset)
                ->limit($limit)
                ->get();
    }

    /**
     * Get the current users' ID
     * @return integer | null Integer on success
     */
    abstract function getUserId();
}
