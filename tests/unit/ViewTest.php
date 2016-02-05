<?php

class ViewTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \pwf\basic\View::render
     */
    public function testMe()
    {
        $view = Codeception\Util\Stub::make('\pwf\basic\View');

        $this->assertEquals(file_get_contents(__DIR__.'/../_data/testViewResult.html'),
            $view->render(__DIR__.'/../_data/testView.html',
                [
                'title' => 'Title',
                'body' => 'Hello, World!'
        ]));
    }
}