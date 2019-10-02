<?php
namespace BennoThommo\GoogleFaqs\Classes;

use Event;
use BennoThommo\GoogleFaqs\Classes\Handlers\ControllerHandler;
use BennoThommo\GoogleFaqs\Classes\Handlers\ModelHandler;
use October\Rain\Exception\ApplicationException;

class PluginHandler
{
    use \October\Rain\Support\Traits\Singleton;

    /**
     * Registered controllers.
     *
     * Controllers map to a handler that will handle the `backend.form.extendFields` event.
     *
     * @var array
     */
    protected $controllers = [];

    /**
     * Registered models.
     *
     * Models map to a handler that will handle the `model.afterSave` and `model.afterFetch` events.
     *
     * @var array
     */
    protected $models = [];

    /**
     * Initialize this singleton.
     *
     * @return void
     */
    protected function init()
    {
    }

    public function registerController(string $controllerClass, string $handler)
    {
        if (!class_exists($controllerClass)) {
            // Allows us to specify handlers for controllers belonging to plugins that may not be installed.
            return;
        }
        if (!class_exists($handler)) {
            throw new ApplicationException(
                'Handler "' . $handler . '" does not exist and cannot be registered.'
            );
        }
        if (!is_subclass_of($handler, ControllerHandler::class)) {
            throw new ApplicationException(
                'Handler "' . $handler . '" does not appear to be a valid controller handler.'
            );
        }

        $this->controllers[$controllerClass] = $handler;
    }

    public function registerModel(string $modelClass, string $handler)
    {
        if (!class_exists($modelClass)) {
            // Allows us to specify handlers for models belonging to plugins that may not be installed.
            return;
        }
        if (!class_exists($handler)) {
            throw new ApplicationException('Handler "' . $handler . '" does not exist and cannot be registered.');
        }
        if (!is_subclass_of($handler, ModelHandler::class)) {
            throw new ApplicationException(
                'Handler "' . $handler . '" does not appear to be a valid model handler.'
            );
        }

        $this->models[$modelClass] = $handler;
    }

    /**
     * Attaches the event handlers.
     *
     * @return void
     */
    public function attachEvents()
    {
        if (count($this->controllers)) {
            Event::listen('backend.form.extendFields', function (\Backend\Widgets\Form $formWidget) {
                $widgetController = get_class($formWidget->getController());
                $foundHandler = null;

                foreach ($this->controllers as $controller => $handler) {
                    if ($controller === $widgetController) {
                        $foundHandler = new $handler;
                        break;
                    }
                }

                if (!isset($foundHandler)) {
                    return;
                }

                $foundHandler->extendFields($formWidget);
            });
        }

        if (count($this->models)) {
            foreach ($this->models as $model => $handler) {
                $model::extend(function ($model) use ($handler) {
                    $model->bindEvent('model.afterFetch', function () use ($model, $handler) {
                        $handlerInstance = new $handler;
                        $handlerInstance->afterFetch($model);
                    });

                    $model->bindEvent('model.afterSave', function () use ($model, $handler) {
                        $handlerInstance = new $handler;
                        $handlerInstance->afterSave($model);
                    });
                });
            }
        }
    }
}
