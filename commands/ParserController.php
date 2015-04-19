<?php
namespace app\commands;

use yii\console\Controller;
use app\models\Service;
use app\components\ParserService;
use yii\helpers\ArrayHelper;

/**
 * This command runs parser processor to receive data from source sites
 *
 */
class ParserController extends Controller
{
    public $debug=false;
    /**
     * Performs real run of service
     * @param $obService
     */
    private function _run(Service $obService) {
        $obParser=$obService->getParser();
        if($obParser->process()) {
            $obService->last_call=date('Y-m-d H:i:s');
            $obService->save();
        }
    }

    /**
     * This command runs all available processors
     */
    public function actionIndex()
    {
        foreach(Service::find()->all() as $key=>$obService) {
            $this->_run($obService);
        }
    }

    /**
     * This command runs processor with particular ID
     * @param $id
     */
    public function actionRun($id) {
        $obService=Service::findOne(['id'=>$id]);
        if($obService) {
            $this->_run($obService);
        }
    }

    /**
     * This command lists all available processors
     */
    public function actionList() {
        foreach(Service::find()->all() as $key=>$obService) {
            echo str_pad($obService->id,10,' ',STR_PAD_RIGHT).$obService->title."\n";
        }
    }
}