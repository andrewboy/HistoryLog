<?php namespace Andrewboy\HistoryLog\Handlers\Events;

use \Illuminate\Database\Eloquent\Model;
use Andrewboy\HistoryLog\Models\HistoryLog;

class ModelEventObserver
{

    /**
     * Savig event handler callback, when fired, it sets the modified attributes
     * @param Model $model
     * @return boolean True
     */
    public function saving(Model $model)
    {
        $model->setModifiedAttributes();

        return true;
    }

    /**
     * Saved event handler callback, when fired, create a history log
     * @param Model $model
     * @return void
     */
    public function saved(Model $model)
    {
        $this->performAction($model, 'saved');
        $model->clearModifiedAttributes();
    }

    /**
     * Perform the action
     * @param Model $model
     * @param type $event
     * @return HistoryLog|null Returns null when nothing changes
     */
    public function performAction(Model $model, $event)
    {
        $modelPrevState = $model->getPrevState();
        $changedValues = $model->getModifiedAttributes();
        $history = new HistoryLog;
        
        if (count($changedValues)) {
            $history->version = $modelPrevState ? $modelPrevState->version + 1 : 0;
            $history->model_type = get_class($model);
            $history->model_id = $model->id;
            $history->user_id = $model->getUserId();
            $history->changed_value = json_encode($changedValues);
            $history->save();
        }
        
        return $history;
    }
}
